<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\TodoRequest;

class TodoController extends Controller
{
    public function index(Post $post)
    {
        $todos = Todo::paginate(6);
        return view('todos.index', ['todos' => $todos]);
    }

    public function create()
    {
        if (!auth()->check())
        {
            return to_route('login');
        }
        return view('todos.create');
    }

    public function store(Request $request)
    {
        $request->merge(['is_completed' => $request->input('is_completed', 0)]);
        $validated = $request->validate([
            'title' => ['required', 'min:5', 'max:255'],
            'description' => ['required', 'min:10'],
            'is_completed' => ['sometimes', 'in:0,1']
        ]);

        //$validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails');
        
        //Todo::create($validated);
        auth()->user()->todos()->create($validated);

        //dispatch(new SendNewPostMailJob(['email' => auth()->user()->email, 'name' => auth()->user()->name, 'title' => $validated['title']]));
        return redirect()->route('todos.index');
        //return $request->all();
    }

    public function show(Todo $todo)
    {
        //$post = Post::findOrFail($id);
        return view('todos.show', ['todo' => $todo]);
    }

    public function edit(Todo $todo)
    {
        //Gate::authorize('update', $post);
        return view('todos.edit', ['todo' => $todo]);
    }

    public function update(Request $request, Todo $todo)
    {
        Gate::authorize('update', $todo);
        $validated = $request->validate([
            'title' => ['required', 'min:5', 'max:255'],
            'description' => ['required', 'min:10'],
            'thumbnail' => ['sometimes', 'image']
        ]);
        if ($request->hasFile('thumbnail')) {
            File::delete(storage_path('app/public/'. $todo->thumbnail));
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails');
        }
        $todo -> update($validated);
        //return to_route('todos.index', ['todo' => $todo]);
        return redirect()->route('todos.index')->with('success', 'Todo updated successfully!');
    }

    public function destroy(Todo $todo)
    {
        Gate::authorize('delete', $todo);
        File::delete(storage_path('app/public/'. $todo->thumbnail));
        $todo -> delete();
        return to_route('todos.index');
    }

    public function toggleStatus(Todo $todo)
    {
        $todo->is_completed = !$todo->is_completed;
        $todo->save();

        return response()->json(['success' => true, 'new_status' => $todo->is_completed ? 'Completed' : 'Incompleted']);
    }

}
