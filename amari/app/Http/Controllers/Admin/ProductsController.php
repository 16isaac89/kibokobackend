<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductBrand;
use App\Models\Product;
use App\Models\Location;
use App\Models\LocationProduct;
use App\Models\Stock;
use App\Models\ProductVariance;
use App\Models\Supplier;
use App\Models\StockDamage;
use App\Models\StockCount;
use App\Models\ProductCategory;
use App\Models\ProductUnit;
use App\Models\EfrisSetting;
use Gate;
use App\Http\Controllers\Helper\Efris\ProductController;
use App\Http\Controllers\Helper\Efris\KeysController;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Traits\CsvImportTrait;
use Illuminate\Support\Facades\DB;
use App\Models\Tax;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;


class ProductsController extends Controller
{
    use CsvImportTrait;
    public function index(){

        $brands = ProductBrand::all();
        $categories = ProductCategory::all();
        $products = Product::with(['category','brand','tax'])->get();
        $taxes = Tax::all();
        return view('admin.products.index',compact('brands','products','categories','taxes'));
    }

    public function viewedit(){
        $brands = ProductBrand::all();
        $product = Product::with('category','tax','brand')->find(request()->product);
        $categories = ProductCategory::all();
        $taxes = Tax::all();
        $units = ProductUnit::all();
        return view('admin.products.edit',compact('brands','product','categories','units','taxes'));
    }
    public function viewaddcount(){
        $brands = ProductBrand::all();
        $product = Product::with('locationproducts')->find(request()->product);
        $locations = Location::all();
        return view('admin.products.addcount',compact('brands','product','locations'));
    }
    public function store(){
       // dd(request()->all());
         $locations = request()->locations;
         $quantities = request()->quantities;

         $vnames = request()->vname;
         $vquantities = request()->vquantities;
         $vprices = request()->vprices;
       $product =  Product::create([
            'name'=>request()->name,
            'brand_id'=>request()->brandname,
            'code'=>request()->code,
            'unit'=>request()->unit,
            'division'=>request()->division,
            'group'=>request()->group,
            'tax_id'=>request()->tax_id,
            "product_category"=>request()->categorycode,
        ]);
        // foreach($locations as $key=> $a){
        //     $location = intVal($locations[$key]);
        //     $quantity = intVal($quantities[$key]);
        //     LocationProduct::create([
        //         'location_id'=>$location,
        //         'product_id'=>$product->id,
        //         'quantity'=>$quantity,
        //     ]);
        // }
        // foreach($vnames as $key=> $a){
        //     ProductVariance::create([
        //         'name'=>$vnames[$key],
        //         'price'=>$vprices[$key],
        //         'quantity'=>$vquantities[$key],
        //         'product_id'=>$product->id,
        //     ]);
        // }
        return redirect()->back()->with('message', 'Product has been saved successfully');
       // return back();
    }
    public function editProduct(){
      // dd(request()->all());

      $vnames = request()->vname;
      $vquantities = request()->vquantities;
      $vprices = request()->vprices;

        Product::find(request()->productid)->update([
            'name'=>request()->productname,
            'brand_id'=>request()->brand_id,
            'code'=>request()->productcode,
            'unit'=>request()->unit,
            'division'=>request()->division,
            'group'=>request()->group,
            'tax_id'=>request()->tax_id,
            "product_category"=>request()->product_category,
        ]);


        // foreach($vnames as $key=> $a){
        //     ProductVariance::create([
        //         'name'=>$vnames[$key],
        //         'price'=>$vprices[$key],
        //         'quantity'=>$vquantities[$key],
        //         'product_id'=>$product->id,
        //     ]);
        // }

        return redirect()->back()->with('message', 'Product has been edited');
        //return back();
    }
    public function productDetails(){
        dd(request()->all());
        $product = Product::find(request()->product);
        return response()->json(['product'=>$product]);
    }

    public function storecount(){
       //dd(request()->all());
        $locations = request()->locations;
        $quantities = request()->quantities;
        $product = request()->productid;
        $date = request()->period;
        $damagetypes = request()->damagetype;
        $damagevalues = request()->damagevalues;
        // Stock::create([
        //     'period'=>$date,
        //     'product_id'=>$product,
        //     'amount'=>request()->amount,
        // ]);
       foreach($locations as $key=> $a){
           $location = intVal($locations[$key]);
           $quantity = intVal($quantities[$key]);
           LocationProduct::create([
               'location_id'=>$location,
               'product_id'=>$product,
               'quantity'=>$quantity,
               'countdate'=>$date,
           ]);
       }

       foreach($damagetypes  as $key=> $a){
       StockDamage::create([
        'product_id'=>$product,
        'count'=>$damagevalues[$key],
        'date'=>$date,
        'comment'=>request()->comment,
        'type'=>$damagetypes[$key]
       ]);
    }
       StockCount::create([
        'product_id'=>$product,
        'count'=>request()->amount,
        'date'=>$date,
        'comment'=>request()->comment,
    ]);

       return redirect()->back()->with('message', 'Stock Count has been saved successfully!');
       //return back();
   }

   public function viewbatches(){
    $product = Product::with('stocks')->find(request()->product);
    //dd($product);
    return view('admin.products.batches',compact('product'));
   }

