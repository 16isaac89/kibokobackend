<?php

return [
    'userManagement' => [
        'title'          => 'ব্যবহারকারী ব্যবস্থাপনা',
        'title_singular' => 'ব্যবহারকারী ব্যবস্থাপনা',
    ],
    'permission' => [
        'title'          => 'অনুমতিসমূহ',
        'title_singular' => 'অনুমতি',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'title'             => 'Title',
            'title_helper'      => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'role' => [
        'title'          => 'ভূমিকা/রোলগুলি',
        'title_singular' => 'ভূমিকা/রোল',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'title'              => 'Title',
            'title_helper'       => ' ',
            'permissions'        => 'Permissions',
            'permissions_helper' => ' ',
            'created_at'         => 'Created at',
            'created_at_helper'  => ' ',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => ' ',
        ],
    ],
    'user' => [
        'title'          => 'ব্যবহারকারীগণ',
        'title_singular' => 'ব্যবহারকারী',
        'fields'         => [
            'id'                           => 'ID',
            'id_helper'                    => ' ',
            'name'                         => 'Name',
            'name_helper'                  => ' ',
            'email'                        => 'Email',
            'email_helper'                 => ' ',
            'email_verified_at'            => 'Email verified at',
            'email_verified_at_helper'     => ' ',
            'password'                     => 'Password',
            'password_helper'              => ' ',
            'roles'                        => 'Roles',
            'roles_helper'                 => ' ',
            'remember_token'               => 'Remember Token',
            'remember_token_helper'        => ' ',
            'created_at'                   => 'Created at',
            'created_at_helper'            => ' ',
            'updated_at'                   => 'Updated at',
            'updated_at_helper'            => ' ',
            'deleted_at'                   => 'Deleted at',
            'deleted_at_helper'            => ' ',
            'two_factor'                   => 'Two-Factor Auth',
            'two_factor_helper'            => ' ',
            'two_factor_code'              => 'Two-factor code',
            'two_factor_code_helper'       => ' ',
            'two_factor_expires_at'        => 'Two-factor expires at',
            'two_factor_expires_at_helper' => ' ',
            'username'                     => 'Username',
            'username_helper'              => ' ',
            'phonenumber'                  => 'Phone number',
            'phonenumber_helper'           => ' ',
            'picture'                      => 'Picture',
            'picture_helper'               => ' ',
        ],
    ],
    'userAlert' => [
        'title'          => 'User Alerts',
        'title_singular' => 'User Alert',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'alert_text'        => 'Alert Text',
            'alert_text_helper' => ' ',
            'alert_link'        => 'Alert Link',
            'alert_link_helper' => ' ',
            'user'              => 'Users',
            'user_helper'       => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
        ],
    ],
    'faqManagement' => [
        'title'          => 'FAQ Management',
        'title_singular' => 'FAQ Management',
    ],
    'faqCategory' => [
        'title'          => 'Categories',
        'title_singular' => 'Category',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'category'          => 'Category',
            'category_helper'   => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated At',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted At',
            'deleted_at_helper' => ' ',
        ],
    ],
    'faqQuestion' => [
        'title'          => 'Questions',
        'title_singular' => 'Question',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'category'          => 'Category',
            'category_helper'   => ' ',
            'question'          => 'Question',
            'question_helper'   => ' ',
            'answer'            => 'Answer',
            'answer_helper'     => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated At',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted At',
            'deleted_at_helper' => ' ',
        ],
    ],
    'extra' => [
        'title'          => 'Extras',
        'title_singular' => 'Extra',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'name'              => 'Name',
            'name_helper'       => 'Name of extra item',
            'price'             => 'Price',
            'price_helper'      => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'otherUserss' => [
        'title'          => 'Set Up',
        'title_singular' => 'Set Up',
    ],
    'ride' => [
        'title'          => 'Ride',
        'title_singular' => 'Ride',
        'fields'         => [
            'id'                  => 'ID',
            'id_helper'           => ' ',
            'name'                => 'Name',
            'name_helper'         => ' ',
            'created_at'          => 'Created at',
            'created_at_helper'   => ' ',
            'updated_at'          => 'Updated at',
            'updated_at_helper'   => ' ',
            'deleted_at'          => 'Deleted at',
            'deleted_at_helper'   => ' ',
            'delivery'            => 'Delivery',
            'delivery_helper'     => ' ',
            'title'               => 'Title',
            'title_helper'        => ' ',
            'tonnage'             => 'Tonnage',
            'tonnage_helper'      => ' ',
            'capacity'            => 'Capacity',
            'capacity_helper'     => ' ',
            'manufacturer'        => 'Manufacturer',
            'manufacturer_helper' => ' ',
            'fare'                => 'Fare',
            'fare_helper'         => ' ',
            'photo'               => 'Photo',
            'photo_helper'        => ' ',
            'photos'              => 'Photos',
            'photos_helper'       => ' ',
            'category'            => 'Category',
            'category_helper'     => ' ',
        ],
    ],
    'zone' => [
        'title'          => 'Zones',
        'title_singular' => 'Zone',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'zone'              => 'Zone',
            'zone_helper'       => 'zone a, zone b etc',
            'distance'          => 'Distance',
            'distance_helper'   => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
            'from'              => 'From',
            'from_helper'       => ' ',
            'to'                => 'To',
            'to_helper'         => ' ',
        ],
    ],
    'setting' => [
        'title'          => 'Setting',
        'title_singular' => 'Setting',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'name'              => 'Name',
            'name_helper'       => ' ',
            'value'             => 'Value',
            'value_helper'      => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'manageBooking' => [
        'title'          => 'Manage Bookings',
        'title_singular' => 'Manage Booking',
    ],
    'booking' => [
        'title'          => 'Booking',
        'title_singular' => 'Booking',
        'fields'         => [
            'id'                   => 'ID',
            'id_helper'            => ' ',
            'fullname'             => 'Full Name',
            'fullname_helper'      => ' ',
            'created_at'           => 'Created at',
            'created_at_helper'    => ' ',
            'updated_at'           => 'Updated at',
            'updated_at_helper'    => ' ',
            'deleted_at'           => 'Deleted at',
            'deleted_at_helper'    => ' ',
            'from'                 => 'From',
            'from_helper'          => ' ',
            'to'                   => 'To',
            'to_helper'            => ' ',
            'stops'                => 'Stops',
            'stops_helper'         => ' ',
            'triptype'             => 'Triptype',
            'triptype_helper'      => ' ',
            'date'                 => 'Date',
            'date_helper'          => ' ',
            'paymentmethod'        => 'Paymentmethod',
            'paymentmethod_helper' => ' ',
            'recommender'          => 'Recommender',
            'recommender_helper'   => ' ',
            'passengers'           => 'Passengers',
            'passengers_helper'    => ' ',
            'days'                 => 'Days',
            'days_helper'          => ' ',
            'customer'             => 'Customer',
            'customer_helper'      => ' ',
            'driver'               => 'Drivers',
            'driver_helper'        => ' ',
            'ride'                 => 'Ride',
            'ride_helper'          => ' ',
            'car_type'             => 'Car Type',
            'car_type_helper'      => ' ',
            'type'                 => 'Type',
            'type_helper'          => ' ',
            'services'             => 'Other Services',
            'services_helper'      => ' ',
        ],
    ],
    'map' => [
        'title'          => 'Map',
        'title_singular' => 'Map',
    ],
    'driver' => [
        'title'          => 'Driver',
        'title_singular' => 'Driver',
        'fields'         => [
            'id'                    => 'ID',
            'id_helper'             => ' ',
            'fullname'              => 'Fullname',
            'fullname_helper'       => ' ',
            'email'                 => 'Email',
            'email_helper'          => ' ',
            'photo'                 => 'Photo',
            'photo_helper'          => ' ',
            'car'                   => 'Car',
            'car_helper'            => ' ',
            'type'                  => 'Type',
            'type_helper'           => ' ',
            'password'              => 'Password',
            'password_helper'       => ' ',
            'permit'                => 'Permit',
            'permit_helper'         => ' ',
            'identification'        => 'Identification',
            'identification_helper' => ' ',
            'created_at'            => 'Created at',
            'created_at_helper'     => ' ',
            'updated_at'            => 'Updated at',
            'updated_at_helper'     => ' ',
            'deleted_at'            => 'Deleted at',
            'deleted_at_helper'     => ' ',
        ],
    ],
    'payment' => [
        'title'          => 'Driver Payments',
        'title_singular' => 'Driver Payment',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'booking'           => 'Booking',
            'booking_helper'    => ' ',
            'driver'            => 'Driver',
            'driver_helper'     => ' ',
            'date'              => 'Date',
            'date_helper'       => ' ',
            'proof'             => 'Proof',
            'proof_helper'      => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'customer' => [
        'title'          => 'Customer',
        'title_singular' => 'Customer',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'image'             => 'Image',
            'image_helper'      => ' ',
            'password'          => 'Password',
            'password_helper'   => ' ',
            'username'          => 'Username',
            'username_helper'   => ' ',
            'email'             => 'Email',
            'email_helper'      => ' ',
            'phone'             => 'Phone',
            'phone_helper'      => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
            'fullname'          => 'Fullname',
            'fullname_helper'   => ' ',
            'address'           => 'Address',
            'address_helper'    => ' ',
        ],
    ],
    'auditLog' => [
        'title'          => 'Audit Logs',
        'title_singular' => 'Audit Log',
        'fields'         => [
            'id'                  => 'ID',
            'id_helper'           => ' ',
            'description'         => 'Description',
            'description_helper'  => ' ',
            'subject_id'          => 'Subject ID',
            'subject_id_helper'   => ' ',
            'subject_type'        => 'Subject Type',
            'subject_type_helper' => ' ',
            'user_id'             => 'User ID',
            'user_id_helper'      => ' ',
            'properties'          => 'Properties',
            'properties_helper'   => ' ',
            'host'                => 'Host',
            'host_helper'         => ' ',
            'created_at'          => 'Created at',
            'created_at_helper'   => ' ',
            'updated_at'          => 'Updated at',
            'updated_at_helper'   => ' ',
        ],
    ],
    'taskManagement' => [
        'title'          => 'Task management',
        'title_singular' => 'Task management',
    ],
    'taskStatus' => [
        'title'          => 'Statuses',
        'title_singular' => 'Status',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'name'              => 'Name',
            'name_helper'       => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated At',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted At',
            'deleted_at_helper' => ' ',
        ],
    ],
    'taskTag' => [
        'title'          => 'Tags',
        'title_singular' => 'Tag',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'name'              => 'Name',
            'name_helper'       => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated At',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted At',
            'deleted_at_helper' => ' ',
        ],
    ],
    'task' => [
        'title'          => 'Tasks',
        'title_singular' => 'Task',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'name'               => 'Name',
            'name_helper'        => ' ',
            'description'        => 'Description',
            'description_helper' => ' ',
            'status'             => 'Status',
            'status_helper'      => ' ',
            'tag'                => 'Tags',
            'tag_helper'         => ' ',
            'attachment'         => 'Attachment',
            'attachment_helper'  => ' ',
            'due_date'           => 'Due date',
            'due_date_helper'    => ' ',
            'assigned_to'        => 'Assigned to',
            'assigned_to_helper' => ' ',
            'created_at'         => 'Created at',
            'created_at_helper'  => ' ',
            'updated_at'         => 'Updated At',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'Deleted At',
            'deleted_at_helper'  => ' ',
        ],
    ],
    'tasksCalendar' => [
        'title'          => 'Calendar',
        'title_singular' => 'Calendar',
    ],
    'paymentMethod' => [
        'title'          => 'Payment Method',
        'title_singular' => 'Payment Method',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'name'              => 'Name',
            'name_helper'       => ' ',
            'status'            => 'Status',
            'status_helper'     => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
            'logo'              => 'Logo',
            'logo_helper'       => ' ',
        ],
    ],
    'pushNotification' => [
        'title'          => 'Push Notification',
        'title_singular' => 'Push Notification',
    ],
    'expenseManagement' => [
        'title'          => 'ব্যয় ব্যবস্থাপনা',
        'title_singular' => 'ব্যয় ব্যবস্থাপনা',
    ],
    'expenseCategory' => [
        'title'          => 'ব্যয় বিভাগ',
        'title_singular' => 'ব্যয় বিভাগ',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'name'              => 'Name',
            'name_helper'       => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated At',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted At',
            'deleted_at_helper' => ' ',
        ],
    ],
    'incomeCategory' => [
        'title'          => 'আয়ের বিভাগসমূহ',
        'title_singular' => 'আয়ের বিভাগ',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'name'              => 'Name',
            'name_helper'       => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated At',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted At',
            'deleted_at_helper' => ' ',
        ],
    ],
    'expense' => [
        'title'          => 'খরচ',
        'title_singular' => 'ব্যয়',
        'fields'         => [
            'id'                      => 'ID',
            'id_helper'               => ' ',
            'expense_category'        => 'Expense Category',
            'expense_category_helper' => ' ',
            'entry_date'              => 'Entry Date',
            'entry_date_helper'       => ' ',
            'amount'                  => 'Amount',
            'amount_helper'           => ' ',
            'description'             => 'Description',
            'description_helper'      => ' ',
            'created_at'              => 'Created at',
            'created_at_helper'       => ' ',
            'updated_at'              => 'Updated At',
            'updated_at_helper'       => ' ',
            'deleted_at'              => 'Deleted At',
            'deleted_at_helper'       => ' ',
        ],
    ],
    'income' => [
        'title'          => 'আয়',
        'title_singular' => 'আয়',
        'fields'         => [
            'id'                     => 'ID',
            'id_helper'              => ' ',
            'income_category'        => 'Income Category',
            'income_category_helper' => ' ',
            'entry_date'             => 'Entry Date',
            'entry_date_helper'      => ' ',
            'amount'                 => 'Amount',
            'amount_helper'          => ' ',
            'description'            => 'Description',
            'description_helper'     => ' ',
            'created_at'             => 'Created at',
            'created_at_helper'      => ' ',
            'updated_at'             => 'Updated At',
            'updated_at_helper'      => ' ',
            'deleted_at'             => 'Deleted At',
            'deleted_at_helper'      => ' ',
            'source'                 => 'Source',
            'source_helper'          => ' ',
        ],
    ],
    'expenseReport' => [
        'title'          => 'মাসিক প্রতিবেদন',
        'title_singular' => 'মাসিক প্রতিবেদন',
        'reports'        => [
            'title'             => 'প্রতিবেদন',
            'title_singular'    => 'প্রতিবেদন',
            'incomeReport'      => 'আয় রিপোর্ট',
            'incomeByCategory'  => 'বিভাগ অনুসারে আয়',
            'expenseByCategory' => 'বিভাগ অনুসারে ব্যয়',
            'income'            => 'আয়',
            'expense'           => 'ব্যয়',
            'profit'            => 'মুনাফা',
        ],
    ],
    'zoneRide' => [
        'title'          => 'Zone Ride',
        'title_singular' => 'Zone Ride',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'zone'              => 'Zone',
            'zone_helper'       => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'rideCategory' => [
        'title'          => 'Ride Category',
        'title_singular' => 'Ride Category',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'name'              => 'Name',
            'name_helper'       => ' ',
            'passengers'        => 'Passengers',
            'passengers_helper' => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
            'photo'             => 'Photo',
            'photo_helper'      => ' ',
        ],
    ],
    'customerPayment' => [
        'title'          => 'Customer Payments',
        'title_singular' => 'Customer Payment',
        'fields'         => [
            'id'                   => 'ID',
            'id_helper'            => ' ',
            'date'                 => 'Date',
            'date_helper'          => ' ',
            'booking'              => 'Booking',
            'booking_helper'       => ' ',
            'customer'             => 'Customer',
            'customer_helper'      => ' ',
            'amount'               => 'Amount',
            'amount_helper'        => ' ',
            'proof'                => 'Proof',
            'proof_helper'         => ' ',
            'created_at'           => 'Created at',
            'created_at_helper'    => ' ',
            'updated_at'           => 'Updated at',
            'updated_at_helper'    => ' ',
            'deleted_at'           => 'Deleted at',
            'deleted_at_helper'    => ' ',
            'received_by'          => 'Received By',
            'received_by_helper'   => ' ',
            'paymentmethod'        => 'Paymentmethod',
            'paymentmethod_helper' => ' ',
            'account'              => 'Account',
            'account_helper'       => ' ',
        ],
    ],
    'customerWallet' => [
        'title'          => 'Customer Wallet',
        'title_singular' => 'Customer Wallet',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'customer'          => 'Customer',
            'customer_helper'   => ' ',
            'date'              => 'Date',
            'date_helper'       => ' ',
            'amount'            => 'Amount',
            'amount_helper'     => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'account' => [
        'title'          => 'Accounts',
        'title_singular' => 'Account',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'name'               => 'Name',
            'name_helper'        => ' ',
            'value'              => 'Value',
            'value_helper'       => ' ',
            'description'        => 'Description',
            'description_helper' => ' ',
            'created_at'         => 'Created at',
            'created_at_helper'  => ' ',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => ' ',
        ],
    ],
    'driverWallet' => [
        'title'          => 'Driver Wallet',
        'title_singular' => 'Driver Wallet',
        'fields'         => [
            'id'                   => 'ID',
            'id_helper'            => ' ',
            'amount'               => 'Amount',
            'amount_helper'        => ' ',
            'paymentmethod'        => 'Paymentmethod',
            'paymentmethod_helper' => ' ',
            'date'                 => 'Date',
            'date_helper'          => ' ',
            'driver'               => 'Driver',
            'driver_helper'        => ' ',
            'created_at'           => 'Created at',
            'created_at_helper'    => ' ',
            'updated_at'           => 'Updated at',
            'updated_at_helper'    => ' ',
            'deleted_at'           => 'Deleted at',
            'deleted_at_helper'    => ' ',
        ],
    ],
    'transaction' => [
        'title'          => 'Transaction',
        'title_singular' => 'Transaction',
        'fields'         => [
            'id'                   => 'ID',
            'id_helper'            => ' ',
            'amount'               => 'Amount',
            'amount_helper'        => ' ',
            'model'                => 'Model',
            'model_helper'         => ' ',
            'txid'                 => 'Transaction ID',
            'txid_helper'          => ' ',
            'paymentmethod'        => 'Paymentmethod',
            'paymentmethod_helper' => ' ',
            'status'               => 'Status',
            'status_helper'        => ' ',
            'created_at'           => 'Created at',
            'created_at_helper'    => ' ',
            'updated_at'           => 'Updated at',
            'updated_at_helper'    => ' ',
            'deleted_at'           => 'Deleted at',
            'deleted_at_helper'    => ' ',
        ],
    ],
    'invoice' => [
        'title'          => 'Invoice',
        'title_singular' => 'Invoice',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'type'              => 'Type',
            'type_helper'       => ' ',
            'customer'          => 'Customer',
            'customer_helper'   => ' ',
            'date'              => 'Date',
            'date_helper'       => ' ',
            'amount'            => 'Amount',
            'amount_helper'     => ' ',
            'booking'           => 'Booking',
            'booking_helper'    => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'service' => [
        'title'          => 'Services',
        'title_singular' => 'Service',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'name'               => 'Name',
            'name_helper'        => ' ',
            'value'              => 'Value',
            'value_helper'       => ' ',
            'description'        => 'Description',
            'description_helper' => ' ',
            'image'              => 'Image',
            'image_helper'       => ' ',
            'created_at'         => 'Created at',
            'created_at_helper'  => ' ',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => ' ',
        ],
    ],
];
