<?php

namespace App\Http\Controllers;

use App\Models\Aboutme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\File;

class AboutmeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aboutmes = Aboutme::paginate(6);
        return view('aboutmes.index', ['aboutmes' => $aboutmes]);
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
        return view('aboutmes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'min:1', 'max:255'],
            'title' => ['required', 'min:1', 'max:255'],
            'content' => ['required', 'min:1'],
            'thumbnail' => ['required', 'image']
        ]);

        $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails');
        auth()->user()->aboutmes()->create($validated);
        //Aboutme::create($validated);
        //dispatch(new SendNewPostMailJob(['email' => auth()->user()->email, 'name' => auth()->user()->name, 'title' => $validated['title']]));
        return redirect()->route('aboutmes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Aboutme $aboutme)
    {
        return view('aboutmes.show', ['aboutme' => $aboutme]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Aboutme $aboutme)
    {
        return view('aboutmes.edit', ['aboutme' => $aboutme]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aboutme $aboutme)
    {
        Gate::authorize('update', $aboutme);
        $validated = $request->validate([
            'name' => ['required', 'min:1', 'max:255'],
            'title' => ['required', 'min:5', 'max:255'],
            'content' => ['required', 'min:10'],
            'thumbnail' => ['sometimes', 'image']
        ]);
        
        if ($request->hasFile('thumbnail')) {
            File::delete(storage_path('app/public/'. $aboutme->thumbnail));
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails');
        }
        $aboutme -> update($validated);
        return to_route('aboutmes.show', ['aboutme' => $aboutme]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aboutme $aboutme)
    {
        Gate::authorize('delete', $aboutme);
        File::delete(storage_path('app/public/'. $aboutme->thumbnail));
        $aboutme -> delete();
        return to_route('aboutmes.index');
    }
}
