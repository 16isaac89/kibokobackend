<?php
use App\Models\Dealer;
use App\Models\Product;
use App\Models\Customer;
use App\Http\Controllers\Helper\Efris\KeysController;
use App\Http\Controllers\Helper\Efris\PostdataController;
use App\Http\Controllers\Helper\Efris\InvoiceController;
use App\Http\Controllers\Helper\Efris\ProductController;

Route::get('/', 'Site\HomeController@index')->name('site.home');
Route::get('/about', 'Site\HomeController@about')->name('site.about');
Route::get('/rental', 'Site\HomeController@rental')->name('site.rental');
Route::get('/contact', 'Site\HomeController@contact')->name('site.contact');
Route::post('/save/order', 'Site\HomeController@saveOrder')->name('save.order');
Route::get('/single/car/{car}', 'Site\HomeController@singleCar')->name('single.car');
Route::get('/track/booking', 'Site\HomeController@trackBooking')->name('track.booking');
Route::post('admin/contact/save','Site\HomeController@message')->name('contactus.save');
Route::post('/booking/details', 'Site\HomeController@bookingDetails')->name('booking.details');


Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', '2fa']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');


    Route::resource('expensecategories', 'ExpenseCategoryController');
    Route::resource('expenses', 'ExpenseController');

    //efris setup
Route::get('/admin/get/key','EfrisSetupController@getkey')->name('get.efriskey');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::post('users/media', 'UsersController@storeMedia')->name('users.storeMedia');
    Route::post('users/ckmedia', 'UsersController@storeCKEditorImages')->name('users.storeCKEditorImages');
    Route::resource('users', 'UsersController');

    //Presale Orders
    Route::get('/presaleorders/index', 'PresaleOrdersController@index')->name('presaleorders.index');
    Route::get('/presaleorders/search', 'PresaleOrdersController@search')->name('presaleorders.search');
    Route::get('/presaleorders/searchbydate', 'PresaleOrdersController@searchByDate')->name('presaleorders.searchbydateview');
    Route::post('/presaleorders/searchbydate', 'PresaleOrdersController@searchByDate')->name('presaleorders.searchbydatepost');
    Route::get('/presaleorders/export/{type}', 'PresaleOrdersController@exportPresale')->name('presaleorders.export');

    // Map
    Route::delete('maps/destroy', 'MapController@massDestroy')->name('maps.massDestroy');
    Route::resource('maps', 'MapController');



    // Customer
    Route::delete('customers/destroy', 'CustomerController@massDestroy')->name('customers.massDestroy');
    Route::post('customers/media', 'CustomerController@storeMedia')->name('customers.storeMedia');
    Route::post('customers/ckmedia', 'CustomerController@storeCKEditorImages')->name('customers.storeCKEditorImages');
    Route::post('customers/parse-csv-import', 'CustomerController@parseCsvImport')->name('customers.parseCsvImport');
    Route::post('customers/process-csv-import', 'CustomerController@processCsvImport')->name('customers.processCsvImport');
    Route::post('/customer/routes/get', 'CustomerController@getRoutes')->name('customer.routesget');
    Route::get('admin/customers/export/excel', 'CustomerController@exportExcel')->name('customers.export.excel');