   public function deletebatch(Stock $stock){
    abort_if(Gate::denies('delete_batch'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    $stock->delete();
    return back();
   }
   public function productcost(){
    $product = Product::with('stocks')->find(request()->product);
    return view('admin.products.cost',compact('product'));
   }
   public function saveproductcost(){
    //dd(request()->all());
    $costs = request()->costs;
    $stocks = request()->stocks;
    foreach($stocks as $key => $a){
        $stock = Stock::find($stocks[$key]);
        $stock->update([
            'cost'=>$costs[$key],
        ]);
    }
    return redirect()->back()->with('success', 'Stock Costs have been saved successfully!');
   }
   public function savebatch(){
    //dd(request()->all());
    $batches = request()->stocks;
    $amounts = request()->amount;
    $sellingprices = request()->selling;
    foreach($batches as $key => $a){
        Stock::find($batches[$key])->update([
                'amount'=>$amounts[$key],
                'sellingprice'=>$sellingprices[$key],
        ]);
    }
    return redirect()->back()->with('success', 'Product batch has been saved.');
   }

   public function addbatchesview(){
    $id = request()->product;
    $product = Product::find($id);
    return view('admin.products.addbatch',compact('product'));
   }
   public function saveaddbatch(){
    $item = Product::find(request()->product);
    $supplier = Supplier::find($item->supplier_id);
        $dealerefris = EfrisSetting::find(1);
        $keypath = $dealerefris->keypath;
        $keypwd = $dealerefris->keypwd;
        $tin = $dealerefris->tin;
        $deviceno = $dealerefris->deviceno;
        $privatek = (new KeysController)->getPrivateKey($keypath,$keypwd);
        //$aeskey = (new KeysController)->getAesKey($tin,$deviceno,$privatek);
        $aeskey = $dealerefris->aeskey;
        $quantity = request()->stocks;
       // $aeskey = (new KeysController)->getAesKey($tin,$deviceno,$privatek);

       //$efris = (new ProductController)->addproductStock($item,$aeskey,$privatek,$tin,$deviceno,$quantity);
       $efris = (new ProductController)->restockProduct($item,$aeskey,$privatek,$tin,$deviceno,$quantity,$supplier);
       $returncode = $efris->message['returnStateInfo']['returnCode'];
       if($returncode === "00"){
        Stock::create([
            'product_id'=>request()->product,
            'amount'=>request()->stocks,
            'sellingprice'=>request()->prices,
            'batch'=>request()->invoices,
            'cost'=>request()->cost,
            'receivedate'=>request()->receivedate,
            'expirydate'=>request()->expiry,
        ]);
        return redirect()->back()->with('message', 'Product stock has been saved in EFRIS and Batch added successfuly.');
        //return redirect()->back()->with('success', 'Product stock has been saved in EFRIS and Batch added successfuly.');
       }else{
        return redirect()->back()->with('errors', 'Error try again.');
        //return \Redirect::back()->withErrors(['msg' => 'Error try again']);
       }


   }

   public function editlocationview(){
    $product = Product::with('locationproducts','variances')->find(request()->product);
    $locations = Location::all();
    return view('admin.products.editlocation',compact('product','locations',));
   }
   public function saveeditlocation(){
    //dd(request()->all());
    $locations = request()->locations;
    $quantities = request()->quantities;
    foreach($locations as $key=> $a){
        if($quantities[$key]){
            $locate = LocationProduct::where(['location_id'=>$locations[$key],'product_id'=>request()->productid])->first();
            if($locate){
                $locate->update([
                    'quantity'=> intVal($quantities[$key]),
                ]);
            }else{
                LocationProduct::create([
                    'location_id'=>intVal($locations[$key]),
                    'product_id'=>$product->id,
                    'quantity'=>intVal($quantities[$key]),
                ]);
            }

        }
        return redirect()->back()->with('message', 'Product locations edited successfuly');
    }
   }

   public function delete(){
    $product = Product::find(request()->product);
    $product->delete();
    return redirect()->back();
   }
   public function importProductUpdates(Request $request)
   {
// Load the Excel file
	   //dd($request->all());
         // Move the uploaded file to a temporary directory with the `.xlsx` extension
         $file = $request->file('file');
         $filePath = $file->storeAs('temp', 'import_products.xlsx', 'local');

         // Full path to the stored file
         $fullPath = storage_path('app/' . $filePath);
           // dd($fullPath);

               // Load the Excel file explicitly specifying the type
         $data = Excel::toArray([], $fullPath, null, \Maatwebsite\Excel\Excel::XLSX);
     //dd($data);
         // Assuming the data is in the first sheet
         $rows = $data[0];


            // Assuming the data is in the first sheet
            $rows = $data[0];
            //dd($rows);

            // Loop through each row, skipping the header
            foreach ($rows as $index => $row) {
                if ($index == 0) {
                    // Skip header row
                    continue;
                }

                $productCode = $row[1];
                $recommendedSellingPrice = $row[4];
                $vat = $row[5];

                // Find product by product code
                $product = Product::where('code', $productCode)->first();


                if ($product) {
                    // Update product attributes
                    $product->selling_price = $recommendedSellingPrice;
                    $product->tax_amount = $vat;
                    $product->save();
                }
            }

            return redirect()->back()->with('message', 'Products have been updated successfully!');
   }
   public function importProductEfris(Request $request)
{
    $request->validate([
        'excel_file' => 'required|file|mimes:xlsx,csv',
    ]);

    $path = $request->file('excel_file')->getRealPath();
    $data = Excel::toArray([], $path);

    $sheet = $data[0];

    foreach ($sheet as $index => $row) {

        if ($index === 0) continue;

        $code = $row[1];
        $catCode = $row[5];
        $catName = $row[6];

        $product = Product::where('code', $code)->first();

        if ($product) {
            $product->update([
                'efriscategorycode' => $catCode,
                'efriscategoryname' => $catName,
            ]);
        }
    }

    return redirect()->back()->with('success', 'Products updated successfully!');
}

}
