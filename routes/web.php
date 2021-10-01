<?php

use Illuminate\Support\Facades\Route;

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

/*
2017-10-30 setup for urls
Home:			/
Brand:			/52/AEG/
Type:			/52/AEG/53/Superdeluxe/
Manual:			/52/AEG/53/Superdeluxe/8023/manual/
				/52/AEG/456/Testhandle/8023/manual/

If we want to add product categories later:
Productcat:		/category/12/Computers/
*/

use App\Models\Brand;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\ManualController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\LocaleController;

// Homepage
Route::get('/', function () {
    $brands = Brand::all()->sortBy('name');
    $query = DB::table('manuals')->orderBy('count','desc')->limit(10)->get();
    return view('pages.homepage', compact('brands','query'));
})->name('home');

Route::get('/manual/{language}/{brand_slug}/', [RedirectController::class, 'brand']);
Route::get('/manual/{language}/{brand_slug}/brand.html', [RedirectController::class, 'brand']);

Route::get('/manual/{language}/{brand_slug}/{type_slug}/', [RedirectController::class, 'type']);
Route::get('/manual/{language}/{brand_slug}/{type_slug}/type.html', [RedirectController::class, 'type']);

Route::get('/datafeeds/{brand_slug}.xml', [RedirectController::class, 'datafeed']);

// Locale routes
Route::get('/language/{language_slug}/', [LocaleController::class, 'changeLocale']);

// List of types for a brand
Route::get('/{brand_id}/{brand_slug}/', [BrandController::class, 'show'])->name('type_list');

// List of manuals for a type
Route::get('/{brand_id}/{brand_slug}/{type_id}/{type_slug}/', [TypeController::class, 'show'])->name('manual_list');

// Detail page for a manual
Route::get('/{brand_id}/{brand_slug}/{type_id}/{type_slug}/{manual_id}/', [ManualController::class, 'show']);

// List of brands per product category
Route::get('/category/{category_id}/{category_slug}/', [ProductCategoryController::class, 'show']);

// Generate sitemaps
Route::get('/generateSitemap/', [SitemapController::class, 'generate']);
