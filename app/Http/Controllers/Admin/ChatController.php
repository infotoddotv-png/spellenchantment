<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $query = Ticket::query()->with('order')->latest('last_message_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $tickets = $query->get();

        $stats = [
            'open' => Ticket::where('status', 'open')->count(),
            'waiting_admin' => Ticket::where('status', 'waiting_admin')->count(),
            'replied' => Ticket::where('status', 'replied')->count(),
            'closed' => Ticket::where('status', 'closed')->count(),
        ];

        return view('admin.chat.index', compact('tickets', 'stats'));
    }

    public function show(Ticket $ticket)
    {
        $ticket->load('messages', 'order', 'user');
        return view('admin.chat.show', compact('ticket'));
    }

    public function store(Request $request, Ticket $ticket)
    {
        $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ]);

        TicketMessage::create([
            'ticket_id' => $ticket->id,
            'sender' => 'admin',
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        $ticket->update(['status' => 'replied', 'last_message_at' => now()]);

        AuditLog::record('ticket.admin_reply', "Admin replied to ticket #{$ticket->id}", $ticket);

        return back()->with('success', 'Reply sent to the customer.');
    }

    public function close(Ticket $ticket)
    {
        $ticket->update(['status' => 'closed']);
        AuditLog::record('ticket.closed', "Admin closed ticket #{$ticket->id}", $ticket);
        return back()->with('success', 'Ticket closed.');
    }
}
