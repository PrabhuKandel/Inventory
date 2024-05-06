<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PurchaseandSaleController;
use App\Http\Controllers\ReportController;


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
Route::get('/login', [loginController::class, 'index'])->name('login');
Route::post('/signin', [loginController::class, 'submit'])->name('login.submit');

Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [logoutController::class, 'submit'])->name('logout');
    Route::get('dashboards', [DashboardController::class, 'index'])->name('dashboards.main');
    Route::get('branchs/{id}/dashboards', [DashboardController::class, 'index'])->name('dashboards.branch');

    Route::resource('branchs', BranchController::class);

    Route::controller(WarehouseController::class)->prefix('branchs/{id}/warehouses')->group(function () {
        Route::get('/', 'index')->name('branchwarehouses.index');
        Route::post('/store', 'store')->name('branchwarehouses.store');
        Route::get('/create', 'create')->name('branchwarehouses.create');
        Route::delete('/{warehouse}/destroy', 'destroy')->name('branchwarehouses.destroy');
        Route::get('/{warehouse}/edit', 'edit')->name('branchWarehouses.edit');
        Route::get('/{warehouse}/show', 'show')->name('branchWarehouses.show');
        Route::put('/{warehouse}/update', 'update')->name('branchwarehouses.update');
    });
    Route::resource('warehouses', WarehouseController::class);

    Route::resource('contacts', ContactController::class);
    Route::get('branchs/{id}/contacts', [ContactController::class, 'index'])->name('branchContacts.index');
    Route::get('branchs/{id}/contacts/{contact}/show', [ContactController::class, 'show'])->name('branchContacts.show');

    Route::resource('users', UserController::class);
    Route::get('branchs/{id}/users', [UserController::class, 'index'])->name('branchUsers.index');
    Route::get('branchs/{id}/users/{user}/show', [UserController::class, 'show'])->name('branchUsers.show');

    Route::resource('categories', CategoryController::class);
    Route::get('branchs/{id}/categories', [CategoryController::class, 'index'])->name('branchCategories.index');
    Route::get('branchs/{id}/categories/{category}/show', [CategoryController::class, 'show'])->name('branchCategories.show');

    Route::resource('units', UnitController::class);
    Route::get('branchs/{id}/units', [UnitController::class, 'index'])->name('branchUnits.index');
    Route::get('branchs/{id}/units/{unit}/show', [UnitController::class, 'show'])->name('branchUnits.show');

    Route::resource('products', ProductController::class);
    Route::get('branchs/{id}/products', [ProductController::class, 'index'])->name('branchProducts.index');
    Route::get('branchs/{id}/products/{product}/show', [ProductController::class, 'show'])->name('branchProducts.show');

    Route::resource('reports', ReportController::class);
    Route::get('branchs/{id}/reports', [ReportController::class, 'index'])->name('branchsReports.index');
    Route::get('reports/product-availability/generate', [ReportController::class, 'availabilityReport'])->name('headAvailability.report');
    Route::get('reports/product-availability-warehouse/generate', [ReportController::class, 'availabilityByWarehouse'])->name('headAvailability.warehouse.report');
    Route::get('branchs/{id}/reports/product-availability/generate', [ReportController::class, 'availabilityReport'])->name('branchAvailability.report');
    Route::get('branchs/{id}/reports/product-availability-warehouse/generate', [ReportController::class, 'availabilityByWarehouse'])->name('branchAvailability.warehouse.report');

    Route::resource('roles', RoleController::class);
    Route::controller(PurchaseandSaleController::class)->prefix('{type}')->group(function () {
        Route::get('/', 'index')->name('purchaseSale.index');
        Route::get('/create', 'create')->name('purchaseSale.create');
        Route::post('/store', 'store')->name('purchaseSale.store');
        Route::delete('/{typeId}/destroy', 'destroy')->name('purchaseSale.destroy');
        Route::get('/{typeId}/edit', 'edit')->name('purchaseSale.edit');
        Route::put('/{typeId}/update', 'update')->name('purchaseSale.update');
        Route::get('/{typeId}/show', 'show')->name('purchaseSale.show');
    });

    Route::controller(PurchaseandSaleController::class)->prefix('branchs/{id}/{type}')->group(function () {
        Route::get('/', 'index')->name('branch.purchaseSale.index');
        Route::get('/create', 'create')->name('branch.purchaseSale.create');
        Route::post('/store', 'store')->name('branch.purchaseSale.store');
        Route::delete('/{typeId}/destroy', 'destroy')->name('branch.purchaseSale.destroy');
        Route::get('/{typeId}/edit', 'edit')->name('branch.purchaseSale.edit');
        Route::put('/{typeId}/update', 'update')->name('branchs.purchaseSale.update');
        Route::get('/{typeId}/show', 'show')->name('branchs.purchaseSale.show');
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