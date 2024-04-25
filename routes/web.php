<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ViewProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PurchaseandSaleController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return view('layouts.app');
});
Route::get('/login', [loginController::class,'index'])->name('login');
Route::post('/signin', [loginController::class,'submit'])->name('login.submit');

Route::middleware(['auth'])->group(function(){

    Route::post('/logout', [logoutController::class,'submit'])->name('logout');
    Route::get('dashboards',[DashboardController::class,'index'])->name('dashboards.main');
    Route::get('branchs/{id}/dashboards',[DashboardController::class,'index'])->name( 'dashboards.branch');
    
    Route::resource('branchs', BranchController::class);
    
    Route::controller(WarehouseController::class)->prefix('branchs/{id}/warehouses')->group(function(){
    Route::get('/','index')->name('branchwarehouses.index');
    Route::post('/store','store')->name('branchwarehouses.store');
    Route::get('/create','create')->name('branchwarehouses.create');
    Route::delete('/{warehouse}/destroy','destroy')->name('branchwarehouses.destroy');
    Route::get('/{warehouse}/edit','edit')->name('branchWarehouses.edit');
    Route::get('/{warehouse}/show','show')->name('branchWarehouses.show');
    Route::put('/{warehouse}/update','update')->name('branchwarehouses.update');
    });
    Route::resource('warehouses', WarehouseController::class);
    
    Route::resource('contacts', ContactController::class);
    Route::get('branchs/{id}/contacts',[ContactController::class,'index'])->name( 'branchContacts.index');
    
    Route::resource('users', UserController::class);
    
    Route::resource('categories', CategoryController::class);
    
    Route::resource('units', UnitController::class);
    
    Route::resource('products', ProductController::class);
    Route::get('branchs/{id}/products',[ProductController::class,'index'])->name('branchProducts.index');
    
    Route::resource('roles', RoleController::class);
    
    Route::controller(PurchaseandSaleController::class)->prefix('{type}')->group(function()
    {
    Route::get('/','index')->name('purchaseSale.index');
    Route::get('/create','create') ->name('purchaseSale.create');
    Route::post('/store','store')->name( 'purchaseSale.store' );
    Route::delete('/{typeId}/destroy','destroy')->name('purchaseSale.destroy');
    });
    
    Route::controller(PurchaseandSaleController::class)->prefix('branchs/{id}/{type}')->group(function()
    {
    Route::get('/','index')->name('branch.purchaseSale.index');
    Route::get('/create','create')->name('branch.purchaseSale.create');
    Route::post('/store','store')->name('branch.purchaseSale.store');
    Route::delete('/{typeId}/destroy','destroy')->name('branch.purchaseSale.destroy');
        
    });
    


});


/*


Route::resource('purchases', PurchaseController::class);
Route::get('branchs/{id}/purchaseproducts',[PurchaseController::class,'purchase'])->name( 'products.purchase');
Route::get('purchaseproducts',[PurchaseController::class,'purchase'])->name( 'products.Headpurchase');
Route::post('purchaseproducts',[PurchaseController::class,'store'])->name( 'products.headpurchaseStore');//store purchase goods for headqaurter
Route::post('branchs/{id}/purchaseproducts',[PurchaseController::class,'store'])->name( 'products.purchaseStore'); // store purchase goods for branch
Route::get('branchs/{id}/purchasesdetails',[PurchaseController::class,'index'])->name( 'products.purchaseDetails');
Route::get('purchasesdetails',[PurchaseController::class,'index'])->name( 'products.HeadpurchaseDetails');
Route::delete('purchases/{purchase}/destroy',[PurchaseController::class,'destroy'])->name('purchases.destroy');
Route::delete('branchs/{id}/purchases/{purchase}/destroy',[PurchaseController::class,'destroy'])->name('branchpurchases.destroy');

//Sales
// Route::resource('sales', SaleController::class);
Route::get('branchs/{id}/sellproducts',[SaleController::class,'sale'])->name( 'products.sale');
Route::get('sellproducts',[SaleController::class,'sale'])->name( 'products.Headsale');

Route::get('branchs/{id}/salesdetails',[SaleController::class,'index'])->name( 'products.saleDetails');
Route::get('salesdetails',[SaleController::class,'index'])->name( 'products.HeadsaleDetails');
Route::post('sellproducts',[SaleController::class,'store'])->name( 'products.headsaleStore');//store sold goods for headqaurter
Route::post('branchs/{id}/sellproducts',[SaleController::class,'store'])->name( 'products.saleStore'); // store sold goods for branch
Route::delete('sales/{sale}/destroy',[SaleController::class,'destroy'])->name('sales.destroy');
Route::delete('branchs/{id}/sales/{sale}/destroy',[SaleController::class,'destroy'])->name('branchsales.destroy');


*/