Route::get('admin/customers/export/csv', 'CustomerController@exportCsv')->name('customers.export.csv');
    Route::resource('customers', 'CustomerController');

    //Routes
    Route::post('routes/parse-csv-import', 'RoutesController@parseCsvImport')->name('routes.parseCsvImport');
    Route::post('routes/process-csv-import', 'RoutesController@processCsvImport')->name('routes.processCsvImport');
    Route::resource('routes', 'RoutesController');
    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);


    // Push Notification
    Route::delete('push-notifications/destroy', 'PushNotificationController@massDestroy')->name('push-notifications.massDestroy');
    Route::resource('push-notifications', 'PushNotificationController');

    Route::get('global-search', 'GlobalSearchController@search')->name('globalSearch');

    //brands
    Route::get('brand/getproducts','ProductBrandController@brandProducts')->name('brand.products');
    Route::get('brand/delete','ProductBrandController@delete')->name('brand.delete');
    Route::post('brand/edit','ProductBrandController@editBrand')->name('edit.productbrand');
    Route::resource('brands','ProductBrandController');

    //products
    Route::post('products/parse-csv-import', 'ProductsController@parseCsvImport')->name('products.parseCsvImport');
    Route::post('products/process-csv-import', 'ProductsController@processCsvImport')->name('products.processCsvImport');

    Route::get('product/cost/view','ProductsController@productcost')->name('product.cost');
    Route::post('product/save/cost','ProductsController@saveproductcost')->name('save.cost');
    Route::post('product/save/batch','ProductsController@savebatch')->name('save.batch');
    Route::get('product/view/batches','ProductsController@viewbatches')->name('product.batches');
    Route::get('product/delete/batch/{stock}','ProductsController@deletebatch')->name('product.deletebatch');

    Route::get('product/view/addbatches','ProductsController@addbatchesview')->name('product.addbatches');
    Route::post('product/save/addbatches','ProductsController@saveaddbatch')->name('product.saveaddbatch');

    Route::get('product/delete','ProductsController@delete')->name('product.delete');
    Route::get('product/view/editlocation','ProductsController@editlocationview')->name('product.vieweditlocation');
    Route::post('product/view/saveeditlocation','ProductsController@saveeditlocation')->name('product.saveeditlocation');

    Route::get('product/view/addcount','ProductsController@viewaddcount')->name('product.addcount');
    Route::post('product/store/count','ProductsController@storecount')->name('product.storecount');
    Route::get('product/view/edit','ProductsController@viewedit')->name('product.viewedit');
    Route::post('product/edit','ProductsController@editProduct')->name('product.edit');
    Route::get('product/details','ProductsController@productDetails')->name('product.details');
    Route::resource('products','ProductsController');
    //Dealers
    Route::post('dealers/parse-csv-import', 'DealersController@parseCsvImport')->name('dealers.parseCsvImport');
    Route::post('dealers/process-csv-import', 'DealersController@processCsvImport')->name('dealers.processCsvImport');
    Route::post('dealer/target/add','DealersController@dealerTarget')->name('dealer.target');
    Route::post('dealer/edit','DealersController@editDealer')->name('edit.dealer');
    Route::get('efris/get/taxpayer','DealersController@getDealer')->name('efris.dealer');

    Route::post('/save/dealer/user','DealersController@savedealeradmin')->name('dealer.user');
    Route::get('/dealer/add/sub/{dealer}','DealersController@addsub')->name('dealer.addsub');
    Route::post('/dealer/subprice','DealersController@subprice')->name('dealer.subprice');
    Route::resource('dealers','DealersController');

    //taxes
    Route::resource('taxes','TaxController');

    //dealer subs
    Route::resource('dealersubs','DealerSubscriptionController');
    //Dispatch
    Route::post('dispatch/savecopy','DispatchController@saveCopy')->name('dispatch.savecopy');
    Route::get('dispatch/copy','DispatchController@getCopy')->name('dispatch.copy');
    Route::get('dispatch/refill','DispatchController@refill')->name('dispatch.refill');
    Route::get('dispatch/products','DispatchController@getItems')->name('dispatch.items');
    Route::resource('dispatch','DispatchController');
    //Brand

    //contact us
    Route::get('admin/contact','ContactUsController@index')->name('contactus.index');
    Route::get('admin/contact/handle/{message}','ContactUsController@handle')->name('contactus.handle');


    //reports
    Route::get('sale/reports','ReportsController@index')->name('sales.report');
    Route::get('exec/reports','ReportsController@exec')->name('exec.reports');
    Route::get('subd/report','ReportsController@subd')->name('subd.reports');
    Route::get('route/reports','ReportsController@route')->name('route.reports');
    Route::get('van/report','ReportsController@van')->name('van.reports');
    Route::get('rep/report','ReportsController@rep')->name('rep.reports');

    //search reports
    Route::post('search/rep/reports','SearchReportsController@rep')->name('searchrep.report');

    //Goodscategory
    Route::post('goodscategory/parse-csv-import', 'EfrisGoodsCategoryController@parseCsvImport')->name('efris-goods-categories.parseCsvImport');
    Route::post('goodscategory/process-csv-import', 'EfrisGoodsCategoryController@processCsvImport')->name('efris-goods-categories.processCsvImport');
    Route::get('efris/categories','EfrisGoodsCategoryController@searchCategories')->name('efrisgoodsategory.get');
    Route::resource('efrisgoodsategory','EfrisGoodsCategoryController');


    //Settings
    Route::resource('settings','SettingController');


    //Subscriptions
    Route::resource('subscriptions','SubscriptionsController');

    //Efris product controller

    Route::post('/admin/opening/product', 'EfrisProductController@openingstock')->name('openingstock.product');
    Route::get('/admin/sync/product', 'EfrisProductController@syncproduct')->name('sync.product');
    Route::post('/admin/stock/product', 'EfrisProductController@restock')->name('restock.product');


    //customer category
    Route::get('/custcategories', 'CustomerCategoryController@index')->name('custcategory.index');
    Route::post('custcategories/edit', 'CustomerCategoryController@edit')->name('custcategory.edit');
    Route::post('custcategories/add', 'CustomerCategoryController@store')->name('custcategory.add');


    // Efris Setting
    Route::delete('efris-settings/destroy', 'EfrisSettingController@massDestroy')->name('efris-settings.massDestroy');
    Route::post('efris-settings/parse-csv-import', 'EfrisSettingController@parseCsvImport')->name('efris-settings.parseCsvImport');
    Route::post('efris-settings/process-csv-import', 'EfrisSettingController@processCsvImport')->name('efris-settings.processCsvImport');
    Route::resource('efris-settings', 'EfrisSettingController');

      // Performance Setting
      Route::delete('performance-settings/destroy', 'PerformanceSettingController@massDestroy')->name('performance-settings.massDestroy');
      Route::post('performance-settings/parse-csv-import', 'PerformanceSettingController@parseCsvImport')->name('performance-settings.parseCsvImport');
      Route::post('performance-settings/process-csv-import', 'PerformanceSettingController@processCsvImport')->name('performance-settings.processCsvImport');
      Route::resource('performance-settings', 'PerformanceSettingController');

      // Performance
      Route::delete('performances/destroy', 'PerformanceController@massDestroy')->name('performances.massDestroy');
      Route::resource('performances', 'PerformanceController');


     //Locations
     Route::get('/locations', 'LocationsController@index')->name('locations.index');
     Route::post('locations/edit', 'LocationsController@edit')->name('locations.edit');
     Route::post('locations/add', 'LocationsController@store')->name('locations.add');

     //stock management

     Route::post('/stock/search/count', 'StockController@searchcount')->name('stock.searchcount');
     Route::get('/stock/count', 'StockController@count')->name('stock.count');
     Route::get('/stock/hold', 'StockController@hold')->name('stock.hold');
     Route::post('/search/detailed/stock/hold', 'StockController@detailedsearch')->name('detailedstock.searchhold');

     Route::get('/general/stock/hold', 'StockController@gstock')->name('gstock.hold');
     Route::post('/search/general/stock/hold', 'StockController@searchgstockhold')->name('searchgstockhold.hold');

     Route::get('/stock/request', 'StockController@request')->name('stock.request');
     Route::post('/search/stock/request', 'StockController@requestsearch')->name('stock.searchrequest');
     Route::get('/stock/vanmovement', 'StockController@vanmovement')->name('stock.vanmovement');
     Route::post('/stock/vanmovement/search', 'StockController@vanmovementsearch')->name('stock.vanmovementsearch');
     Route::resource('stocks','StockController');

     //Purchases
     Route::get('/search/purchase/edit', 'PurchaseOrderController@edit')->name('purchase.edit');
     Route::post('/search/purchase/save/edit', 'PurchaseOrderController@postedit')->name('purchase.saveedit');
     Route::post('/search/purchase', 'PurchaseOrderController@search')->name('purchase.search');
     Route::get('/receive/purchase/get', 'PurchaseOrderController@receiveview')->name('purchase.receiveview');
     Route::post('/receive/purchase/post', 'PurchaseOrderController@receivepost')->name('purchase.receivepost');
     Route::post('/return/purchase/post', 'PurchaseOrderController@returnpurchase')->name('purchase.return');
     Route::post('/purchase/postedit', 'PurchaseOrderController@postedit')->name('purchase.postedit');
     Route::get('/purchase/return/view', 'PurchaseOrderController@returnview')->name('purchase.returnview');
     Route::post('/purchase/return/post', 'PurchaseOrderController@returnpost')->name('purchase.returnpost');
     Route::resource('purchases','PurchaseOrderController');

     //suppliers
     Route::get('/suppliers', 'SuppliersController@index')->name('suppliers.index');
     Route::post('/supplier/add', 'SuppliersController@add')->name('suppliers.store');
     Route::post('/supplier/edit', 'SuppliersController@edit')->name('suppliers.edit');
     Route::get('/supplier/check', 'SuppliersController@checktin')->name('suppliers.checktin');
     Route::get('/supplier/edit/view', 'SuppliersController@editview')->name('suppliers.editview');

    //product units
    Route::get('/product/units/index', 'ProductUnitController@index')->name('productunits.index');
    Route::get('/product/units/viewadd', 'ProductUnitController@viewadd')->name('productunits.viewadd');
    Route::post('/productunits/add', 'ProductUnitController@store')->name('productunits.storeunit');
    Route::get('/productunits/viewedit', 'ProductUnitController@edit')->name('units.edit');

    Route::post('/productunits/edit', 'ProductUnitController@update')->name('units.update');

     //sales report
     Route::get('/sales/report/daybook', 'SalesReportController@daybook')->name('salesreports.daybook');
     Route::get('/sales/report/summary/add', 'SalesReportController@summarydaybookadd')->name('summaryday.addview');
     Route::post('/sales/search/customerpfm', 'SalesReportController@searchcustomerpfm')->name('search.pfm');
     Route::post('/search/sales/report/', 'SalesReportController@indexsearch')->name('adminsearch.salesreport');
     //sales admin
     Route::get('/all/sales','SaleController@index')->name('sales.index');
