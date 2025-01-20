<?php

namespace App\Http\Controllers\Helper\Efris;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SaleProduct;
use App\Models\Tax;

class GoodsTaxDetails extends Controller
{
    public function goodtaxdetails($items, $units)
    {

        $goodsdetails = array();
        $taxDetails = array();
        $ordernumber = 0;
        foreach ($items as $a => $b) {
            $item = SaleProduct::with('product')->find($items[$a]);
           // dd($item);
            $net = intval($units[$a]) * $item->sellingprice;
            $discount = $item->discount;
            $total = ($item->sellingprice * $units[$a]);
            $product = Product::find($item->product_id);

            $taxes = Tax::find($product->tax_id);
            //$taxamountdisc = floor(($tax*($a['discount']/1.18))*100)/100;

            $tax = $taxes->value > 0 ? intval($taxes->value)/100 : 0;
            $taxcategorycode = match ($taxes->value) {
                '18' => '01',
                '0' => '02',
                '-' => '03',
            };
            $taxrate = match ($taxes->value) {
                '18' => 0.18,
                '0' => '0',
                '-' => '-',
            };
            $taxamount = match ($taxes->value) {
                '18' => floor(($tax*(($total-$discount)/1.18))*100)/100,
                '0' => floor((0*(($total)/1.18))*100)/100,
                '-' => floor((0*(($total)/1.18))*100)/100,
            };
            $taxamountdisc = floor(($tax*(($discount)/1.18))*100)/100;
            if($discount>0){
                $gooddetails = (Object) [
                "item" => $item->product->name,
                "itemCode" => $item->product->code,
                'goodsCategoryId' => $item->product->efriscategorycode,
                "qty" => -$units[$a],
                "unitOfMeasure" => $item->product->unit,
                "unitPrice" => $item->sellingprice,
                "total" => -1 * ($total-$discount),
                "taxCategoryCode" => $taxcategorycode,
                "taxCategory" => "Standard",
                "taxRate" => $taxrate,
                "tax" => -1*$taxamount,
                // "discountTotal" => $item->discount,
                // "discountTaxRate" => "",
                "orderNumber" => $ordernumber++,
                "discountFlag" => "1",
                "deemedFlag" => "2",
                "exciseFlag" => "2",
                "categoryId" => "1234",
                "categoryName" => "Test",
                //"commodityCategoryId"=>$item->product->category,
                "goodsCategoryName" => "Test",
                "exciseRate" => "",
                "exciseTax" => "",
                "pack" => "1",
                "stick" => "20",
            ];
            $discountdetails = (Object)[
                "item"=> $item->product->name." (Discount)",
                "itemCode"=> $item->product->code,
                'goodsCategoryId'=>$item->product->category,
                "qty"=> "",
                "unitOfMeasure"=> $item->product->unit,
                "unitPrice"=> "",
                "total"=> -$discount,
                "taxRate"=>$taxrate,
                "tax"=>-$taxamountdisc,
                //LINE FOR DISCOUNT
                "discountTotal"=> "",
                "discountTaxRate"=> "",
                "orderNumber"=> $ordernumber++,
                "discountFlag"=> "0",
                "deemedFlag"=> "2",
                "exciseFlag"=> "2",
                "categoryId"=> "1234",
                "categoryName"=> "Test",
                "commodityCategoryId"=>$item->product->category,
                "goodsCategoryName"=> "Test",
                "exciseRate"=> "",
                "exciseRule"=> "1",
                "exciseTax"=> "",
                "pack"=> "1",
                "stick"=> "20",
                "exciseCurrency"=> "UGX",
                "exciseRateName"=> "123",
                "vatApplicableFlag"=>"1"
            ];
            $taxDetail = (Object) [
                "taxCategoryCode" => $taxcategorycode,
                "taxCategory" => "Standard",
                "taxRateName" => "VAT-Standard",
                "netAmount" =>  -1 * ($total-$taxamount),
                "taxRate" => $taxrate,
                "taxAmount" => -1*$taxamount,
                "grossAmount" => -1 * ($total),
                //   "netAmount"=> -1*($total-$net*0.18),
                //   "taxRate"=> "0.18",
                //   "taxAmount"=> -1*($item->sellingprice*0.18 * $units[$a]),
                //   "grossAmount"=> -1*($item->sellingprice*$units[$a]),
                "exciseCurrency" => "UGX",
                "taxRateName" => "123",
            ];
            }else{
            $gooddetails = (Object) [
                "item" => $item->product->name,
                "itemCode" => $item->product->code,
                'goodsCategoryId' => $item->product->category,
                "qty" => -$units[$a],
                "unitOfMeasure" => $item->product->unit,
                "unitPrice" => $item->sellingprice,
                "total" => -1 * ($total-$discount),
                "taxCategoryCode" => $taxcategorycode,
                "taxCategory" => "Standard",
                "taxRate" => $taxrate,
                "tax" => -1*$taxamount,
                // "discountTotal" => $item->discount,
                // "discountTaxRate" => "",
                "orderNumber" => $ordernumber++,
                "discountFlag" => "2",
                "deemedFlag" => "2",
                "exciseFlag" => "2",
                "categoryId" => "1234",
                "categoryName" => "Test",
                //"commodityCategoryId"=>$item->product->category,
                "goodsCategoryName" => "Test",
                "exciseRate" => "",
                "exciseTax" => "",
                "pack" => "1",
                "stick" => "20",
            ];
            $taxDetail = (Object) [
                "taxCategoryCode" => $taxcategorycode,
                "taxCategory" => "Standard",
                "taxRateName" => "VAT-Standard",
                "netAmount" =>  $tax > 0 ? -1 *floor((($total-$discount)/1.18 + 0.18*(($total-$discount)/1.18)-floor((0.18*(($total-$discount)/1.18))*100)/100)*100)/100 : -1 *floor((($total-$discount)/1.18 + 0.18*(($total-$discount)/1.18))*100)/100,
                "taxRate" => $taxrate,
                "taxAmount" => -1*$taxamount,
                "grossAmount" => -1 * ($total-$discount),
                //   "netAmount"=> -1*($total-$net*0.18),
                //   "taxRate"=> "0.18",
                //   "taxAmount"=> -1*($item->sellingprice*0.18 * $units[$a]),
                //   "grossAmount"=> -1*($item->sellingprice*$units[$a]),
                "exciseCurrency" => "UGX",
                "taxRateName" => "123",
            ];
        }
            array_push($goodsdetails, $gooddetails);

            array_push($taxDetails, $taxDetail);
        }
        //dd($goodsdetails);
       // dd($taxDetails);
        $sumgross = 0;
        foreach ($taxDetails as $key => $value) {
            if (isset($value->grossAmount)) {
                $sumgross += $value->grossAmount;
            }

        }
        $summarytotal = 0;
        foreach ($taxDetails as $key => $value) {
            if (isset($value->netAmount)) {
                $summarytotal += $value->netAmount;
            }

        }

        $taxamount = 0;
        foreach ($taxDetails as $key => $value) {
            if (isset($value->taxAmount)) {
                $taxamount += $value->taxAmount;
            }

        }

        return (Object) array("goodsdetails" => $goodsdetails, 'taxdetails' => $taxDetails, 'sumgross' => $sumgross, 'summarytotal' => $summarytotal, 'taxamount' => $taxamount);
    }

