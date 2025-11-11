<?php

use App\Livewire\Admin\Categories\Create as CategoriesCreate;
use App\Livewire\Admin\Categories\Edit as CategoriesEdit;
use App\Livewire\Admin\Categories\Index as CategoriesIndex;
use App\Livewire\Admin\Posts\Create as PostsCreate;
use App\Livewire\Admin\Posts\Edit as PostsEdit;
use App\Livewire\Admin\Posts\Index as PostsIndex;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/blog', function () {
    return view('blog.index');
})->name('blog.index');

Route::get('/blog/{post:slug}', function (\App\Models\Post $post) {
    return view('blog.show', ['post' => $post]);
})->name('blog.show');

Route::get('/category/{category:slug}', function (\App\Models\Category $category) {
    return view('blog.category', ['category' => $category]);
})->name('blog.category');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('posts', PostsIndex::class)->name('posts.index');
    Route::get('posts/create', PostsCreate::class)->name('posts.create');
    Route::get('posts/{post}/edit', PostsEdit::class)->name('posts.edit');

    Route::get('categories', CategoriesIndex::class)->name('categories.index');
    Route::get('categories/create', CategoriesCreate::class)->name('categories.create');
    Route::get('categories/{category}/edit', CategoriesEdit::class)->name('categories.edit');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
