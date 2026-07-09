<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\LibraryEntry;
use App\Models\BlogPost;
use App\Models\Testimonial;
use App\Models\Order;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with('category')
            ->where('featured', true)
            ->take(4)
            ->get();

        $libraryEntries = LibraryEntry::where('featured', true)->take(3)->get();
        $blogPosts      = BlogPost::where('featured', true)->take(3)->get();
        $testimonials   = Testimonial::take(6)->get();

        $stats = [
            'totalProducts'       => Product::count(),
            'totalLibraryEntries' => LibraryEntry::count(),
            'totalOrders'         => Order::count(),
            'totalBlogPosts'      => BlogPost::count(),
        ];

        return view('pages.home', compact(
            'featuredProducts', 'libraryEntries', 'blogPosts', 'testimonials', 'stats'
        ));
    }
}
