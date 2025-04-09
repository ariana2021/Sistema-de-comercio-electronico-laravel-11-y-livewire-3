<?php

use App\Http\Controllers\Admin\BusinessController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\RolController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\ShoppingCart;
use App\Http\Controllers\SocialAuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [PrincipalController::class, 'index'])->name('index');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/wishlist', [ShoppingCart::class, 'wishlist'])->name('wishlist.index');
Route::get('/carts', [ShoppingCart::class, 'index'])->name('carts.index');
Route::get('/category/{slug}', [PrincipalController::class, 'category'])->name('category');
Route::get('/products', [PrincipalController::class, 'products'])->name('shop');
Route::get('/product/{slug}', [PrincipalController::class, 'product'])->name('product.detail');
Route::post('/cart/calculate-shipping', [ShoppingCart::class, 'calculateShipping'])->name('carts.calculateShipping');
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');
Route::get('/products/search', [ShoppingCart::class, 'search'])->name('products.search');

Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Auth::routes(['verify' => true]);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/checkout', [ShoppingCart::class, 'checkout'])->name('carts.checkout');
    Route::get('/payment', [CheckoutController::class, 'index'])->name('payment.index');
    Route::get('/checkout/success', [CheckoutController::class, 'checkoutSuccess'])->name('checkout.success');
    Route::get('/checkout/failure', [CheckoutController::class, 'failure'])->name('checkout.failure');
    Route::get('/checkout/pending', [CheckoutController::class, 'pending'])->name('checkout.pending');
    Route::get('/thank-you', [CheckoutController::class, 'thankyou'])->name('checkout.thank-you');

    Route::get('/profile', [PrincipalController::class, 'profile'])->name('profile.index');
    Route::post('/perfil/update', [PrincipalController::class, 'updateProfile'])->name('profile.updateProfile');
    Route::post('/profile/update-photo', [PrincipalController::class, 'updatePhoto'])->name('profile.update-photo');
    Route::post('/profile/update-password', [PrincipalController::class, 'updatePassword'])->name('profile.update.password');
    Route::get('/order/status/{id}', [PrincipalController::class, 'showStatus'])->name('order.status');
    Route::get('/order/{encryptedId}/invoice/pdf', [PrincipalController::class, 'generateTicket'])->name('order.invoice.pdf');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/empresa', [BusinessController::class, 'index'])->name('business.index');
    Route::put('/admin/empresa', [BusinessController::class, 'update'])->name('business.update');

    Route::get('/admin/users', App\Livewire\Admin\UserComponent::class)->name('users.index');
    Route::get('/admin/posts', App\Livewire\Admin\PostComponent::class)->name('admin.posts.index');
    Route::get('/admin/comments', App\Livewire\Admin\CommentComponent::class)->name('admin.comments.index');
    Route::get('/admin/ratings', App\Livewire\Admin\RatingComponent::class)->name('admin.ratings.index');

    Route::get('/admin/services', App\Livewire\Admin\ServiceComponent::class)->name('services.index');
    Route::get('/admin/sliders', App\Livewire\Admin\SliderComponent::class)->name('sliders.index');
    Route::get('/admin/coupons', App\Livewire\Admin\CouponComponent::class)->name('coupons.index');
    Route::get('/admin/brands', App\Livewire\Admin\BrandComponent::class)->name('brands.index');
    Route::get('/admin/categories', App\Livewire\Admin\CategoryComponent::class)->name('categories.index');
    Route::get('/admin/products', App\Livewire\Admin\ProductComponent::class)->name('products.index');
    Route::get('/admin/product/{product}/gallery', [ProductImageController::class, 'gallery'])->name('product.gallery');
    Route::post('/admin/upload-image/{product}', [ProductImageController::class, 'upload'])->name('product.upload');
    Route::delete('/admin/delete-image/{id}', [ProductImageController::class, 'delete'])->name('product.delete');
    Route::get('/admin/orders', App\Livewire\Admin\OrderComponent::class)->name('orders.index');

    Route::get('/admin/roles/assign/{id}', [RolController::class, 'assignRoles'])->name('roles.assign');

    Route::resource('/admin/roles', RolController::class);

    Route::put('/admin/roles/updateRoles/{id}', [RolController::class, 'updateRoles'])->name('roles.updateRoles');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/admin/perfil', [App\Http\Controllers\Admin\ProfileController::class, 'perfil'])->name('usuario.perfil');
    Route::put('/admin/profile', [App\Http\Controllers\Admin\ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/admin/profile/update-password', [App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
});
