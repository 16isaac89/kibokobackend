<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ContactUsController extends Controller
{
    public function index(Request $request)
    {
        $messages = ContactUs::all();
        return view('admin.contactus.index',[
            'messages'=>$messages,
        ]);
    }
    public function handle(ContactUs $message)
    {
       $message->delete();
       return redirect()->back()->with('success','Viewed');
    }
}