Route::post('/admin/invoices/search','SaleController@invoicessearch')->name('salesinvoices.search');
Route::get('/admin/receipts','SaleController@receipts')->name('salesreceipts.index');
Route::post('/admin/receipts/search','SaleController@receiptssearch')->name('dealer.receipts.search');

Route::post('/admin/search/sales','SaleController@search')->name('dealer.search.sales');

Route::get('/admin/creditnote/status','SaleController@notestatus')->name('note.status');
Route::get('/admin/sale/appcredit','SaleController@creditnoteview')->name('sales.creditview');
Route::get('/admin/sale/drview','SaleController@debitnoteview')->name('sales.debitview');
Route::post('/admin/sale/notes','SaleController@creditdebitnote')->name('sales.notesform');
Route::post('/admin/sale/debitnote','SaleController@debitnote')->name('post.debitnote');



    //product category
    Route::get('/product/category/delete', 'ProductsCategoryController@delete')->name('productcategory.delete');
    Route::get('/product/category/index', 'ProductsCategoryController@index')->name('productcategory.index');
       Route::post('/product/category/store', 'ProductsCategoryController@store')->name('productcategory.store');
       Route::post('/product/category/edit', 'ProductsCategoryController@edit')->name('productcategory.edit');

     Route::post('/sales/report/van/dispatch', 'SalesReportController@getvan')->name('get.vandispatch');
     Route::post('/sales/report/van/addsummary', 'SalesReportController@addsummary')->name('post.summary');
     Route::post('/sales/report/summary/search', 'SalesReportController@summarydaybooksearch')->name('summary.search');
     Route::post('/sales/report/search', 'SalesReportController@searchreports')->name('search.salesreport');
     Route::post('/sales/daybook/search', 'SalesReportController@searchdaybook')->name('search.daybook');

     Route::get('/sales/report/summary/daybook', 'SalesReportController@summarydaybook')->name('salesreports.summaryday');
     Route::get('/sales/report/sales', 'SalesReportController@index')->name('salesreport.index');
     Route::get('/sales/report/custome/pfm', 'SalesReportController@customerpfm')->name('salesreports.pfm');

     //vans
     Route::get('/admin/vans','VansController@index')->name('vans.index');
     Route::get('/admin/vans/viewcount','VansController@viewcount')->name('vans.viewcount');
     Route::post('/admin/vans/count/dispatches','VansController@search')->name('vans.dispatched');
     Route::post('/admin/save/count','VansController@savecount')->name('save.count');


});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth', '2fa']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
        Route::post('profile/two-factor', 'ChangePasswordController@toggleTwoFactor')->name('password.toggleTwoFactor');
    }
});
Route::group(['namespace' => 'Auth', 'middleware' => ['auth', '2fa']], function () {
    // Two Factor Authentication
    if (file_exists(app_path('Http/Controllers/Auth/TwoFactorController.php'))) {
        Route::get('two-factor', 'TwoFactorController@show')->name('twoFactor.show');
        Route::post('two-factor', 'TwoFactorController@check')->name('twoFactor.check');
        Route::get('two-factor/resend', 'TwoFactorController@resend')->name('twoFactor.resend');
    }
});


