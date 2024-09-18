foreach($items as $item){
     
     $gooddetails = (Object)[
         "item"=> $item->name,
         "itemCode"=> $item->product->code,
         'goodsCategoryId'=>$item->product->category,
         "qty"=> "2",
         "unitOfMeasure"=> $item->product->unit,
         "unitPrice"=> $item->sellingprice,
         "total"=> 2*$item->sellingprice,
         "taxRate"=> "0",
         "tax"=> "0",
         "discountTotal"=> "",
         "discountTaxRate"=> "",
         "orderNumber"=> $ordernumber++,
         "discountFlag"=> "2",
         "deemedFlag"=> "2",
         "exciseFlag"=> "2",
         "categoryId"=> "1234",
         "categoryName"=> "Test",
         "commodityCategoryId"=>$item->category,
         "goodsCategoryName"=> "Test",
         "exciseRate"=> "",
         "exciseRule"=> "1",
         "exciseTax"=> "",
         "pack"=> "1",
         "stick"=> "20",
         "exciseUnit"=> "101",
         "exciseCurrency"=> "UGX",
         "exciseRateName"=> "123"
     ];
     $taxDetail = (Object)[
         "taxCategoryCode"=> "02",
         "netAmount"=> 2*$item->sellingprice,
         "taxRate"=> "0",
         "taxAmount"=> "0",
         "grossAmount"=> 2*$item->sellingprice,
         "exciseUnit"=> "101",
         "exciseCurrency"=> "UGX",
         "taxRateName"=> "123"
         
     ];
     array_push($goodsdetails,$gooddetails);
     array_push($taxDetails,$taxDetail);
 }