<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Cart;
use App\Models\Category;
use App\Models\Prefeneces;
use App\Model\BusinessSetting;
use Illuminate\Support\Str;
use Session;



class FrontendController extends Controller
{

public function index(Request $request){
  if(!empty($request->table)){
      Session::put('tableid',$request->table);
      
       $category=Category::where('supplier',0)->orderBy('id','desc')->limit(8)->get();
    $detail=BusinessSetting::where(['key' => 'restaurant_name'])->first();
    $logo=BusinessSetting::where(['key' => 'logo'])->first();
    $address=BusinessSetting::where(['key' => 'address'])->first();
 if (Cart::count() > 0){
  }else{
      $random = Str::random(5);
      Session::put('code',$random );
     }
return view('frontend.index',compact('category','detail','logo','address'));
  }else{
       $category=Category::where('supplier',0)->orderBy('id','desc')->limit(8)->get();
    $detail=BusinessSetting::where(['key' => 'restaurant_name'])->first();
    $logo=BusinessSetting::where(['key' => 'logo'])->first();
    $address=BusinessSetting::where(['key' => 'address'])->first();
 if (Cart::count() > 0){
  }else{
      $random = Str::random(5);
      Session::put('code',$random );
     }
return view('frontend.index',compact('category','detail','logo','address'));
  }

   
}

public  function nonfilter(Request $request){
  $type=$request->type;



  if($type == 1){
  
        $product = Product::where('set_menu',1)
                            ->where('status', 1)
                            ->get();

}else{
    $product = Product::where('product_type', $type)
                            ->where('status', 1)
                            ->get();

}
 
$detail=BusinessSetting::where(['key' => 'restaurant_name'])->first();
    $logo=BusinessSetting::where(['key' => 'logo'])->first();
    $address=BusinessSetting::where(['key' => 'address'])->first();
 if (Cart::count() > 0){
  }else{
      $random = Str::random(5);
      Session::put('code',$random );
     }
return view('frontend.filter',compact('detail','logo','address','product','type')); 

}


public function popup(Request $request){

$productid=$request->id;
if(!empty($productid)){
$products=Product::where('id',$productid)->first();
}
return view('frontend.popup',compact('products')); 
}

public function modeldata(Request $request){
  $productid=$request->id;
if(!empty($productid)){
$products=Product::where('id',$productid)->first();
}

return view('frontend.model',compact('products'));

}
public function cartitem(Request $request){
$products=Product::where('id',$request->id)->first();

if(!empty($request->val)){
       Cart::add(['id' =>  $products->id, 
    'name' => $products->name, 
    'qty' => 1,
    'desc' => $products->description ?? '',
    'image' => $products->image ?? '',
    'price' => $request->val, 
    'options' => ['choose' => $request->val,'ordetype' => $request->type,'image'=>$products->image ?? '','desc'=>$products->description,'add_ons'=>$request->add_onsid]]);

    }else{
    Cart::add(['id' =>  $products->id, 
    'name' => $products->name, 
    'qty' => 1,
    'desc' => $products->description ?? '',
    'image' => $products->image ?? '',
    'price' => $products->price, 
    'options' => ['choose' => $request->val,'ordetype' => $request->type,'image'=>$products->image ?? '','desc'=>$products->description]]);

    }
    $preferences= new Prefeneces();
    $preferences->pro_id=$products->id;
    $preferences->pre_count = 0;
    $preferences->qty=1 ;
    $preferences->status=1 ;
    $preferences->option1=$request->val ?? '';
    $preferences->option2=$request->val ?? '';
    $preferences->add_ons=$request->add_onsid ?? 0;
     $preferences->order_no=Session::get('code');
     $preferences->cate_id=$products->category_id ?? 0;
   $preferences->save();
}





}
