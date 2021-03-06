<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\AdminProfileController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\LanguageController;
use App\Http\Controllers\User\CartPageController;
use App\Http\Controllers\User\WishlistController;
use Illuminate\Support\Facades\Route;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//ADMIN All Routes

Route::group(['prefix'=>'admin', 'middleware' =>['admin:admin']], function(){
    Route::get('/login', [AdminController::class, 'loginForm']); 
    Route::post('/login', [AdminController::class, 'store'])->name('admin.login');    
});

Route::middleware(['auth:admin'])->group(function(){

    Route::middleware(['auth:sanctum,admin', 'verified'])->get('/admin/dashboard', function () {
        return view('admin.index');
    })->name('dashboard')->middleware('auth:admin');

    Route::get('/admin/logout', [AdminController::class, 'destroy'])->name('admin.logout');
    Route::get('/admin/profile', [AdminProfileController::class, 'AdminProfile'])->name('admin.profile');
    Route::get('/admin/profile/edit', [AdminProfileController::class, 'AdminProfileEdit'])->name('admin.profile.edit');
    Route::post('/admin/profile/store', [AdminProfileController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change_password', [AdminProfileController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/update_password', [AdminProfileController::class, 'AdminUpdatePassword'])->name('admin.update.password');
});

    //Brand All Routes

    Route::prefix('brand')->group(function(){
        Route::get('/view', [BrandController::class, 'BrandView'])->name('all.brands');
        Route::post('/store', [BrandController::class, 'BrandStore'])->name('brand.store');
        Route::get('/edit/{id}', [BrandController::class, 'BrandEdit'])->name('brand.edit');
        Route::post('/update', [BrandController::class, 'BrandUpdate'])->name('brand.update');
        Route::get('/delete/{id}', [BrandController::class, 'BrandDelete'])->name('brand.delete');
    });

    //Category All Routes
    Route::prefix('category')->group(function(){
        Route::get('/view', [CategoryController::class, 'CategoryView'])->name('all.categories');
        Route::post('/store', [CategoryController::class, 'CategoryStore'])->name('category.store');
        Route::get('/edit/{id}', [CategoryController::class, 'CategoryEdit'])->name('category.edit');
        Route::post('/update', [CategoryController::class, 'CategoryUpdate'])->name('category.update');
        Route::get('/delete/{id}', [CategoryController::class, 'CategoryDelete'])->name('category.delete');

        //SubCategory All Routes
        Route::get('/sub/view', [SubCategoryController::class, 'SubCategoryView'])->name('all.subcategories');
        Route::get('/subcategory/ajax/{cat_id}', [SubCategoryController::class, 'GetSubCategory']);
        Route::post('/sub/store', [SubCategoryController::class, 'SubCategoryStore'])->name('subcategory.store');
        Route::get('/sub/edit/{id}', [SubCategoryController::class, 'SubCategoryEdit'])->name('subcategory.edit');
        Route::post('/sub/update', [SubCategoryController::class, 'SubCategoryUpdate'])->name('subcategory.update');
        Route::get('/sub/delete/{id}', [SubCategoryController::class, 'SubCategoryDelete'])->name('subcategory.delete');

        //Sub-Sub Category All Routes
        Route::get('/sub/sub/view', [SubCategoryController::class, 'SubSubCategoryView'])->name('all.subsubcategory');
        Route::get('/sub-subcategory/ajax/{subcategory_id}', [SubCategoryController::class, 'GetSubSubCategory']);
        Route::post('/sub/sub/store', [SubCategoryController::class, 'SubSubCategoryStore'])->name('subsubcategory.store');
        Route::get('/sub/sub/edit/{id}', [SubCategoryController::class, 'SubSubCategoryEdit'])->name('subsubcategory.edit');
        Route::post('/sub/sub/update', [SubCategoryController::class, 'SubSubCategoryUpdate'])->name('subsubcategory.update');
        Route::get('/sub/sub/delete/{id}', [SubCategoryController::class, 'SubSubCategoryDelete'])->name('subsubcategory.delete');
    });

    //Product All Routes
    Route::prefix('product')->group(function(){
        Route::get('/add', [ProductController::class, 'AddProduct'])->name('add-product');
        Route::post('/store', [ProductController::class, 'ProductStore'])->name('product-store');
        Route::get('/manage', [ProductController::class, 'ProductManage'])->name('manage-product');
        Route::get('/info/{id}', [ProductController::class, 'ProductInfo'])->name('product.info');
        Route::get('/edit/{id}', [ProductController::class, 'ProductEdit'])->name('product.edit');
        Route::post('/update', [ProductController::class, 'ProductUpdate'])->name('product-update');
        Route::post('/image/update', [ProductController::class, 'MultiImageUpdate'])->name('update-product-image');
        Route::get('/multiimg/delete/{id}', [ProductController::class, 'MultiImageDelete'])->name('product.multiimg.delete');
        Route::post('/thumbnail/update', [ProductController::class, 'ThumbnailImageUpdate'])->name('update-product-thumbnail');
        Route::get('/inactive/{id}', [ProductController::class, 'ProductInactive'])->name('product.inactive');
        Route::get('/active/{id}', [ProductController::class, 'ProductActive'])->name('product.active');
        Route::get('/delete/{id}', [ProductController::class, 'ProductDelete'])->name('product.delete');
    });

    //Slider All Routes

    Route::prefix('slider')->group(function(){
        Route::get('/view', [SliderController::class, 'SliderView'])->name('manage.sliders');
        Route::post('/store', [SliderController::class, 'SliderStore'])->name('slider.store');
        Route::get('/edit/{id}', [SliderController::class, 'SliderEdit'])->name('slider.edit');
        Route::post('/update', [SliderController::class, 'SliderUpdate'])->name('slider.update');
        Route::get('/inactive/{id}', [SliderController::class, 'SliderInactive'])->name('slider.inactive');
        Route::get('/active/{id}', [SliderController::class, 'SliderActive'])->name('slider.active');
        Route::get('/delete/{id}', [SliderController::class, 'SliderDelete'])->name('slider.delete');
    });


//USER All Routes

Route::middleware(['auth:sanctum,web', 'verified'])->get('/dashboard', function () {
    $id = Auth::user()->id;
    $user = User::find($id);
    return view('dashboard',compact('user'));
})->name('dashboard');

Route::get('/', [IndexController::class, 'index']);
Route::get('/user/logout', [IndexController::class, 'UserLogout'])->name('user.logout');
Route::get('/user/profile', [IndexController::class, 'UserProfile'])->name('user.profile');
Route::post('/user/profile/store', [IndexController::class, 'UserProfileStore'])->name('user.profile.store');
Route::get('/user/change_password', [IndexController::class, 'ChangePassword'])->name('change.password');
Route::post('/user/update_password', [IndexController::class, 'UpdatePassword'])->name('user.password.update');
Route::get('/product/details/{id}/{slug}', [IndexController::class, 'ProductDetails']);
Route::get('/product/tag/{tag}', [IndexController::class, 'TagWiseProduct']); 
Route::get('/subcategory/product/{subcat_id}/{slug}', [IndexController::class, 'SubCatWiseProduct']);
Route::get('/subsubcategory/product/{subsubcat_id}/{slug}', [IndexController::class, 'SubSubCatWiseProduct']);
Route::get('/product/view/modal/{id}', [IndexController::class, 'ProductViewAjax']); 
Route::post('search-product', [IndexController::class, 'SearchProduct']);

Route::post('/cart/data/store/{id}', [CartController::class, 'AddToCart']); 
Route::get('/product/mini/cart/', [CartController::class, 'AddMiniCart']); 
Route::get('/minicart/product-remove/{rowId}', [CartController::class, 'RemoveMiniCart']); 
Route::post('/add-to-wishlist/{product_id}', [CartController::class, 'AddToWishlist']); 

Route::group(['prefix'=>'user','middleware' => ['user','auth'],'namespace'=>'User'],function(){
    Route::get('/wishlist', [WishlistController::class, 'ViewWishlist'])->name('wishlist');
    Route::get('/get-wishlist-product', [WishlistController::class, 'GetWishlistProduct']);
    Route::get('/wishlist-remove/{id}', [WishlistController::class, 'RemoveWishlistProduct']); 
});
Route::get('/mycart', [CartPageController::class, 'MyCart'])->name('mycart');
Route::get('/user/get-cart-product', [CartPageController::class, 'GetCartProduct']);
Route::get('/user/cart-remove/{rowId}', [CartPageController::class, 'RemoveCartProduct']);
Route::get('/cart-increment/{rowId}', [CartPageController::class, 'CartIncrement']);
Route::get('/cart-decrement/{rowId}', [CartPageController::class, 'CartDecrement']);


//Multi Languages 
Route::get('/language/english', [LanguageController::class, 'English'])->name('english.language');
Route::get('/language/arabic', [LanguageController::class, 'Arabic'])->name('arabic.language');