Route::group(['prefix' => 'dealer', 'as' => 'dealer.', 'namespace' => 'Dealer'], function () {
Route::get('/subd/home/page', 'HomeController@index')->name('dashboard.home');
});


Route::group(['namespace' => 'Dealer','middleware' =>'authdealer'], function () {
Route::get('/dealer/home/page', 'HomeController@index')->name('dashboard.home');
Route::get('/dealer/customers', 'CustomerController@index')->name('customer.index');

Route::get('dealer/supplier/check', 'SuppliersController@checktin')->name('dealer.suppliers.checktin');


Route::get('/dealer/login/page', 'Auth\LoginController@index')->name('dealer.login.view');
Route::post('/dealer/post/login', 'Auth\LoginController@login')->name('dealer.login.post');
Route::get('/dealer/post/logout', 'Auth\LoginController@signout')->name('dealer.signout.post');

Route::get('/dealer/user/updatepwd','DealerUserController@updatepwd')->name('update.dealer.userpwd');

Route::get('/dealer/users/updateform/','DealerUserController@updateUserForm')->name('update.user.form');
Route::post('/dealer/users/save/','DealerUserController@save')->name('dealer.user.store');
Route::post('/dealer/users/update/','DealerUserController@updateUser')->name('update.user.dealer');

Route::post('/dealerusers/target/history','DealerUserController@targethistory')->name('dealer.users.targetindex');

Route::get('/dealerusers/home','DealerUserController@home')->name('dealer.users.index');


//dealer products
Route::get('dealer/product-edit/{product}','DealerProductController@viewedit')->name('dealer.product.viewedit');
Route::post('/update/product/{product}','DealerProductController@updateProduct')->name('update.dealer.product');
Route::post('/dealer/product/store','DealerProductController@store')->name('store.dealer.product');
Route::get('/dealer/product/bulkedit','DealerProductController@bulkEdit')->name('dealer.product.bulkEdit');
Route::post('/dealer/product/postbulkedit','DealerProductController@bulkEditPost')->name('bulk-edit-products.dealer.products');


Route::get('dealer/product/delete','DealerProductController@delete')->name('dealer.product.delete');

//Dealer Efris product methods
Route::get('/dealerefris/sync/{product}','EfrisProductController@syncproduct')->name('dealer.sync.product');
Route::post('/admin/opening/product', 'EfrisProductController@openingstock')->name('dealer.openingstock.product');


Route::get('dealer/product/view/addcount','DealerProductController@viewaddcount')->name('dealer.product.addcount');
Route::post('dealer/product/store/count','DealerProductController@storecount')->name('dealer.product.storecount');

Route::post('dealer/product/edit','DealerProductController@editProduct')->name('dealer.product.edit');
Route::get('dealer/product/details','DealerProductController@productDetails')->name('dealer.product.details');
Route::resource('products','DealerProductController');

Route::resource('dealerbrands','BrandController');
Route::resource('dealersuppliers','SupplierController');
Route::resource('dealerbranches','BranchController');
Route::resource('dealercategories','ProductCategoryController');


//tax
Route::resource('dealertaxes','TaxController');


Route::get('routeplan/view','RoutePlanController@index')->name('routeplan.view');
Route::get('route/customers','RoutePlanController@getCustomer')->name('route.customers');

Route::get('/dealer/user/routes/customers/','DealerUserController@userdetails')->name('user.assign.details');

Route::get('/dealer/user/delete/route','DealerUserController@deleteroute')->name('user.delete.assignroute');
Route::get('/dealer/user/delete/plan','DealerUserController@deleteplan')->name('user.delete.plan');

Route::post('/edit/route/','RouteController@updateRoute')->name('dealer.route.edit');
Route::resource('routes','RouteController');
Route::resource('customers','CustomerController');

Route::post('/edit/van/','VanController@updateVan')->name('dealer.van.edit');
Route::resource('vans','VanController');

Route::resource('routeplans','RoutePlanController');

Route::post('/add/skutarget/','TargetController@storesku')->name('dealer.sku.target');
Route::resource('salertargets','TargetController');

Route::get('/dealer/sale/items','ReportsController@items')->name('dealer.sales.items');
Route::get('/dealer/report/exec','ReportsController@exec')->name('dealer.execreport');
Route::get('/dealer/report/index/table','ReportsController@datatableindex')->name('dealer.indexreports');
Route::get('/dealer/report/van','ReportsController@van')->name('dealer.vanreport');
Route::get('/dealer/searchreport/van','ReportsController@searchvan')->name('dealer.searchvanreport');
Route::post('/dealer/report/van/orders','ReportsController@getvansales')->name('get.vanorders');

Route::get('/dealer/report/route','ReportsController@route')->name('dealer.routereport');
Route::get('/dealer/report/route/order','ReportsController@getroutesales')->name('get.routeorders');
Route::post('/dealer/report/rep/order','ReportsController@getrepsales')->name('get.reporders');
Route::post('/dealer/report/searchrep/orders','ReportsController@searchrep')->name('search.reporders');
Route::get('/dealer/report/brand','ReportsController@brand')->name('dealer.brandreport');
Route::post('/dealer/report/brand/orders','ReportsController@getbrandsales')->name('get.brandorders');
Route::post('/dealer/search/brandreport','ReportsController@searchbrandreport')->name('dealer.searchbrandreport');


//Normal Reports
Route::post('/dealer/report/searchroute','ReportsController@searchroute')->name('dealer.searchroutereport');
Route::get('/dealer/report/rep','ReportsController@rep')->name('dealer.repreport');
Route::get('/dealer/report/trading','ReportsController@trading')->name('dealer.tradingreport');
Route::get('/dealer/report/map','ReportsController@map')->name('dealer.mapreport');
Route::get('/dealer/salesreport/search','ReportsController@searchsales')->name('dealer.searchsales');
Route::resource('salerreports','ReportsController');

//Exec reports
Route::get('exec/dealer/sale/items','ExecutiveReportsController@items')->name('execdealer.sales.items');
Route::get('exec/dealer/report/map','ExecutiveReportsController@map')->name('execdealer.mapreport');
Route::get('execdealer/report/exec','ExecutiveReportsController@exec')->name('execdealer.execreport');
Route::get('execdealer/report/route','ExecutiveReportsController@route')->name('execdealer.routereport');
Route::get('execdealer/report/van','ExecutiveReportsController@van')->name('execdealer.vanreport');
Route::get('execdealer/report/rep','ExecutiveReportsController@rep')->name('execdealer.repreport');
Route::get('execdealer/report/brand','ExecutiveReportsController@brand')->name('execdealer.brandreport');
Route::resource('execsalerreports','ExecutiveReportsController');

Route::get('/dealer/brand/getproducts','DispatchController@brandProducts')->name('dealer.brand.products');
Route::get('/dealer/product/batch','DispatchController@productBatch')->name('dealer.product.batch');
Route::get('/dealer/batch/price','DispatchController@batchPrice')->name('dealer.batch.price');
Route::get('/dealer/product/details','DispatchController@productDetails')->name('dealer.product.details');
Route::get('/dealer/dispatch/records','DispatchController@records')->name('dealer.dispatch.records');
Route::post('/dealer/getvan/records','DispatchController@getvanrecords')->name('partner.van.getdispatches');
Route::get('/dealer/van/records','DispatchController@vanrecords')->name('partner.van.dispatches');
Route::post('/dealer/save/count','DispatchController@savecount')->name('dealer.save.stockcount');
Route::post('/dealer/dispatch/refill','DispatchController@refill')->name('dealer.dispatch.refill');
Route::post('/dealer/dispatch/saverefill','DispatchController@saverefill')->name('dealer.save.stockrefill');

Route::get('/dealer/dispatch/products','DispatchController@getItems')->name('dealer.dispatch.items');

Route::get('/dealer/dispatch/topup/view','DispatchController@viewtopup')->name('dealer.view.topup');
Route::post('/dealer/dispatch/topup/store','DispatchController@topupstore')->name('dealer.topup.store');


Route::resource('dispatches','DispatchController');
//stock requests
Route::get('/dealer/update/requests/{request}','StockRequestsController@setDelivered')->name('dealer.request.setasdelivered');
Route::get('/dealer/get/stockreqs','StockRequestsController@stockreqs')->name('dealer.getstock.requests');
Route::post('/dealer/search/stockreqs','StockRequestsController@search')->name('dealer.searchstock.requests');
Route::post('/dealer/store/stockreqs','StockRequestsController@store')->name('dealer.storestock.requests');
Route::post('/dealer/reject/stockreqs','StockRequestsController@reject')->name('dealer.reject.storestock');
Route::get('/dealer/stockreqs/approve','StockRequestsController@viewapprove')->name('dealer.approve.requests');
Route::post('/dealer/stockreqs/postapprove','StockRequestsController@postapprove')->name('dealer.postapprove.requests');


Route::get('/dealer/invoices','SaleController@invoices')->name('dealer.invoices.index');
Route::post('/dealer/invoices/search','SaleController@invoicessearch')->name('dealer.invoices.search');
Route::get('/dealer/receipts','SaleController@receipts')->name('dealer.receipts.index');
Route::post('/dealer/receipts/search','SaleController@receiptssearch')->name('dealer.receipts.search');

Route::post('/dealer/search/sales','SaleController@search')->name('dealer.search.sales');

Route::get('/dealer/creditnote/status','SaleController@notestatus')->name('dealer.note.status');
Route::get('/dealer/sale/appcredit','SaleController@creditnoteview')->name('dealer.sales.creditview');
Route::get('/dealer/iewsale/{sale}','SaleController@receiptview')->name('dealer.sales.receiptview');
Route::get('/dealer/sale/drview','SaleController@debitnoteview')->name('dealer.sales.debitview');
Route::post('/dealer/sale/notes','SaleController@creditdebitnote')->name('dealer.sales.notesform');
Route::post('/dealer/sale/debitnote','SaleController@debitnote')->name('dealer.post.debitnote');



Route::post('/returns/add/return','ReturnsController@addreturnview')->name('dealer.addreturnview');
Route::post('/returns/search','ReturnsController@searchindex')->name('dealer.searchreturns');
Route::get('/dealer/sale/returns','ReturnsController@index')->name('dealer.getreturns');
Route::get('/dealer/get/return','ReturnsController@getreturn')->name('dealer.getreturn');
Route::post('/dealer/save/return','ReturnsController@savereturn')->name('dealer.savereturn');
Route::post('/dealer/save/admin/return','ReturnsController@saveadminreturn')->name('dealer.saveadminreturn');

Route::get('/dealer/credit/notes','EfrisDocumentController@creditnoteindex')->name('dealer.creditnote.index');
Route::post('/dealer/creditnotes/search','EfrisDocumentController@creditnotesearch')->name('dealer.creditnote.search');
Route::post('/dealer/credit/cancel','EfrisDocumentController@cancelcreditnote')->name('dealer.creditnote.cancel');
Route::get('/dealer/credit/details','EfrisDocumentController@creditnotedetails')->name('dealer.creditnote.details');
Route::get('/dealer/credit/status','EfrisDocumentController@creditnotestatus')->name('dealer.creditnote.status');

Route::resource('dealersales','SaleController');

//dealer units
Route::resource('productunits','ProductUnitController');
//Dealer Efris
Route::post('/dealer/sync/product','EfrisProductController@syncproduct')->name('partner.sync.product');
Route::post('/dealer/sync/product','EfrisProductController@getkey')->name('partner.get.efriskey');

//Dealer cart
Route::get('/dealer/pos/screen','CartController@index')->name('dealer.posscreen');
Route::post('/dealer/pos/save','CartController@save')->name('dealer.possave');
Route::post('/dealer/pos/save/customer','CartController@savecustomer')->name('dealer.possavecustomer');
Route::get('/dealer/pos/get/customers','CartController@getcustomers')->name('dealer.get.customers');
//
Route::get('/dealer/vans/count/dispatches/{dispatch}','DispatchController@searchdispatch')->name('dealer.vans.dispatched');
Route::post('/dealer/vans/savecount/dispatches','DispatchController@savedispatchcount')->name('dealer.vans.savecount');


Route::get('/tax/payer/info', 'TestController@index');

Route::resource('dealerroles','RoleController');
Route::get('/restock/product', 'EfrisProductController@restock');
Route::get('/applycredit/note', 'SaleController@creditdebitnote');
});

