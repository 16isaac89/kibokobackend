<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helper\MediaClass;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Models\Branch;
use App\Models\CaptainPerfomance;
use App\Models\Dealer;
use App\Models\DealerRole;
use App\Models\DealerUser;
use App\Models\ProductDivision;
use App\Models\Setting;
use App\Models\StockRequest;
use App\Models\Subscription;
use App\Models\Target;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DealersController extends Controller
{
    use CsvImportTrait;
    public function index()
    {
        $designation = \Auth::user()->designation;
        $dealers     = [];

        if ($designation == 2) {
            $dealers_ids = \Auth::user()->dealers->pluck('id');

            $dealers = Dealer::whereIn('id', $dealers_ids)->get();
        } else {
            $dealers = Dealer::with('productDivisions')->get();
        }
        $divisions = ProductDivision::all();
        $users     = User::where('designation', 2)->get();
        return view('admin.dealers.index', compact('dealers', 'users', 'divisions'));
    }
    public function store()
    {
        $media = new MediaClass();
        $path  = 'uploads/dealers/keys/';
        if (request()->privatekey) {
            $file     = request()->privatekey;
            $filepath = $media->uploads($file, $path);
        }

        $privatekeypath = isset($request->privatekey) && ! empty($request->privatekey) ? \URL::to('/') . "/amari/storage/app/public/" . $filepath['filePath'] : "";

        $dealer = Dealer::create([
            'tradename'     => request()->name,
            'name'          => request()->name,
            'tin'           => request()->tin,
            'address'       => request()->address,
            'phonenumber'   => request()->phonenumber,
            'status'        => request()->status,
            'efris'         => request()->efris,
            'deviceno'      => request()->deviceno,
            'privatekey'    => $privatekeypath,
            'keypwd'        => request()->keypwd,
            'email'         => request()->email,
            'code'          => request()->code,
            'supervisor_id' => request()->supervisor,
        ]);
        $dealer->productDivisions()->sync(request()->product_divisions);
// Branch::create([
//     'name'=>request()->branch,
//     'address'=>request()->address,
//     'phone'=>request()->phonenumber,
//     'dealer_id'=>$dealer->id,
// ]);
        return back();
    }
    public function editDealer(Dealer $dealer)
    {
        //     dd($dealer);
        //    $dealer  = Dealer::find(request()->dealerid);
        $dealer->update([
            'tradename'     => request()->dealername,
            'tin'           => request()->dealertin,
            'address'       => request()->dealeraddress,
            'phonenumber'   => request()->dealerphonenumber,
            'status'        => request()->dealerstatus,
            'efris'         => request()->dealerefris,
            'supervisor_id' => request()->supervisor,
            //'type_of_business'=>request()->business_type,
        ]);
        $dealer->productDivisions()->sync(request()->product_divisions);
        return redirect()->back()->with('message', 'Dealer has been updated successfully!');
    }
    public function edit(Dealer $dealer)
    {
        $dealer->load('productDivisions');
        $designation = \Auth::user()->designation;
        $dealers     = [];

        if ($designation == 2) {
            $dealers_ids = \Auth::user()->dealers->pluck('id');

            $dealers = Dealer::whereIn('id', $dealers_ids)->get();
        } else {
            $dealers = Dealer::with('productDivisions')->get();
        }
        $divisions = ProductDivision::all();
        $users     = User::where('designation', 2)->get();

        return view('admin.dealers.edit', compact('dealer', 'users', 'divisions'));
    }

    public function savedealeradmin()
    {

        $roles  = DealerRole::where('title', 'admin')->pluck('id');
        $branch = Branch::where('dealer_id', request()->iddealer)->first();
        $user   = DealerUser::create([
            'dealer_id' => request()->iddealer,
            'type'      => "admin",
            'username'  => request()->username,
            'phone'     => request()->phone,
            'password'  => bcrypt(request()->password),
            'status'    => request()->userstatus,
        ]);
        $user->dealerroles()->sync($roles);
        $user->productDivisions()->attach(request()->product_divisions);
        return redirect()->back()->with('message', 'User has been created successfully!');
    }
    public function updatedealeradmin(DealerUser $user)
    {
        $user->update([
            'username' => request()->username,
            'phone'    => request()->phone,
            'status'   => request()->userstatus,
        ]);

        $user->productDivisions()->sync(request()->product_divisions);
        return redirect()->back()->with('message', 'User has been updated successfully!');
    }
    public function upatedealeradminview(DealerUser $user)
    {
        // dd($user);
        $divisions = ProductDivision::all();
        $user->load('productDivisions');
        $assigned_divisions = $user->productDivisions->pluck('id')->toArray();
        return view('admin.dealers.editadmin', compact('user', 'divisions', 'assigned_divisions'));
    }

    public function dealerTarget()
    {
        $data = \DB::table('targets')->where('dealer_id', request()->targetdealer)->whereRaw('extract(month from month) = ?', [Carbon::now()->format('m')])->get();
        if (count($data) > 0) {
            return \Redirect::back()->withErrors(['msg' => 'You have already set a target for this dealer this month']);
        } else {
            Target::create([
                'month'     => request()->date,
                'money'     => request()->money,
                'dealer_id' => request()->targetdealer,
                'type'      => 'dealer',
            ]);
            return back();
        }

    }

    public function show(Dealer $dealer)
    {
        // $subscriptions = $dealer->dealersubs;
        // $lates =  = $dealer->dealersubslat;

//         $dealer->load('dealerclients','users','routes');
// dd($dealer);
        $dealer->load(['dealerclients' => function ($query) {
            $query->with('route');
        }, 'routes' => function ($query) {
            $query->with('customers');
        }, 'users']);
//dd($dealer->dealerclients[0]);
        $salesToday = StockRequest::with('items.product','requestcustomer','customerroute')->where('dealer_id', $dealer->id)
            ->whereDate('created_at', Carbon::today())->get();
        $customersToday = $dealer->dealerclients()
    ->whereDate('updated_at', Carbon::today())
    ->with('route') // If you need route information
    ->get();
        return view('admin.dealers.show', compact('dealer','salesToday','customersToday'));

    }
    public function addsub(Dealer $dealer)
    {
        // $subscriptions = $dealer->dealersubs;
        // $lates =  = $dealer->dealersubslat;
        $subscriptions = Subscription::all();

        return view('admin.dealers.addsub', compact('dealer', 'subscriptions'));

    }
    public function subprice(Request $request)
    {
        $sub = Subscription::find(intval($request->sub));
        //return response()->json(['price'=>$sub,'s'=>$request->sub,'x'=>$request->input()]);
        $price = 0;
        if ($sub->type === 'month') {
            $price = Setting::where('setting', 'per_user_value')->get()->first()->value;
            return response()->json(['price' => $price]);
        } else if ($sub->type === 'year') {
            $price = Setting::where('setting', 'per_year_sub')->get()->first()->value;
            return response()->json(['price' => $price]);
        }

    }

    public function captainperfomance(Request $request)
    {
        // Initialize date range variables
        $startDate = $request->input('start_date');
        $endDate   = $request->input('end_date');

        // Query for performance data with a date range filter
        $performances = CaptainPerfomance::query()
            ->when($startDate, function ($query, $startDate) {
                return $query->whereDate('created_at', '>=', Carbon::parse($startDate)->startOfDay());
            })
            ->when($endDate, function ($query, $endDate) {
                return $query->whereDate('created_at', '<=', Carbon::parse($endDate)->endOfDay());
            })
            ->with('dealer')->get();

        return view('admin.dealers.perfomance', compact('performances'));
    }

}
