<?php

namespace App\Observers;

use App\Models\Payment;
use App\Notifications\DataChangeEmailNotification;
use Illuminate\Support\Facades\Notification;

class PaymentActionObserver
{
    public function created(Payment $model)
    {
        $data  = ['action' => 'created', 'model_name' => 'Payment'];
        $users = \App\Models\User::whereHas('roles', function ($q) { return $q->where('title', 'Admin'); })->get();
        Notification::send($users, new DataChangeEmailNotification($data));
    }

    public function updated(Payment $model)
    {
        $data  = ['action' => 'updated', 'model_name' => 'Payment'];
        $users = \App\Models\User::whereHas('roles', function ($q) { return $q->where('title', 'Admin'); })->get();
        Notification::send($users, new DataChangeEmailNotification($data));
    }

    public function deleting(Payment $model)
    {
        $data  = ['action' => 'deleted', 'model_name' => 'Payment'];
        $users = \App\Models\User::whereHas('roles', function ($q) { return $q->where('title', 'Admin'); })->get();
        Notification::send($users, new DataChangeEmailNotification($data));
    }
}
