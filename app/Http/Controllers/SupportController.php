<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    /**
     * List tickets for the logged-in customer.
     */
    public function index()
    {
        $user = Auth::user();
        $tickets = Ticket::where('user_id', $user->id)
            ->orWhere('email', $user->email)
            ->latest('last_message_at')
            ->get();

        return view('support.index', compact('tickets'));
    }

    /**
     * Show (or create) the support thread tied to a specific order.
     * Requires the order's email as proof of ownership (not just a guessable sequential ID),
     * unless the logged-in user already owns the order.
     */
    public function showForOrder(Request $request, Order $order)
    {
        $this->authorizeOrderAccess($request, $order);

        $ticket = Ticket::firstOrCreate(
            ['order_id' => $order->id],
            [
                'user_id' => $order->user_id,
                'name' => $order->name,
                'email' => $order->email,
                'subject' => "Order #{$order->id} support",
                'status' => 'open',
                'last_message_at' => now(),
            ]
        );

        $ticket->load('messages');

        return view('support.thread', ['ticket' => $ticket, 'order' => $order]);
    }

    public function storeForOrder(Request $request, Order $order)
    {
        $this->authorizeOrderAccess($request, $order);

        $data = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $ticket = Ticket::firstOrCreate(
            ['order_id' => $order->id],
            [
                'user_id' => $order->user_id,
                'name' => $order->name,
                'email' => $order->email,
                'subject' => "Order #{$order->id} support",
                'status' => 'open',
            ]
        );

        TicketMessage::create([
            'ticket_id' => $ticket->id,
            'sender' => 'customer',
            'user_id' => $order->user_id,
            'message' => $data['message'],
        ]);

        $ticket->update(['status' => 'waiting_admin', 'last_message_at' => now()]);

        AuditLog::record('ticket.customer_message', "New support message on ticket #{$ticket->id} (order #{$order->id})", $ticket);

        return back()->with('success', 'Message sent! Our team will reply here.');
    }

    /**
     * View a ticket owned by the authenticated user.
     */
    public function show(Ticket $ticket)
    {
        $this->authorizeAccess($ticket);
        $ticket->load('messages');

        return view('support.thread', ['ticket' => $ticket, 'order' => $ticket->order]);
    }

    public function reply(Request $request, Ticket $ticket)
    {
        $this->authorizeAccess($ticket);

        $data = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ]);

        TicketMessage::create([
            'ticket_id' => $ticket->id,
            'sender' => 'customer',
            'user_id' => $ticket->user_id,
            'message' => $data['message'],
        ]);

        $ticket->update(['status' => 'waiting_admin', 'last_message_at' => now()]);

        AuditLog::record('ticket.customer_message', "New support message on ticket #{$ticket->id}", $ticket);

        return back()->with('success', 'Message sent! Our team will reply here.');
    }

    private function authorizeAccess(Ticket $ticket): void
    {
        $user = Auth::user();
        abort_unless($user && ($ticket->user_id === $user->id || $ticket->email === $user->email), 403);
    }

    /**
     * Order IDs are sequential/guessable, so viewing or posting to an order's support
     * thread requires either being logged in as the order's owner, or proving knowledge
     * of the order's email address (same proof-of-ownership pattern as order lookup emails
     * used elsewhere in commerce checkouts — a bare ID is never sufficient on its own).
     */
    private function authorizeOrderAccess(Request $request, Order $order): void
    {
        $user = Auth::user();
        if ($user && $order->user_id === $user->id) {
            return;
        }

        $suppliedEmail = strtolower(trim((string) $request->input('email')));
        abort_unless($suppliedEmail !== '' && $suppliedEmail === strtolower($order->email), 403,
            'Enter the email address used for this order to view or contact support about it.');
    }
}
