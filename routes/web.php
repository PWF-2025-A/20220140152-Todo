<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth', 'verified')->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::resource('todo', TodoController::class)->except(['show']);
    Route::get('/todo', [TodoCOntroller::class, 'store'])->name('todo.store');
    Route::get('/todo', [TodoController::class, 'index'])->name('todo.index');
    Route::get('/todo/create', [TodoController::class, 'create'])->name('todo.create');
    Route::post('/todo', [TodoController::class, 'edit'])->name('todo.edit');

    Route::patch('/todo/{todo}/complete', [TodoCOntroller::class, 'complete'])->name('todo.complete');
    Route::patch('/todo/{todo}/incomplete', [TodoCOntroller::class, 'uncomplete'])->name('todo.uncomplete');
    Route::delete('/todo', [TodoController::class, 'destroyCompleted'])->name('todo.deleteallcompleted');
    Route::get('/todo/{todo}/edit', [TodoCOntroller::class, 'edit'])->name('todo.edit');
    Route::patch('/todo/{todo}', [TodoCOntroller::class, 'update'])->name('todo.update');
    Route::delete('/todo/{todo}', [TodoCOntroller::class, 'destroy'])->name('todo.destroy');
    Route::delete('/todo', [TodoCOntroller::class, 'destroyCompleted'])->name('todo.deleteallcompleted');
    Route::resource('todo', TodoCOntroller::class);
});
    Route::get('categories', [CategoryController::class, 'index'])->name('category.index');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');


    Route::middleware(['auth','admin'])->group(function (){
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::patch('/user/{data}/makeadmin', [UserController::class, 'makeadmin'])->name('user.makeadmin');
    Route::patch('/user/{data}/removeadmin', [UserController::class, 'removeadmin'])->name('user.removeadmin');
    Route::delete('/user/{data}', [UserController::class, 'destroy'])->name('user.destroy');
    });
   
require __DIR__.'/auth.php';
