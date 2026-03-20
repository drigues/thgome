<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortfolioController::class, 'home'])->name('home');
Route::get('/work', [PortfolioController::class, 'projects'])->name('projects');
Route::get('/work/{project:slug}', [PortfolioController::class, 'project'])->name('project');
Route::get('/about', [PortfolioController::class, 'about'])->name('about');
Route::get('/contact', [PortfolioController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit')
    ->middleware('throttle:5,1');
Route::get('/blog', [PortfolioController::class, 'blog'])->name('blog');
Route::get('/blog/{post:slug}', [PortfolioController::class, 'post'])->name('post');
Route::get('/cv', [PortfolioController::class, 'cv'])->name('cv');
Route::get('/sitemap.xml', [PortfolioController::class, 'sitemap']);
