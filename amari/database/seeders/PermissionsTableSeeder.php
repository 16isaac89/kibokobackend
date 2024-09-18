<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'user_alert_create',
            ],
            [
                'id'    => 18,
                'title' => 'user_alert_show',
            ],
            [
                'id'    => 19,
                'title' => 'user_alert_delete',
            ],
            [
                'id'    => 20,
                'title' => 'user_alert_access',
            ],
            [
                'id'    => 21,
                'title' => 'faq_management_access',
            ],
            [
                'id'    => 22,
                'title' => 'faq_category_create',
            ],
            [
                'id'    => 23,
                'title' => 'faq_category_edit',
            ],
            [
                'id'    => 24,
                'title' => 'faq_category_show',
            ],
            [
                'id'    => 25,
                'title' => 'faq_category_delete',
            ],
            [
                'id'    => 26,
                'title' => 'faq_category_access',
            ],
            [
                'id'    => 27,
                'title' => 'faq_question_create',
            ],
            [
                'id'    => 28,
                'title' => 'faq_question_edit',
            ],
            [
                'id'    => 29,
                'title' => 'faq_question_show',
            ],
            [
                'id'    => 30,
                'title' => 'faq_question_delete',
            ],
            [
                'id'    => 31,
                'title' => 'faq_question_access',
            ],
            [
                'id'    => 32,
                'title' => 'extra_create',
            ],
            [
                'id'    => 33,
                'title' => 'extra_edit',
            ],
            [
                'id'    => 34,
                'title' => 'extra_show',
            ],
            [
                'id'    => 35,
                'title' => 'extra_delete',
            ],
            [
                'id'    => 36,
                'title' => 'extra_access',
            ],
            [
                'id'    => 37,
                'title' => 'other_userss_access',
            ],
            [
                'id'    => 38,
                'title' => 'ride_create',
            ],
            [
                'id'    => 39,
                'title' => 'ride_edit',
            ],
            [
                'id'    => 40,
                'title' => 'ride_show',
            ],
            [
                'id'    => 41,
                'title' => 'ride_delete',
            ],
            [
                'id'    => 42,
                'title' => 'ride_access',
            ],
            [
                'id'    => 43,
                'title' => 'zone_create',
            ],
            [
                'id'    => 44,
                'title' => 'zone_edit',
            ],
            [
                'id'    => 45,
                'title' => 'zone_show',
            ],
            [
                'id'    => 46,
                'title' => 'zone_delete',
            ],
            [
                'id'    => 47,
                'title' => 'zone_access',
            ],
            [
                'id'    => 48,
                'title' => 'setting_create',
            ],
            [
                'id'    => 49,
                'title' => 'setting_edit',
            ],
            [
                'id'    => 50,
                'title' => 'setting_show',
            ],
            [
                'id'    => 51,
                'title' => 'setting_delete',
            ],
            [
                'id'    => 52,
                'title' => 'setting_access',
            ],
            [
                'id'    => 53,
                'title' => 'manage_booking_access',
            ],
            [
                'id'    => 54,
                'title' => 'booking_create',
            ],
            [
                'id'    => 55,
                'title' => 'booking_edit',
            ],
            [
                'id'    => 56,
                'title' => 'booking_show',
            ],
            [
                'id'    => 57,
                'title' => 'booking_delete',
            ],
            [
                'id'    => 58,
                'title' => 'booking_access',
            ],
            [
                'id'    => 59,
                'title' => 'map_create',
            ],
            [
                'id'    => 60,
                'title' => 'map_edit',
            ],
            [
                'id'    => 61,
                'title' => 'map_show',
            ],
            [
                'id'    => 62,
                'title' => 'map_delete',
            ],
            [
                'id'    => 63,
                'title' => 'map_access',
            ],
            [
                'id'    => 64,
                'title' => 'driver_create',
            ],
            [
                'id'    => 65,
                'title' => 'driver_edit',
            ],
            [
                'id'    => 66,
                'title' => 'driver_show',
            ],
            [
                'id'    => 67,
                'title' => 'driver_delete',
            ],
            [
                'id'    => 68,
                'title' => 'driver_access',
            ],
            [
                'id'    => 69,
                'title' => 'payment_create',
            ],
            [
                'id'    => 70,
                'title' => 'payment_edit',
            ],
            [
                'id'    => 71,
                'title' => 'payment_show',
            ],
            [
                'id'    => 72,
                'title' => 'payment_delete',
            ],
            [
                'id'    => 73,
                'title' => 'payment_access',
            ],
            [
                'id'    => 74,
                'title' => 'customer_create',
            ],
            [
                'id'    => 75,
                'title' => 'customer_edit',
            ],
            [
                'id'    => 76,
                'title' => 'customer_show',
            ],
            [
                'id'    => 77,
                'title' => 'customer_delete',
            ],
            [
                'id'    => 78,
                'title' => 'customer_access',
            ],
            [
                'id'    => 79,
                'title' => 'audit_log_show',
            ],
            [
                'id'    => 80,
                'title' => 'audit_log_access',
            ],
            [
                'id'    => 81,
                'title' => 'task_management_access',
            ],
            [
                'id'    => 82,
                'title' => 'task_status_create',
            ],
            [
                'id'    => 83,
                'title' => 'task_status_edit',
            ],
            [
                'id'    => 84,
                'title' => 'task_status_show',
            ],
            [
                'id'    => 85,
                'title' => 'task_status_delete',
            ],
            [
                'id'    => 86,
                'title' => 'task_status_access',
            ],
            [
                'id'    => 87,
                'title' => 'task_tag_create',
            ],
            [
                'id'    => 88,
                'title' => 'task_tag_edit',
            ],
            [
                'id'    => 89,
                'title' => 'task_tag_show',
            ],
            [
                'id'    => 90,
                'title' => 'task_tag_delete',
            ],
            [
                'id'    => 91,
                'title' => 'task_tag_access',
            ],
            [
                'id'    => 92,
                'title' => 'task_create',
            ],
            [
                'id'    => 93,
                'title' => 'task_edit',
            ],
            [
                'id'    => 94,
                'title' => 'task_show',
            ],
            [
                'id'    => 95,
                'title' => 'task_delete',
            ],
            [
                'id'    => 96,
                'title' => 'task_access',
            ],
            [
                'id'    => 97,
                'title' => 'tasks_calendar_access',
            ],
            [
                'id'    => 98,
                'title' => 'payment_method_create',
            ],
            [
                'id'    => 99,
                'title' => 'payment_method_edit',
            ],
            [
                'id'    => 100,
                'title' => 'payment_method_show',
            ],
            [
                'id'    => 101,
                'title' => 'payment_method_delete',
            ],
            [
                'id'    => 102,
                'title' => 'payment_method_access',
            ],
            [
                'id'    => 103,
                'title' => 'push_notification_create',
            ],
            [
                'id'    => 104,
                'title' => 'push_notification_edit',
            ],
            [
                'id'    => 105,
                'title' => 'push_notification_show',
            ],
            [
                'id'    => 106,
                'title' => 'push_notification_delete',
            ],
            [
                'id'    => 107,
                'title' => 'push_notification_access',
            ],
            [
                'id'    => 108,
                'title' => 'expense_management_access',
            ],
            [
                'id'    => 109,
                'title' => 'expense_category_create',
            ],
            [
                'id'    => 110,
                'title' => 'expense_category_edit',
            ],
            [
                'id'    => 111,
                'title' => 'expense_category_show',
            ],
            [
                'id'    => 112,
                'title' => 'expense_category_delete',
            ],
            [
                'id'    => 113,
                'title' => 'expense_category_access',
            ],
            [
                'id'    => 114,
                'title' => 'income_category_create',
            ],
            [
                'id'    => 115,
                'title' => 'income_category_edit',
            ],
            [
                'id'    => 116,
                'title' => 'income_category_show',
            ],
            [
                'id'    => 117,
                'title' => 'income_category_delete',
            ],
            [
                'id'    => 118,
                'title' => 'income_category_access',
            ],
            [
                'id'    => 119,
                'title' => 'expense_create',
            ],
            [
                'id'    => 120,
                'title' => 'expense_edit',
            ],
            [
                'id'    => 121,
                'title' => 'expense_show',
            ],
            [
                'id'    => 122,
                'title' => 'expense_delete',
            ],
            [
                'id'    => 123,
                'title' => 'expense_access',
            ],
            [
                'id'    => 124,
                'title' => 'income_create',
            ],
            [
                'id'    => 125,
                'title' => 'income_edit',
            ],
            [
                'id'    => 126,
                'title' => 'income_show',
            ],
            [
                'id'    => 127,
                'title' => 'income_delete',
            ],
            [
                'id'    => 128,
                'title' => 'income_access',
            ],
            [
                'id'    => 129,
                'title' => 'expense_report_create',
            ],
            [
                'id'    => 130,
                'title' => 'expense_report_edit',
            ],
            [
                'id'    => 131,
                'title' => 'expense_report_show',
            ],
            [
                'id'    => 132,
                'title' => 'expense_report_delete',
            ],
            [
                'id'    => 133,
                'title' => 'expense_report_access',
            ],
            [
                'id'    => 134,
                'title' => 'zone_ride_create',
            ],
            [
                'id'    => 135,
                'title' => 'zone_ride_edit',
            ],
            [
                'id'    => 136,
                'title' => 'zone_ride_show',
            ],
            [
                'id'    => 137,
                'title' => 'zone_ride_delete',
            ],
            [
                'id'    => 138,
                'title' => 'zone_ride_access',
            ],
            [
                'id'    => 139,
                'title' => 'ride_category_create',
            ],
            [
                'id'    => 140,
                'title' => 'ride_category_edit',
            ],
            [
                'id'    => 141,
                'title' => 'ride_category_show',
            ],
            [
                'id'    => 142,
                'title' => 'ride_category_delete',
            ],
            [
                'id'    => 143,
                'title' => 'ride_category_access',
            ],
            [
                'id'    => 144,
                'title' => 'customer_payment_create',
            ],
            [
                'id'    => 145,
                'title' => 'customer_payment_edit',
            ],
            [
                'id'    => 146,
                'title' => 'customer_payment_show',
            ],
            [
                'id'    => 147,
                'title' => 'customer_payment_delete',
            ],
            [
                'id'    => 148,
                'title' => 'customer_payment_access',
            ],
            [
                'id'    => 149,
                'title' => 'customer_wallet_create',
            ],
            [
                'id'    => 150,
                'title' => 'customer_wallet_edit',
            ],
            [
                'id'    => 151,
                'title' => 'customer_wallet_show',
            ],
            [
                'id'    => 152,
                'title' => 'customer_wallet_delete',
            ],
            [
                'id'    => 153,
                'title' => 'customer_wallet_access',
            ],
            [
                'id'    => 154,
                'title' => 'account_create',
            ],
            [
                'id'    => 155,
                'title' => 'account_edit',
            ],
            [
                'id'    => 156,
                'title' => 'account_show',
            ],
            [
                'id'    => 157,
                'title' => 'account_delete',
            ],
            [
                'id'    => 158,
                'title' => 'account_access',
            ],
            [
                'id'    => 159,
                'title' => 'driver_wallet_create',
            ],
            [
                'id'    => 160,
                'title' => 'driver_wallet_edit',
            ],
            [
                'id'    => 161,
                'title' => 'driver_wallet_show',
            ],
            [
                'id'    => 162,
                'title' => 'driver_wallet_delete',
            ],
            [
                'id'    => 163,
                'title' => 'driver_wallet_access',
            ],
            [
                'id'    => 164,
                'title' => 'transaction_create',
            ],
            [
                'id'    => 165,
                'title' => 'transaction_edit',
            ],
            [
                'id'    => 166,
                'title' => 'transaction_show',
            ],
            [
                'id'    => 167,
                'title' => 'transaction_delete',
            ],
            [
                'id'    => 168,
                'title' => 'transaction_access',
            ],
            [
                'id'    => 169,
                'title' => 'invoice_create',
            ],
            [
                'id'    => 170,
                'title' => 'invoice_edit',
            ],
            [
                'id'    => 171,
                'title' => 'invoice_show',
            ],
            [
                'id'    => 172,
                'title' => 'invoice_delete',
            ],
            [
                'id'    => 173,
                'title' => 'invoice_access',
            ],
            [
                'id'    => 174,
                'title' => 'service_create',
            ],
            [
                'id'    => 175,
                'title' => 'service_edit',
            ],
            [
                'id'    => 176,
                'title' => 'service_show',
            ],
            [
                'id'    => 177,
                'title' => 'service_delete',
            ],
            [
                'id'    => 178,
                'title' => 'service_access',
            ],
            [
                'id'    => 179,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
