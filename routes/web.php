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
Route::get('/demo',function(){

    return view('administrator.purchase.demo');
});

Route::get('/', function () {
    return view('layouts.app');
});
Route::get('/login', [loginController::class,'index'])->name('login');
Route::post('/signin', [loginController::class,'submit'])->name('login.submit');
Route::post('/logout', [logoutController::class,'submit'])->name('logout');


//branch controller
Route::resource('branchs', BranchController::class);
Route::get('branchs/{id}',[BranchController::class,'show'])->name('branchs.show');


//warehouse controller


Route::resource('warehouses', WarehouseController::class);
Route::get('branchs/{id}/warehouses',[WarehouseController::class,'index'])->name('warehouses.index');
Route::post('/warehouses/store',[WarehouseController::class,'store'])->name('warehouses.store');
Route::post('/branchs/{id}/warehouses/store',[WarehouseController::class,'store'])->name('branchwarehouses.store');
Route::delete('warehouses/{warehouse}/destroy',[WarehouseController::class,'destroy'])->name('warehouses.destroy');
Route::delete('branchs/{id}/warehouses/{warehouse}/destroy',[WarehouseController::class,'destroy'])->name('branchwarehouses.destroy');
Route::get('branchs/{id}/warehouses/create',[WarehouseController::class,'create'])->name('warehouses.create');
Route::get('warehouses/create',[WarehouseController::class,'create'])->name('warehouses.create');
Route::get('branchs/{id}/warehouses/{warehouse}/edit',[WarehouseController::class,'edit'])->name('branchWarehouses.edit');
Route::get('warehouses/{warehouse}/edit',[WarehouseController::class,'edit'])->name('headquarterWarehouses.edit');
Route::get('branchs/{id}/warehouses/{warehouse}/show',[WarehouseController::class,'show'])->name('branchWarehouses.show');
Route::get('warehouses/{warehouse}/show',[WarehouseController::class,'show'])->name('headquarterWarehouses.show');

Route::put('warehouses/{warehouse}/update',[WarehouseController::class,'update'])->name('warehouses.update');
Route::put('branchs/{id}/warehouses/{warehouse}/update',[WarehouseController::class,'update'])->name('branchwarehouses.update');
//contact controller
Route::resource('contacts', ContactController::class);
Route::get('branchs/{id}/contacts',[ContactController::class,'show']);

//user
Route::resource('users', UserController::class);

Route::get('addusers',[UserController::class,'index'])->name( 'users.getUsersOfBranch');
Route::get('branchs/{id}/users',[UserController::class,'getUsersOfBranch'])->name( 'users.getUsersOfBranch');
//category
Route::resource('categories', CategoryController::class);

//units
Route::resource('units', UnitController::class);


//products
Route::resource('products', ProductController::class);
Route::get('products',[ProductController::class,'index'])->name('products.index');
Route::get('branchs/{id}/products',[ProductController::class,'show']);

// Route::get('create/products',[ProductController::class,'create'])


// viewproducts
Route::resource('viewproducts', ViewProductController::class);

//Product in

// Route::resource('purchases', PurchaseController::class);
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



//dashboards
// Route::resource('dashboards', DashboardController::class);

Route::get('dashboards',[DashboardController::class,'index'])->middleware('auth')->name('dashboards.main');
Route::get('branchs/{id}/dashboards',[DashboardController::class,'index'])->middleware('auth')->name( 'dashboards.branch');

Route::resource('roles', RoleController::class);

Route::get('{type}',[PurchaseandSaleController::class,'index'])->where('type','purchases|sales');

