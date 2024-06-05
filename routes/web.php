<?php

use App\Http\Controllers\AboutmeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LoginUserController;
use Illuminate\Http\Request;
use Illuminate\Routing\PendingResourceRegistration;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\TodoController;

Route::view('/', 'welcome');

Route::middleware('auth')->group(function() {
    // posts
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->can('update', 'post')->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::post('/logout', [LoginUserController::class, 'logout']) -> name('logout');
    
    // todos
    Route::get('/todos', [TodoController::class, 'index'])->name('todos.index');
    Route::get('/todos/create', [TodoController::class, 'create'])->name('todos.create');
    Route::get('/todos/{todo}', [TodoController::class, 'show'])->name('todos.show');
    Route::post('/todos', [TodoController::class, 'store'])->name('todos.store');
    Route::get('/todos/{todo}/edit', [TodoController::class, 'edit'])->can('update', 'todo')->name('todos.edit');
    Route::put('/todos/{todo}', [TodoController::class, 'update'])->name('todos.update');
    Route::delete('/todos/{todo}', [TodoController::class, 'destroy'])->name('todos.destroy');
    Route::patch('/todos/{todo}/toggle', [TodoController::class, 'toggle'])->can('update', 'todo')->name('todos.toggle');
    Route::post('/logout', [LoginUserController::class, 'logout']) -> name('logout');

    // aboutmes
    Route::get('/aboutmes/create', [AboutmeController::class, 'create'])->middleware('check.aboutme')->name('aboutmes.create');
    Route::post('/aboutmes', [AboutmeController::class, 'store'])->middleware('check.aboutme')->name('aboutmes.store');
    Route::get('/aboutmes/{aboutme}/edit', [AboutmeController::class, 'edit'])->can('update', 'aboutme')->name('aboutmes.edit');
    Route::put('/aboutmes/{aboutme}', [AboutmeController::class, 'update'])->name('aboutmes.update');
    Route::delete('/aboutmes/{aboutme}', [AboutmeController::class, 'destroy'])->name('aboutmes.destroy');
    Route::post('/logout', [LoginUserController::class, 'logout'])->name('logout');

    // contacts
    Route::get('/contacts/create', [ContactController::class, 'create'])->name('contacts.create');
    Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
    Route::get('/contacts/{contact}/edit', [ContactController::class, 'edit'])->can('update', 'contact')->name('contacts.edit');
    Route::put('/contacts/{contact}', [ContactController::class, 'update'])->name('contacts.update');
    Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');
    Route::post('/logout', [LoginUserController::class, 'logout']) -> name('logout');

    // admin
    Route::middleware('is-admin')->group(function() {
        Route::get('/admin', [AdminController::class, 'index'])->middleware('is-admin')->name('admin');
        Route::get('/admin/posts/{post}/edit', [AdminPostController::class, 'edit'])->name('admin.posts.edit');
        Route::put('/admin/posts/{post}', [AdminPostController::class, 'update'])->name('admin.posts.update');
        Route::delete('/admin/posts/{post}', [AdminPostController::class, 'destroy'])->name('admin.posts.destroy');
    });
});

// guests
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

Route::get('/aboutmes', [AboutmeController::class, 'index'])->name('aboutmes.index');
Route::get('/aboutmes/{aboutme}', [AboutmeController::class, 'show'])->name('aboutmes.show');

Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
Route::post('/contacts', [ContactController::class, 'submit'])->name('contacts.submit');
Route::get('/contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');


Route::middleware('guest')->group(function() {
    Route::get('/register', [RegisterUserController::class, 'register'])->name('register');
    Route::post('/register', [RegisterUserController::class, 'store'])->name('register.store');
    Route::get('/login', [LoginUserController::class, 'login'])->name('login');
    Route::post('/login', [LoginUserController::class, 'store'])->name('login.store');
});
