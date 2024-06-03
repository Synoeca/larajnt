<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contact::paginate(6);
        return view('contacts.index', ['contacts' => $contacts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->check())
        {
            return to_route('login');
        }
        return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'min:5', 'max:255'],
            'content' => ['required', 'min:10'],
            'thumbnail' => ['required', 'image']
        ]);

        $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails');
        auth()->user()->contacts()->create($validated);
        //Mail::to($crequest->email)->send(new ContactMail($crequest->name, $crequest->email, $crequest->title, $crequest->content));
        //Aboutme::create($validated);
        //dispatch(new SendNewPostMailJob(['email' => auth()->user()->email, 'name' => auth()->user()->name, 'title' => $validated['title']]));
        return redirect()->route('contacts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        return view('contacts.show', ['contact' => $contact]);
    }

    public function submit(ContactRequest $request)
    {
       Mail::to($request->email)->send(new ContactMail($request->name, $request->email, $request->title, $request->content));
       return to_route('posts.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        return view('contacts.edit', ['contact' => $contact]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        Gate::authorize('update', $contact);
        $validated = $request->validate([
            'title' => ['required', 'min:5', 'max:255'],
            'content' => ['required', 'min:10'],
            'thumbnail' => ['sometimes', 'image']
        ]);
        
        if ($request->hasFile('thumbnail')) {
            File::delete(storage_path('app/public/'. $contact->thumbnail));
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails');
        }
        $contact -> update($validated);
        return to_route('contacts.show', ['contact' => $contact]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        Gate::authorize('delete', $contact);
        File::delete(storage_path('app/public/'. $contact->thumbnail));
        $contact -> delete();
        return to_route('contacts.index');
    }
}