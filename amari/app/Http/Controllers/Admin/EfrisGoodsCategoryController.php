<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Models\EfrisGoodsCategory;
use DataTables;
use DB;



class EfrisGoodsCategoryController extends Controller
{
   use CsvImportTrait;
   public function index(){
      return view('admin.products.efriscategory');
   }
   public function getCategories(Request $request){
      if ($request->ajax()) {
         $data = DB::table('efris_category')->latest()->get();
         return Datatables::of($data)
             ->addIndexColumn()
            
             ->rawColumns(['action'])
             ->make(true);
     }
      // $categories = EfrisGoodsCategory::all();
      // dd($categories);
      // return view('admin.products.efriscategory',compact('categories'));
   }
 

public function searchCategories(Request $request)
{
if($request->ajax())
{
$output="";
$categories = DB::table('efris_category')->where('segment_name','LIKE','%'.request()->search."%")->get();

if($categories)
{
foreach ($categories as $key => $category) {
$output.='<tr>'.
'<td>'.$category->segment_name.'</td>'.
'</tr>';
}
return Response($output);
   }
   }
}
     









}
