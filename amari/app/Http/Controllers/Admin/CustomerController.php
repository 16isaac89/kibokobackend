<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CustomersExport;
use App\Exports\CustomersExportInactive;
use App\Exports\ExportGeotaggedCustomers;
use App\Exports\ExportGeotaggedCustomersInactive;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCustomerRequest;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use App\Models\Dealer;
use App\Models\Route;
use Gate;
use Hash;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class CustomerController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('customer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // Using paginate to load data in chunks instead of all at once
    $customers = Customer::with(['media', 'route', 'dealer'])->paginate(1000);
    // $customer = Customer::find(211);
    // $url = $customer->location_image->getUrl();
    // $needle = '/uploads/';
    // $insert = '/amari/public';

    // // Find the position of 'uploads' in the URL
    // $pos = strpos($url, $needle);

    // // If 'uploads' is found, insert 'amari/public' before it
    // if ($pos !== false) {
    //     return substr_replace($url, $insert . '/', $pos, 0);
    // }

    // dd($url);

    return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        abort_if(Gate::denies('customer_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $dealers = Dealer::all();
        return view('admin.customers.create', compact('dealers'));
    }

    public function store(Request $request)
    {

//dd($request->all());
        $customer = Customer::create([
            "phone" => $request->phone,
             "email" => $request->email,
             "address" => $request->address,
        'contact_person'=>$request->contactperson,
        'telno'=>$request->telephoneno,
        'area'=>$request->area,
        'city'=>$request->city,
        'country'=>$request->country,
        'classification'=>$request->classification,
        'registers'=>$request->cashregisters,
        'footfall'=>$request->footfall,
        'product_range'=>$request->productrange,
		'custcategory'=>$request->custcategory,
        'dealer_id'=>$request->dealer,
        ]);
        return redirect()->back()->with('message', 'Customer created successfully.');
    }

    public function edit(Customer $customer)
    {
        abort_if(Gate::denies('customer_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $dealers = Dealer::all();
       // dd($customer);
        return view('admin.customers.edit', compact('customer','dealers'));
    }

    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer ->update([
            "phone" => $request->phone,
             "email" => $request->email,
             "address" => $request->address,
        'contact_person'=>$request->contactperson,
        'telno'=>$request->telephoneno,
        'area'=>$request->area,
        'city'=>$request->city,
        'country'=>$request->country,
        'classification'=>$request->classification,
        'registers'=>$request->cashregisters,
        'footfall'=>$request->footfall,
        'product_range'=>$request->productrange,
		'custcategory'=>$request->custcategory,
        'dealer_id'=>$request->dealer,
        ]);
        return redirect()->back()->with('message', 'Customer updated successfully.');


    }

    public function show(Customer $customer)
    {
        abort_if(Gate::denies('customer_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customer->load('customerBookings', 'customerCustomerPayments', 'customerCustomerWallets', 'customerInvoices');

        return view('admin.customers.show', compact('customer'));
    }

    public function destroy(Customer $customer)
    {
        abort_if(Gate::denies('customer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customer->delete();

        return back();
    }

    public function massDestroy(MassDestroyCustomerRequest $request)
    {
        Customer::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('customer_create') && Gate::denies('customer_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Customer();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    public function saveCustomer(Request $request){
        Customer::create($request->all());
        $customer = Customer::get();
        return response()->json(['customer'=>$customer]);
    }

    public function getRoutes(Request $request)
{
    $dealerId = $request->input('dealer_id');
    // Assuming you have a Route model and a relationship defined
    $routes = Route::where('dealer_id', $dealerId)->get();

    return response()->json($routes);
}

public function exportExcel()
    {

        return Excel::download(new CustomersExport, 'customers.xlsx'); // For Excel
    }
    public function exportExcelInactive()
    {

        return Excel::download(new CustomersExportInactive, 'customersinactive.xlsx'); // For Excel
    }

    public function exportCsv()
    {

        return Excel::download(new CustomersExport, 'customers.csv'); // For CSV
    }


    public function exportGeoExcel()
    {

        return Excel::download(new ExportGeotaggedCustomers, 'customers.xlsx'); // For Excel
    }
    public function exportGeoExcelInactive()
    {

        return Excel::download(new ExportGeotaggedCustomersInactive, 'customersgeotaggedinnactive.xlsx'); // For Excel
    }

    public function exportGeoCSV()
    {

        return Excel::download(new ExportGeotaggedCustomers, 'customers.csv'); // For CSV
    }


}
