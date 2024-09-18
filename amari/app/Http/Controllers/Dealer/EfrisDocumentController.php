<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EfrisNoteDocument;
use App\Models\Dealer;
use App\Models\DealerProduct;
use App\Models\EfrisSync;
use App\Http\Controllers\Helper\Efris\KeysController;
use App\Http\Controllers\Helper\Efris\NotesController;
use App\Models\EfrisSetting;
use Carbon\Carbon;

class EfrisDocumentController extends Controller
{
    public function creditnoteindex(){
        if(\Auth::guard('dealer')->check()){
           // $sales = [];
        $sales = EfrisNoteDocument::with(['sale'=>function($q){
            $q->with('customer');
        }])->get();
        //->whereDate('created_at', Carbon::today())->get();
        //dd($sales);
        return view('dealer.efrisdocs.creditnotes',compact('sales'));
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }

    }
    public function creditnotesearch(){
        if(\Auth::guard('dealer')->check()){
           ;
        $sales = EfrisNoteDocument::with(['sale'=>function($q){
            $q->with('customer');
        }])->where('sale_id',request()->sale)->get();
        //dd($sales);
        return view('dealer.efrisdocs.creditnotes',compact('sales'));
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }

    }

    public function cancelcreditnote(){
       // dd(request()->all());
        $note = EfrisNoteDocument::with('document','sale')->find(request()->noteid);
        //dd($note);
        //$note = EfrisNoteDocument::find($notedoc->efris_document_id);
        $dealer = \Auth::guard('dealer')->user()->dealer;
        // dd($note);
        $invoiceid = $note->document->inv_id;

        $invoiceno = $note->cr_inv_no;

        $invoiceApplyCategoryCode = "104";
        $reasonCode = request()->reasonCode;
        $reason = request()->reason;

        $dealerefris = $dealer;
        $keypath = $dealerefris->privatekey;
        $keypwd = $dealerefris->keypwd;
        $tin = $dealerefris->tin;
        $deviceno = $dealerefris->deviceno;
        $privatek = (new KeysController)->getPrivateKey($keypath,$keypwd);
        //$aeskey = (new KeysController)->getAesKey($tin,$deviceno,$privatek);
        $aeskey = $dealerefris->aeskey;

        $noteid = $note->reference;
        $inv_no = $note->document->inv_no;
        $from_date = $note->created_at;
        $to_date = $note->created_at->addDays(1);


        $efris = (new NotesController)->creditnotecancel($deviceno,$tin,$privatek, $aeskey,$invoiceid,$invoiceno,$invoiceApplyCategoryCode,$reasonCode,$reason,$from_date,$to_date,$noteid);
        //dd($efris);
        if($efris->status === 200){
            if($efris->respcode['returnStateInfo']['returnCode'] === "00"){
                $note->update([
                    'status'=>"2"
                ]);
                return \Redirect::back()->with('message', 'Credit note has been cancelled');
            }else{
                return \Redirect::back()->with('message', 'Credit note has failed to cancel because '.$efris->respcode['returnStateInfo']['returnMessage']);
            }
        }else{
            return \Redirect::back()->with('error', 'Could not send request check your internet.');
        }
        //dd($cancel);
    }

    public function creditnotestatus(){

        $document = EfrisNoteDocument::with('document')->find(request()->note);

        $dealerefris = \Auth::guard('dealer')->user()->dealer;
        $keypath = $dealerefris->privatekey;
        $keypwd = $dealerefris->keypwd;
        $tin = $dealerefris->tin;
        $deviceno = $dealerefris->deviceno;
        $privatek = (new KeysController)->getPrivateKey($keypath,$keypwd);
        //$aeskey = (new KeysController)->getAesKey($tin,$deviceno,$privatek);
        $aeskey = $dealerefris->aeskey;
        $noteid = $document->reference;
        $inv_no = $document->document->inv_no;
        $from_date = $document->created_at;
        $to_date = $document->created_at->addDays(1);


        $efris = (new NotesController)->getstatus($tin,$deviceno,$privatek,$aeskey,$noteid,$inv_no,$from_date,$to_date);

        if($efris->status == 200){
            if(count($efris->data)>0){
                $document->cr_inv_no = $efris->data[0]->invoiceNo;
                $document->status = $efris->data[0]->approveStatus;
                $document->fdn = $efris->data[0]->invoiceNo;
                $document->ver_code = $efris->data[0]->id;
                $document->save();
                $status = match ($efris->data[0]->approveStatus) {
                    '101' => 'Approved',
                    '102' => 'Submitted',
                    '103' => 'Rejected',
                    '104' => 'Voided',
                };
                return \Redirect::back()->with('message', 'Credit note has been '.$status);
            }else{
                return \Redirect::back()->with('error', 'Credit note has not yet been verified/approved.');
            }

        }else{
            return \Redirect::back()->with('error', 'Could not send request check your internet.');
        }
    }


    public function creditnotedetails(){

        $document = EfrisNoteDocument::with('document')->find(request()->note);

        $dealerefris = \Auth::guard('dealer')->user()->dealer;
        $keypath = $dealerefris->privatekey;
        $keypwd = $dealerefris->keypwd;
        $tin = $dealerefris->tin;
        $deviceno = $dealerefris->deviceno;
        $privatek = (new KeysController)->getPrivateKey($keypath,$keypwd);
        //$aeskey = (new KeysController)->getAesKey($tin,$deviceno,$privatek);
        $aeskey = $dealerefris->aeskey;
        $noteid = $document->cr_inv_no;
        $inv_no = $document->document->inv_no;

        $efris = (new NotesController)->getcreditnotedetails($tin,$deviceno,$privatek,$aeskey,$noteid);
//dd($efris);
        if($efris->status == 200){
            $crnote = $efris->data;
            $crid = $document->cr_inv_no;
            $dealer = $dealerefris;
// dd($crnote);
          return view('dealer.sales.creditnotedets',compact('crnote','crid','dealer'));
        }else{
            return \Redirect::back()->with('error', 'Could not send request check your internet.');
        }



    }
}
