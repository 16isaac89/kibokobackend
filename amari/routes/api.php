<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::post('users/media', 'UsersApiController@storeMedia')->name('users.storeMedia');
    Route::apiResource('users', 'UsersApiController');

    // Faq Category
    Route::apiResource('faq-categories', 'FaqCategoryApiController');

    // Faq Question
    Route::apiResource('faq-questions', 'FaqQuestionApiController');

    // Extras
    Route::apiResource('extras', 'ExtrasApiController');

    // Ride
    Route::post('rides/media', 'RideApiController@storeMedia')->name('rides.storeMedia');
    Route::apiResource('rides', 'RideApiController');

    // Zones
    Route::apiResource('zones', 'ZonesApiController');

    // Setting
    Route::apiResource('settings', 'SettingApiController');

    // Booking
    Route::apiResource('bookings', 'BookingApiController');

    // Customer
    Route::post('customers/media', 'CustomerApiController@storeMedia')->name('customers.storeMedia');
    Route::apiResource('customers', 'CustomerApiController');

    // Task Status
    Route::apiResource('task-statuses', 'TaskStatusApiController');

    // Task Tag
    Route::apiResource('task-tags', 'TaskTagApiController');

    // Task
    Route::post('tasks/media', 'TaskApiController@storeMedia')->name('tasks.storeMedia');
    Route::apiResource('tasks', 'TaskApiController');

    // Payment Method
    Route::post('payment-methods/media', 'PaymentMethodApiController@storeMedia')->name('payment-methods.storeMedia');
    Route::apiResource('payment-methods', 'PaymentMethodApiController');

    // Expense Category
    Route::apiResource('expense-categories', 'ExpenseCategoryApiController');

    // Income Category
    Route::apiResource('income-categories', 'IncomeCategoryApiController');

    // Expense
    Route::apiResource('expenses', 'ExpenseApiController');

    // Income
    Route::apiResource('incomes', 'IncomeApiController');

    // Zone Ride
    Route::apiResource('zone-rides', 'ZoneRideApiController');

    // Ride Category
    Route::post('ride-categories/media', 'RideCategoryApiController@storeMedia')->name('ride-categories.storeMedia');
    Route::apiResource('ride-categories', 'RideCategoryApiController');

    // Customer Payment
    Route::post('customer-payments/media', 'CustomerPaymentApiController@storeMedia')->name('customer-payments.storeMedia');
    Route::apiResource('customer-payments', 'CustomerPaymentApiController');

    // Customer Wallet
    Route::apiResource('customer-wallets', 'CustomerWalletApiController');

    // Accounts
    Route::apiResource('accounts', 'AccountsApiController');

    // Driver Wallet
    Route::apiResource('driver-wallets', 'DriverWalletApiController');

    // Transaction
    Route::apiResource('transactions', 'TransactionApiController');

    // Invoice
    Route::apiResource('invoices', 'InvoiceApiController');

    // Services
    Route::post('services/media', 'ServicesApiController@storeMedia')->name('services.storeMedia');
    Route::apiResource('services', 'ServicesApiController');
});




Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Sales'], function () {
    Route::post('/login/saler','Auth\LoginController@Login');
    Route::post('/logout/saler','Auth\LoginController@logout');
    //Route::get('/login/saler','Auth\LoginController@Login');
    Route::post('/get/stock','StockController@getStock');
    Route::post('/get/brands','StockController@getBrands');
    Route::get('/get/products','StockController@getproducts');
    Route::post('/get/customers','StockController@getCustomers');
    Route::post('/get/routes','CustomersController@getRoutes');
    Route::get('/get/customercategories','CustomersController@getCategories');
    Route::post('/send/customer','CustomersController@store');
    Route::post('/send/kibokocustomer','CustomersController@kibokostore');
    Route::post('/send/saved/customer','CustomersController@storesaved');
    Route::post('/save/order','OrderController@store');
    //Route::post('/save/order','OrderController@saveinvoice');
    Route::post('/get/target','AccountController@status');
    Route::post('/get/dealer','AccountController@getdealer');
    Route::post('/request/stock','StockRequestController@store');
    Route::post('saler/reports','StockRequestController@reports');
    Route::post('/save/invoice','OrderController@saveinvoice');
    Route::post('get/receipt/details','OrderController@receiptdetails');
    Route::post('send/return','OrderController@savereturn');
    Route::post('get/sku/target','StockController@getskutarget');
    Route::post('get/sales/van','StockController@getvan');
    Route::post('get/taxpayer','AccountController@gettaxpayer');
    Route::post('get/deliveries','StockRequestController@delivery');
    Route::post('get/efris/status','AccountController@efrisstatus');

});


