<?php

namespace App\Http\Controllers;

use App\Http\Middleware\HandleInertiaRequests;
use App\Models\Category;
use App\Models\Contact;
use Illuminate\Http\Request;
use Inertia\Inertia;


class ManagementController extends Controller
{
    public function categories()
    {
        return Inertia::render('Category/Categories', [
            'categories' => Category::withCount("contacts")->get(),
            "message" => session("message") ?? ""
        ]);
    }
    public function create_category()
    {
        return Inertia::render("Category/Create-Category");
    }

    public function store_category(Request $request)
    {
        $request->validate([
            "name" => "required|unique:categories,name,except,id"
        ]);
        $cat = Category::create([
            "name" => $request->name
        ]);
        return redirect()->route("categories")->with("message", $cat->name . " category created successfully");
    }

    public function edit_category($id)
    {
        return Inertia::render('Category/Edit-Category', [
            'category' => Category::findOrFail($id),
        ]);
    }

    public function update_category(Request $request, $id)
    {
        $request->validate([
            "name" => "required|unique:categories,name,except,id"
        ]);
        $cat = Category::findOrFail($id);
        $cat->name = $request->name;
        $cat->save();
        return redirect()->route("categories")->with("message", $cat->name . " category updated successfully");
    }

    public function delete_category($id)
    {
        $cat = Category::findOrFail($id);
        $cat->delete();
        return redirect()->route("categories")->with("message", $cat->name . " category deleted successfully");
    }

    public function contacts()
    {
        return Inertia::render('dashboard', [
            'contacts' => Contact::get()
        ]);
    }

    public function create_contact()
    {
        return Inertia::render("create-contact", [
            "categories" => Category::latest()->get()
        ]);
    }
}