    public function debitgoodstaxdetails($items, $units)
    {
        $goodsdetails = array();
        $taxDetails = array();
        $ordernumber = 0;
        foreach ($items as $a => $b) {
            $item = SaleProduct::with('product')->find($items[$a]);
            $net = intval($units[$a]) * $item->product->price;
            $total = $item->product->price * $units[$a];
            $product = Product::find($item->product_id);
            $gooddetails = (Object) [
                "item" => $item->product->name,
                "itemCode" => $item->product->code,
                'goodsCategoryId' => $item->product->category,
                "qty" => $units[$a],
                "unitOfMeasure" => $item->product->unit,
                "unitPrice" => $item->product->price,
                "total" => $total,
                "taxCategoryCode" => "01",
                "taxCategory" => "Standard",
                "taxRate" => "0",
                "tax" => "0",
                "discountTotal" => "",
                "discountTaxRate" => "",
                "orderNumber" => $ordernumber++,
                "discountFlag" => "2",
                "deemedFlag" => "2",
                "exciseFlag" => "2",
                "categoryId" => "1234",
                "categoryName" => "Test",
                "commodityCategoryId" => $item->product->category,
                "goodsCategoryName" => "Test",
                "exciseRate" => "",
                "exciseTax" => "",
                "pack" => "1",
                "stick" => "20",
            ];
            $taxDetail = (Object) [
                "taxCategoryCode" => "01",
                "taxCategory" => "Standard",
                "taxRateName" => "VAT-Standard",
                "netAmount" => $total - $net * 0.18,
                "taxRate" => "0.18",
                "taxAmount" => $item->product->price * 0.18 * $units[$a],
                "grossAmount" => $item->product->price * $units[$a],
                "exciseCurrency" => "UGX",
                "taxRateName" => "123",
            ];
            array_push($goodsdetails, $gooddetails);
            array_push($taxDetails, $taxDetail);
        }

        //dd($taxDetails);
        $sumgross = 0;
        foreach ($taxDetails as $key => $value) {
            if (isset($value->grossAmount)) {
                $sumgross += $value->grossAmount;
            }

        }
        $summarytotal = 0;
        foreach ($taxDetails as $key => $value) {
            if (isset($value->netAmount)) {
                $summarytotal += $value->netAmount;
            }

        }

        $taxamount = 0;
        foreach ($taxDetails as $key => $value) {
            if (isset($value->taxAmount)) {
                $taxamount += $value->taxAmount;
            }

        }

        return (Object) array("goodsdetails" => $goodsdetails, 'taxdetails' => $taxDetails, 'sumgross' => $sumgross, 'summarytotal' => $summarytotal, 'taxamount' => $taxamount);
    }

}
