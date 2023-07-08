<?php

namespace App\Http\Controllers;

use App\Http\Middleware\HandleInertiaRequests;
use App\Models\Category;
use App\Models\Contact;
use Inertia\Inertia;


class ManagementController extends Controller
{
    public function categories()
    {
        return Inertia::render('Categories', [
            'categories' => Category::withCount("contacts")->get()
        ]);
    }
    public function contacts()
    {
        return Inertia::render('dashboard', [
            'contacts' => Contact::get()
        ]);
    }
}
