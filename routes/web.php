<?php

use App\Http\Controllers\Admin\AboutUsController;
use App\Http\Controllers\Admin\BusinessController;
use App\Http\Controllers\Admin\PageController;
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
Route::get('/terminos', [PrincipalController::class, 'terminos'])->name('terminos');
Route::get('/privacidad', [PrincipalController::class, 'privacidad'])->name('privacidad');

Route::get('/us', [PrincipalController::class, 'us'])->name('us');
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

Route::get('/listHistoriesPayments', [CheckoutController::class, 'listHistory'])->name('listHistory.payament.mercadopago');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');


Auth::routes(['verify' => true]);

Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::post('/checkout/paidNiubiz', [CheckoutController::class, 'paidNiubiz'])->name('checkout.paidNiubiz');

    Route::get('/checkout', [ShoppingCart::class, 'checkout'])->name('carts.checkout');
    Route::get('/payment', [CheckoutController::class, 'index'])->name('payment.index');

    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
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

Route::middleware(['auth', 'check.role'])->group(function () {
    // About Us
    Route::resource('admin/about', AboutUsController::class)
        ->middleware('can:ver acerca de nosotros,editar acerca de nosotros');
    
    // Pages
    Route::get('/admin/pages/{slug}/edit', [PageController::class, 'edit'])
        ->name('admin.pages.edit')
        ->middleware('can:gestionar páginas');
    Route::put('/admin/pages/{slug}', [PageController::class, 'update'])
        ->name('admin.pages.update')
        ->middleware('can:gestionar páginas');

    // Business Configuration
    Route::get('/admin/empresa', [BusinessController::class, 'index'])
        ->name('business.index')
        ->middleware('can:ver configuración del negocio');
    Route::put('/admin/empresa', [BusinessController::class, 'update'])
        ->name('business.update')
        ->middleware('can:actualizar configuración del negocio');

    // Permissions
    Route::get('/admin/roles', App\Livewire\Admin\RoleComponent::class)
        ->name('roles.index')
        ->middleware('can:gestionar permisos');
    
    // Users
    Route::get('/admin/users', App\Livewire\Admin\UserComponent::class)
        ->name('users.index')
        ->middleware('can:gestionar usuarios');
    
    // Posts
    Route::get('/admin/posts', App\Livewire\Admin\PostComponent::class)
        ->name('admin.posts.index')
        ->middleware('can:gestionar publicaciones');
    
    // Comments
    Route::get('/admin/comments', App\Livewire\Admin\CommentComponent::class)
        ->name('admin.comments.index')
        ->middleware('can:gestionar comentarios');
    
    // Ratings
    Route::get('/admin/ratings', App\Livewire\Admin\RatingComponent::class)
        ->name('admin.ratings.index')
        ->middleware('can:gestionar valoraciones');

    // Services
    Route::get('/admin/services', App\Livewire\Admin\ServiceComponent::class)
        ->name('services.index')
        ->middleware('can:gestionar servicios');
    
    // Sliders
    Route::get('/admin/sliders', App\Livewire\Admin\SliderComponent::class)
        ->name('sliders.index')
        ->middleware('can:gestionar sliders');
    
    // Coupons
    Route::get('/admin/coupons', App\Livewire\Admin\CouponComponent::class)
        ->name('coupons.index')
        ->middleware('can:gestionar cupones');
    
    // Brands
    Route::get('/admin/brands', App\Livewire\Admin\BrandComponent::class)
        ->name('brands.index')
        ->middleware('can:gestionar marcas');
    
    // Categories
    Route::get('/admin/categories', App\Livewire\Admin\CategoryComponent::class)
        ->name('categories.index')
        ->middleware('can:gestionar categorías');
    
    // Products
    Route::get('/admin/products', App\Livewire\Admin\ProductComponent::class)
        ->name('products.index')
        ->middleware('can:gestionar productos');
    
    // Product Gallery
    Route::get('/admin/product/{product}/gallery', [ProductImageController::class, 'gallery'])
        ->name('product.gallery')
        ->middleware('can:subir imágenes de productos');
    Route::post('/admin/upload-image/{product}', [ProductImageController::class, 'upload'])
        ->name('product.upload')
        ->middleware('can:subir imágenes de productos');
    Route::delete('/admin/delete-image/{id}', [ProductImageController::class, 'delete'])
        ->name('product.delete')
        ->middleware('can:eliminar imágenes de productos');
    
    // Orders
    Route::get('/admin/orders', App\Livewire\Admin\OrderComponent::class)
        ->name('orders.index')
        ->middleware('can:gestionar pedidos');

    // Home
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
        ->name('home');
    
    // Profile
    Route::get('/admin/perfil', [App\Http\Controllers\Admin\ProfileController::class, 'perfil'])
        ->name('usuario.perfil');
    Route::put('/admin/profile', [App\Http\Controllers\Admin\ProfileController::class, 'updateProfile'])
        ->name('profile.update');
    Route::put('/admin/profile/update-password', [App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])
        ->name('profile.updatePassword');
});

// Route::middleware(['auth', 'role:admin'])->group(function () {
//     Route::resource('admin/about', AboutUsController::class);
    
//     Route::get('/admin/pages/{slug}/edit', [PageController::class, 'edit'])->name('admin.pages.edit');
//     Route::put('/admin/pages/{slug}', [PageController::class, 'update'])->name('admin.pages.update');

//     Route::get('/admin/empresa', [BusinessController::class, 'index'])->name('business.index');
//     Route::put('/admin/empresa', [BusinessController::class, 'update'])->name('business.update');

//     Route::get('/admin/permissions', App\Livewire\Admin\RoleComponent::class)->name('permissions.index');
//     Route::get('/admin/users', App\Livewire\Admin\UserComponent::class)->name('users.index');
//     Route::get('/admin/posts', App\Livewire\Admin\PostComponent::class)->name('admin.posts.index');
//     Route::get('/admin/comments', App\Livewire\Admin\CommentComponent::class)->name('admin.comments.index');
//     Route::get('/admin/ratings', App\Livewire\Admin\RatingComponent::class)->name('admin.ratings.index');

//     Route::get('/admin/services', App\Livewire\Admin\ServiceComponent::class)->name('services.index');
//     Route::get('/admin/sliders', App\Livewire\Admin\SliderComponent::class)->name('sliders.index');
//     Route::get('/admin/coupons', App\Livewire\Admin\CouponComponent::class)->name('coupons.index');
//     Route::get('/admin/brands', App\Livewire\Admin\BrandComponent::class)->name('brands.index');
//     Route::get('/admin/categories', App\Livewire\Admin\CategoryComponent::class)->name('categories.index');
//     Route::get('/admin/products', App\Livewire\Admin\ProductComponent::class)->name('products.index');
//     Route::get('/admin/product/{product}/gallery', [ProductImageController::class, 'gallery'])->name('product.gallery');
//     Route::post('/admin/upload-image/{product}', [ProductImageController::class, 'upload'])->name('product.upload');
//     Route::delete('/admin/delete-image/{id}', [ProductImageController::class, 'delete'])->name('product.delete');
//     Route::get('/admin/orders', App\Livewire\Admin\OrderComponent::class)->name('orders.index');

//     Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//     Route::get('/admin/perfil', [App\Http\Controllers\Admin\ProfileController::class, 'perfil'])->name('usuario.perfil');
//     Route::put('/admin/profile', [App\Http\Controllers\Admin\ProfileController::class, 'updateProfile'])->name('profile.update');
//     Route::put('/admin/profile/update-password', [App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
// });
