<?php

use App\Http\Controllers\Admin\RolController;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\ShoppingCart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [PrincipalController::class, 'index'])->name('index');
Route::get('/carts', [ShoppingCart::class, 'index'])->name('carts.index');
Route::get('/checkout', [ShoppingCart::class, 'checkout'])->name('carts.checkout');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Auth::routes(['verify' => true]);

Route::middleware(['auth'])->group(function () {

    Route::get('/users', App\Livewire\Admin\UserComponent::class)->name('users.index');

    Route::get('/brands', App\Livewire\Admin\BrandComponent::class)->name('brands.index');
    Route::get('/categories', App\Livewire\Admin\CategoryComponent::class)->name('categories.index');
    Route::get('/products', App\Livewire\Admin\ProductComponent::class)->name('products.index');
        
    Route::get('/roles/assign/{id}', [RolController::class, 'assignRoles'])->name('roles.assign');

    Route::resource('roles', RolController::class);

    Route::put('roles/updateRoles/{id}', [RolController::class, 'updateRoles'])->name('roles.updateRoles');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/perfil', [App\Http\Controllers\Admin\ProfileController::class, 'perfil'])->name('usuario.perfil');
    Route::put('profile', [App\Http\Controllers\Admin\ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('profile/update-password', [App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
});
