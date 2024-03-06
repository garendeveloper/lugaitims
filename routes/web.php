<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchasedItemsController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ItemcategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SupplierItemsController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\RequestingItemsController;
use App\Http\Controllers\RequisitionController;


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

Route::group(['middleware'=>['prevent-back-history']], function(){
    Route::get('/', [LoginController::class, 'index'])->name('user.loginPage')->middleware('prevent-back-to-login');
    Route::get('/logout', [LoginController::class, 'logout'])->name('user.logout');
    Route::post('/user/login', [LoginController::class, 'login'])->name('user.login');
    

    Route::group(['middleware'=>['role']], function () {
        Route::get('/get/categorizedChart', [HomeController::class, 'get_categorizedChart'])->name('categorizedChart');
        Route::get('/admin/request/savePartial', [RequestingItemsController::class, 'savePartial']);
        Route::get('/item/categories/list', [ItemcategoryController::class, 'countItems'])->name('categorylist');
        Route::get('/users/get_allUsers', [ItemController::class, 'get_allUsersByJson'])->name('users.get_allUsers');
        Route::get('/datatable/items/get_allItems', [ItemController::class, 'supplier_allItems']);
        Route::get('/items/units', [ItemController::class, 'get_allUnits'])->name('items.units');
        Route::get('/items/brands', [ItemController::class, 'get_allBrands'])->name('items.brands');
        Route::get('/print/item/profile/{id}', [PrintController::class, 'itemprofile']);

        Route::get('/home', [HomeController::class, 'index'])->name('admin.home');
        Route::resource('items', ItemController::class);
        Route::resource('purchasedItems', PurchasedItemsController::class);
        Route::resource('departments', DepartmentController::class);
        Route::resource('users', UserController::class);
        Route::resource('itemcategories', ItemcategoryController::class);
        Route::resource('suppliers', SupplierController::class);
        Route::resource('requestingitems', RequestingItemsController::class);
        Route::resource('requisitions', RequisitionController::class);
        
        

        Route::post('/item/saveItem', [ItemController::class, 'saveItem'])->name('items.saveItem');
        Route::get('/reset/stock', [SupplierItemsController::class, 'resetStock'])->name('supplieritems.resetStock');
        Route::get('/retype/item', [SupplierItemsController::class, 'reTypeItem'])->name('supplieritems.reTypeItem');
        Route::get('/department/office', [UserController::class, 'get_allRequisitioningByJson'])->name('users.allRequisitions');
        Route::get('/supplier/get', [SupplierController::class, 'get_allDataByJson'])->name('suppliers.allSuppliers');
        Route::get('/item/category/get_allItemCategory', [ItemcategoryController::class, 'get_allDataByJson'])->name('itemcategories.get_allDataByJson');
        Route::get('/item/only', [ItemController::class, 'get_allItemOnly'])->name('items.get_allItemOnly');
        Route::get('/positions/allData', [PositionController::class, 'get_allData'])->name('positions.get_allData');
        Route::get('/datatables/items', [ItemController::class, 'get_allItemsInDatatables'])->name('datatables.items');
        Route::get('/datatables/purchasedItems', [ItemController::class, 'get_allDataInDatatables'])->name('datatables.purchasedItems');
        Route::get('/datatables/departments', [DepartmentController::class, 'get_allDataInDatatables'])->name('datatables.departments');
        Route::get('/datatables/users/{id}', [UserController::class, 'get_allDataInDatatables'])->name('datatables.users');

        Route::get('/print/inspection/report/{id}', [PrintController::class, 'inspectionReport']);
        Route::get('/print/filter/report', [PrintController::class, 'filterReport'])->name('print.filter');
        Route::get('/print/filter/report/page/{array}', [PrintController::class, 'filterPage']);

        Route::get('/datatables/requesting/items', [RequestingItemsController::class, 'datatable'])->name('datatables.requestingitems');
        Route::get('/requesting/items/notification', [RequestingItemsController::class, 'realtime_notification'])->name('requestingitems.notification');
        Route::get('/requesting/items/reset/notif', [RequestingItemsController::class, 'resetNotification'])->name('requestingitems.resetNotif');
        Route::get('/requesting/items/get/user/request/{id}', [RequestingItemsController::class, 'get_purchaserRequest']);
        Route::get('/admin/user/profile', [UserController::class, 'adminprofile'])->name('users.adminprofile');
        Route::post('/admin/user/changePass', [UserController::class, 'admin_changePass'])->name("users.admin_changePass");
        Route::get('/admin/requesting/report/{date}/{id}', [RequestingItemsController::class, 'requesteditems_report']);
        Route::get('/admin/monthly/report', [PrintController::class, 'monthlyreport_page'])->name('admin.monthlyreport');
        Route::get('/admin/monthly/report/{month}/{year}/{category}/{weeknumber}', [PrintController::class, 'get_report']);
        Route::get('/admin/monthly/report/print/{month}/{year}/{category}/{weeknumber}', [PrintController::class, 'get_reportPrint']);
        Route::get('/admin/get/categoriesbyjson', [ItemcategoryController::class, 'get_categoriesByJson'])->name('admin.get_categories');
       
        Route::get('/datatables/requesitions', [RequisitionController::class, 'get_datatable'])->name('datatables.requesitions');

    });

    Route::group(['middleware'=>['purchaser']], function(){
        Route::get('/purchaser/home', [UserController::class, 'index'])->name('purchaser.home');
        Route::get('/purchaser/item/all', [ItemController::class, 'get_allSupplierItems'])->name('purchaser.supplierItems');
        Route::get('/purchaser/item/save_cart', [ItemController::class, 'save_cart']);
        Route::get('/items/{item}/purchaserEdit', [ItemController::class, 'purchaserEdit'])->name('purchaser.purchaserEdit');
        Route::get('/purchaser/myRequestedItems', [ItemController::class, 'get_myRequestedItems'])->name('purchaser.get_myRequestedItems');
        Route::get('/user/profile', [UserController::class, 'userprofile'])->name('users.userprofile');
        Route::post('/user/changePass', [UserController::class, 'user_changePass'])->name("users.user_changePass");
    });
});