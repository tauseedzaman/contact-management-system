<?php

namespace App\Http\Controllers;

use App\Exports\ContactsExport;
use App\Http\Middleware\HandleInertiaRequests;
use App\Imports\ContactsImport;
use App\Models\Category;
use App\Models\Contact;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Str;
use Excel;

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
            "name" => $request->name,
            "uuid" => Str::uuid()
        ]);
        return redirect()->route("categories")->with("message", $cat->name . " category created successfully");
    }

    public function edit_category($uuid)
    {
        return Inertia::render('Category/Edit-Category', [
            'category' => Category::where("uuid", $uuid)->first(),
        ]);
    }

    public function update_category(Request $request, $uuid)
    {
        $request->validate([
            "name" => "required|unique:categories,name,except,id"
        ]);
        $cat = Category::where("uuid", $uuid)->first();
        $cat->name = $request->name;
        $cat->save();
        return redirect()->route("categories")->with("message", $cat->name . " category updated successfully");
    }

    public function delete_category($uuid)
    {
        $cat = Category::where("uuid", $uuid)->first();
        $cat->delete();
        return redirect()->route("categories")->with("message", $cat->name . " category deleted successfully");
    }

    public function contacts()
    {
        return Inertia::render('Dashboard', [
            'contacts' => Contact::with("category")->get(),
            'message' => session("message")
        ]);
    }

    public function create_contact()
    {
        return Inertia::render("Create-Contact", [
            "categories" => Category::latest()->get()
        ]);
    }

    public function store_contact(Request $request)
    {

        $request->validate([
            "name" => "required|unique:contacts,name,except,id",
            "email" => "sometimes|unique:contacts,email,except,id",
            "phone" => "sometimes|unique:contacts,phone,except,id",
            "address" => "sometimes|unique:contacts,address,except,id",
            "category" => "required|exists:categories,id",
        ]);

        $Contact = Contact::create([
            "user_id" => auth()->id(),
            "uuid" => Str::uuid(),
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            "address" => $request->address,
            "category_id" => $request->category,
        ]);
        return redirect()->route("contacts")->with("message", $Contact->name . " Contact created successfully");
    }

    public function edit_contact($uuid)
    {
        return Inertia::render('Edit-Contact', [
            'contact' => Contact::where("uuid", $uuid)->first(),
            'categories' => Category::latest()->get(),
        ]);
    }

    public function update_contact(Request $request, $uuid)
    {
        $data = Contact::where("uuid", $uuid)->first();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->category_id = $request->category;
        $data->save();

        return redirect()->route("contacts")->with("message", $data->name . " Contact updated successfully");
    }

    public function delete_contact($uuid)
    {
        $data = Contact::where("uuid", $uuid)->first();
        $data->delete();
        return redirect()->route("contacts")->with("message", $data->name . " Contact deleted successfully");
    }

    public function export_contacts()
    {
        return Excel::download(new ContactsExport, 'Contacts.xlsx');
    }

    public function import_contact()
    {
        return Inertia::render("Import-Contact");
    }
    public function import_contacts(Request $request)
    {


        $request->validate([
            "file" => "file|mimes:xlsx,csv"
        ]);

        Excel::import(new ContactsImport, $request->file("file"));

        return redirect('/')->with('message', 'Contacts Imported successfully');
    }
}
