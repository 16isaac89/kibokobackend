<?php

namespace App\Observers;

use App\Models\CustomerPayment;
use App\Notifications\DataChangeEmailNotification;
use Illuminate\Support\Facades\Notification;

class CustomerPaymentActionObserver
{
    public function created(CustomerPayment $model)
    {
        $data  = ['action' => 'created', 'model_name' => 'CustomerPayment'];
        $users = \App\Models\User::whereHas('roles', function ($q) { return $q->where('title', 'Admin'); })->get();
        Notification::send($users, new DataChangeEmailNotification($data));
    }

    public function updated(CustomerPayment $model)
    {
        $data  = ['action' => 'updated', 'model_name' => 'CustomerPayment'];
        $users = \App\Models\User::whereHas('roles', function ($q) { return $q->where('title', 'Admin'); })->get();
        Notification::send($users, new DataChangeEmailNotification($data));
    }

    public function deleting(CustomerPayment $model)
    {
        $data  = ['action' => 'deleted', 'model_name' => 'CustomerPayment'];
        $users = \App\Models\User::whereHas('roles', function ($q) { return $q->where('title', 'Admin'); })->get();
        Notification::send($users, new DataChangeEmailNotification($data));
    }
}
