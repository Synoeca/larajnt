<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\View\View;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request) : View
    {
        //dd(($request->user()->id));
        //dd(Profile::find($request->user()->id));
        return view('profile', [
            'profile' => Profile::find($request->user()->id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profile $profile)
    {
        $validated = $request->validate([
            'first_name' => ['sometimes', 'min:5', 'max:255'],
            'last_name' => ['sometimes', 'min:10'],
        ]);
        $profile -> update($validated);
        return to_route('profile.edit', ['profile' => $profile]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
