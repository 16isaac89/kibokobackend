<?php

namespace App\Observers;

use App\Models\Booking;
use App\Notifications\DataChangeEmailNotification;
use Illuminate\Support\Facades\Notification;

class BookingActionObserver
{
    public function created(Booking $model)
    {
        $data  = ['action' => 'created', 'model_name' => 'Booking'];
        $users = \App\Models\User::whereHas('roles', function ($q) { return $q->where('title', 'Admin'); })->get();
        Notification::send($users, new DataChangeEmailNotification($data));
    }

    public function updated(Booking $model)
    {
        $data  = ['action' => 'updated', 'model_name' => 'Booking'];
        $users = \App\Models\User::whereHas('roles', function ($q) { return $q->where('title', 'Admin'); })->get();
        Notification::send($users, new DataChangeEmailNotification($data));
    }

    public function deleting(Booking $model)
    {
        $data  = ['action' => 'deleted', 'model_name' => 'Booking'];
        $users = \App\Models\User::whereHas('roles', function ($q) { return $q->where('title', 'Admin'); })->get();
        Notification::send($users, new DataChangeEmailNotification($data));
    }
}