Route::get('get/private/key', 'Helper\Efris\KeysController@getPrivateKey');

Route::get('get/aes/key/efris', function(){

    $dealer = Dealer::find(1);
   // dd($dealer);

   // foreach($dealers as $dealer){
        $keypath = $dealer->privatekey;
        $keypwd = $dealer->keypwd;
        $tin = $dealer->tin;
        $deviceno = $dealer->deviceno;
       // $token =
       //dd($keypath);
        $privatek = (new KeysController)->getPrivateKey($keypath,$keypwd);
        //dd($privatek);
      //  openssl_private_decrypt(base64_decode($encrypted_aeskey), $decrypted_aeskey,$privatekey );
     //   dd($decrypted_aeskey);
//dd($privatek);
        $aeskey = (new KeysController)->getAesKey($tin,$deviceno,$privatek);
        dd($aeskey);
         $dealer->aeskey = $aeskey;
         $dealer->save();
  //  }

});

Route::get('get/efris/sale', function(){

    $dealerefris = Dealer::find(1);
    $supplier = Dealer::find(4);
   // dd($dealers);

   // foreach($dealers as $dealer){
        $keypath = $dealerefris->privatekey;
        $keypwd = $dealerefris->keypwd;
        $tin = $dealerefris->tin;
        $deviceno = $dealerefris->deviceno;
		//dd($keypath);
       // $token =
        $privatek = (new KeysController)->getPrivateKey($keypath,$keypwd);

       // $aeskey = (new KeysController)->getAesKey($tin,$deviceno,$privatek);
       $item = Product::find(5);
       $aeskey = $dealerefris->aeskey;
       $quantity = 10000;
     //   $item = Product::find(17);
     //   dd($item);
     //  $message = (new ProductController)->saveProduct($item,$aeskey,$privatek,$tin,$deviceno,$quantity,$supplier);
      // $message = (new ProductController)->addproductStock($item,$aeskey,$privatek,$tin,$deviceno,$quantity,$supplier);
//dd($message);

       $goodsdetailss = array();
       $taxDetails = array();
       $ordernumber = 0;
        $prds = [12,14,15];

       $saleid = "389";
//




       $items = Product::whereIn('id',$prds)->get();
//1000029381
//dd($items);
  foreach($items as $item){
    $sellingprice = 2500;
    $net = 5*$sellingprice;

    $taxes = App\Models\Tax::find($item->tax_id);

    $tax = $taxes->value > 0 ? $taxes->value/100 : 0;

    $discountdetails = "";
    $netamt = $net-$net*0.18;
    $taxamm = 0.18*($net/1.18);
    $netamm = $net/1.18;
    $discount = $item->id === 11 || $item->id === "11" ? 1000 : 0;
    $quantity = match ($item->id) {
        12 => 1,
         14 => 2,
         15 => 3,
    };
    $sellingprice =  match ($item->id) {
        12 => 2500,
         14 => 4000,
         15 => 3500,
    };
    //$discount = 100;
    //$taxamount = floor(($tax*(($sellingprice*1)/1.18))*100)/100;

    $gooddetails ="";

    $taxcategorycode = match ($taxes->value) {
        '18' => '01',
        '0' => '02',
        '-' => '03',
    };
    $taxrate = match ($taxes->value) {
        '18' => 0.18,
        '0' => '0',
        '-' => '-',
    };
    $taxamount = match ($taxes->value) {
        '18' => floor(($tax*(($sellingprice*$quantity)/1.18))*100)/100,
        '0' => floor((0*(($sellingprice*$quantity)/1.18))*100)/100,
        '-' => floor((0*(($sellingprice*$quantity)/1.18))*100)/100,
    };
    $taxamountdisc = floor(($tax*(($discount)/1.18))*100)/100;

       if($discount>0){
        $gooddetails = (Object)[
             "item"=> $item->name,
             "itemCode"=> $item->code,
             'goodsCategoryId'=>$item->category,
             "qty"=> $quantity,
             "unitOfMeasure"=> $item->unit,
             "unitPrice"=> $sellingprice,
             "total"=> $sellingprice*$quantity,
            //  "taxCategoryCode"=> "01",
            //  "taxCategory"=>"Standard",

             "taxRate"=>$taxrate,
             "tax"=>$taxamount,

            //  "taxRate"=>0.18,
            //  "tax"=>$taxamount,
             //LINE FOR DISCOUNT
             "discountTotal"=> -$discount,
             "discountTaxRate"=> "",
             "orderNumber"=> $ordernumber++,
             "discountFlag"=> "1",
             "deemedFlag"=> "2",
             "exciseFlag"=> "2",
             "categoryId"=> "1234",
             "categoryName"=> "Test",
             "commodityCategoryId"=>$item->category,
             "goodsCategoryName"=> "Test",
             "exciseRate"=> "",
             "exciseRule"=> "1",
             "exciseTax"=> "",
             "pack"=> "1",
             "stick"=> "20",
             "exciseCurrency"=> "UGX",
             "exciseRateName"=> "123",
             "vatApplicableFlag"=>"1"
         ];
         $discountdetails = (Object)[
           "item"=> $item->name." (Discount)",
           "itemCode"=> $item->code,
           'goodsCategoryId'=>$item->category,
           "qty"=> "",
           "unitOfMeasure"=> $item->unit,
           "unitPrice"=> "",
           "total"=> -$discount,
           "taxRate"=>$taxrate,
           "tax"=>-$taxamountdisc,
           //LINE FOR DISCOUNT
           "discountTotal"=> "",
           "discountTaxRate"=> "",
           "orderNumber"=> $ordernumber++,
           "discountFlag"=> "0",
           "deemedFlag"=> "2",
           "exciseFlag"=> "2",
           "categoryId"=> "1234",
           "categoryName"=> "Test",
           "commodityCategoryId"=>$item->category,
           "goodsCategoryName"=> "Test",
           "exciseRate"=> "",
           "exciseRule"=> "1",
           "exciseTax"=> "",
           "pack"=> "1",
           "stick"=> "20",
           "exciseCurrency"=> "UGX",
           "exciseRateName"=> "123",
           "vatApplicableFlag"=>"1"
       ];
     $taxDetail = (Object)[
       "taxCategoryCode"=> $taxcategorycode,
    //    "taxCategory"=>"Standard",
    //    "taxRateName"=>"VAT-Standard",
       "netAmount"=>$tax > 0 ? floor((($quantity*$sellingprice)/1.18 + 0.18*(($sellingprice*$quantity)/1.18)-floor((0.18*(($sellingprice*$quantity)/1.18))*100)/100)*100)/100 : floor((($quantity*$sellingprice)/1.18 + 0.18*(($sellingprice*$quantity)/1.18))*100)/100,
           //'netAmount'=>5*$sellingprice,
           "taxRate"=>$taxrate,
           "taxAmount"=>$taxamount,
           //"taxAmount"=>"0",
           "grossAmount"=>  $sellingprice*$quantity,
       "exciseCurrency"=> "UGX",
       "taxRateName"=> "123"
     ];
       }else{
           $gooddetails = (Object)[
            "item"=> $item->name,
             "itemCode"=> $item->code,
             'goodsCategoryId'=>$item->category,
             "qty"=> $quantity,
             "unitOfMeasure"=> $item->unit,
             "unitPrice"=> $sellingprice,
             "total"=> $sellingprice*$quantity,
             //"taxCategoryCode"=> "01",
             //"taxCategory"=>"Standard",
             "taxRate"=>$taxrate,
             "tax"=>$taxamount,
            //  "taxRate"=>0.18,
            //  "tax"=>$taxamount,
             //LINE FOR DISCOUNT
             "discountTotal"=> "",
             "discountTaxRate"=> "",
             "orderNumber"=> $ordernumber++,
             "discountFlag"=> "2",
             "deemedFlag"=> "2",
             "exciseFlag"=> "2",
             "categoryId"=> "1234",
             "categoryName"=> "Test",
             "commodityCategoryId"=>$item->category,
             "goodsCategoryName"=> "Test",
             "exciseRate"=> "",
             "exciseRule"=> "1",
             "exciseTax"=> "",
             "pack"=> "1",
             "stick"=> "20",
             "exciseCurrency"=> "UGX",
             "exciseRateName"=> "123",
             "vatApplicableFlag"=>"1"
         ];
         $taxDetail = (Object)[
            "taxCategoryCode" => $taxcategorycode,
        //    "taxCategory"=>"Standard",
        //    "taxRateName"=>"VAT-Standard",
           "netAmount"=>$tax > 0 ? floor((($quantity*$sellingprice)/1.18 + 0.18*(($sellingprice*$quantity)/1.18)-floor((0.18*(($sellingprice*$quantity)/1.18))*100)/100)*100)/100 : floor((($quantity*$sellingprice)/1.18 + 0.18*(($sellingprice*$quantity)/1.18))*100)/100,
           //'netAmount'=>5*$sellingprice,

           "taxRate"=>$taxrate,
           "taxAmount"=>$taxamount,
           //"taxAmount"=>"0",
           "grossAmount"=>  $sellingprice*$quantity,
           "exciseCurrency"=> "UGX",
           "taxRateName"=> "123"
       ];
         }
         array_push($goodsdetailss,$gooddetails,$discountdetails);
         array_push($taxDetails,$taxDetail);
        }



          $removedups = array_unique( $goodsdetailss, SORT_REGULAR );
          $goodsdetails = array_values(array_filter($removedups));
          //$goodsdetails = array_values(array_filter($goodsdetailss));
          $sumgross = 0;
          $sumgrossed = 0;
          $grossaray = array();
           foreach($taxDetails as $key=>$value){
            // if(isset($value->grossAmount))
            array_push($grossaray,$value-> grossAmount);
             if(isset($value-> grossAmount) && $value-> grossAmount !== '0')
               $sumgrossed += $value->grossAmount;
           }
           $summarytotal = 0;
           foreach($taxDetails as $key=>$value){
             if(isset($value->netAmount))
               $summarytotal += $value->netAmount;
           }

           $taxamount = 0;
           foreach($taxDetails as $key=>$value){
             if(isset($value-> taxAmount) && $value-> taxAmount !== '-')
             $taxamount += $value->taxAmount;
           }
           $sumgross = array_sum($grossaray);
           //dd($sumgross);
          // dd($taxDetails,$taxamount,$goodsdetails);
         //return response()->json(['gds'=>$taxDetails]);
         $customer = "650aa2902a260";
         $route = Customer::where('identification',$customer)->first();
         $customerdetails = Customer::where('identification',$customer)->first();
         $total = $sumgross;
         $itemcount = count($items);
         $efris = (new InvoiceController)->saveInvoice($aeskey,$privatek,$tin,$deviceno,$goodsdetails,
         $taxDetails,$saleid,
         $total,$itemcount,$route,$dealerefris,$sumgross,$summarytotal,$taxamount,$customerdetails);
         //return response()->json(['gds'=>$efris]);
         $json = $efris->json;
         dd($efris,$taxDetails,$goodsdetails,$json);

});


Route::get('get/tax/payer', 'Helper\Efris\KeysController@getTaxPayer');

Route::get('/save/product', 'Helper\EfrisController@saveProduct');
Route::get('/save/invoice', 'Helper\EfrisController@saveInvoice');


Route::get('/applydebit/note', 'Helper\EfrisController@debitnote');



Route::get('/reset/password', function(){
    dd(\Hash::make('123456'));
});




