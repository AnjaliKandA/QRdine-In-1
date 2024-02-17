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
use App\Models\OrderDetail;
use App\Models\Order;
use App\CentralLogics\Helpers;



class OrderMoreController extends Controller
{
   
    public function __construct(
       
        private Order           $order,
        private OrderDetail     $order_detail,
     
       
    ){}
public function morepopup(Request $request){

$productid=$request->id;
if(!empty($productid)){
$products=Product::where('id',$productid)->first();
}
return view('ordermore.morepopup',compact('products')); 
}

public function modeldata(Request $request){
  $productid=$request->id;
if(!empty($productid)){
$products=Product::where('id',$productid)->first();
}
return view('ordermore.model',compact('products'));

}

public function morecartitem(Request $request){
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
public function cart_item_data(Request $request){
    $items = Cart::content();

    if(!empty($request->id)){
$coupondata=Coupon::where('code',$request->id)->first();

    }else{
        $coupondata='';
    }
return view('ordermore.cart',compact('items','coupondata'));
}

public function order_pre(){

   
   $prefeneces=Prefeneces::with('productData')->where('pre_count',0)->where('orderstatus',1)->get();
   $prefenecesitem=Prefeneces::with('productData')->where('status',0)->where('orderstatus',1)->get();


    return view('ordermore.preferences',compact('prefeneces','prefenecesitem'));

}


  public function moreorder(Request $request)
    {
      



      $ordeOrder=Order::where('id',Session::get('generatecode'))->first();
      
      
       
    //  generateUniqueCode();
 if($request->sizeOption == 1){
   
$order_id = 100000 + $this->order->all()->count() + 1;

                $or= new Order();
                $or->id =$order_id;
                $or->user_id =33;
                $or->order_amount = Helpers::set_price(Cart::subtotal());
                $or->coupon_discount_title = 'coupon';
                $or->payment_status ='pending';
                $or->order_status = 'pending';
                $or->coupon_code = Helpers::set_price(Cart::subtotal());
                $or->payment_method = $ordeOrder->payment_method;
                $or->transaction_reference ='cash';
                $or->order_note = 'order pending';
                $or->order_type ='dine_in';
                $or->delivery_address_id = 1;
                $or->delivery_date = now();
                $or->delivery_time = '';
                $or->delivery_address ='';
                $or->delivery_charge =0;
                $or->preparation_time =0;
                $or->table_id =$ordeOrder->table_id ?? 0;
                $or->number_of_people = 2;
                $or->ordercode= Session::get('code') ?? 0;
                $or->created_at = now();
                $or->updated_at = now();
                $or->order_date = now();
                $or->save();

         $items = Cart::content();
        foreach($items as $key => $value){
 $detail= new OrderDetail();
         $detail->order_id = $ordeOrder->id;
        $detail->product_id =$value->id;
        $detail->product_details =0;
        $detail->quantity =$value->qty ?? 0;
        $detail->price = $value->price ?? 0;
        $detail->tax_amount = 2;
        $detail->discount_on_product =0;
        $detail->discount_type = '';
        $detail->variant = '';
        $detail->add_on_ids='';
        $detail->variant ='';
        $detail->variation = '';
        $detail->add_on_ids = '';
        $detail->add_on_qtys='';
        $detail->add_on_prices ='';
        $detail->add_on_taxes = '';
        $detail->option1=$value->options->ordetype ?? '';
        $detail->option2=$value->options->choose ?? '';
        $detail->add_on_tax_amount=0.00;
        $detail->ins=Session::get('ins') ?? '';
        $detail->order_more= $ordeOrder->id ?? 0;
         $detail->created_at = now();
        $detail->updated_at = now();
        $detail->save();


         if ( $or->order_status == 'confirmed') {
                $data = [
                    'title' => 'Thank you for Re-Ordering,Your order Has been confirmed with Previous Order',
                  'description' => $order_id,
                    'order_id' => $order_id,
                    'image' => '',
                ];

                try {
                    Helpers::send_push_notif_to_topic($data, "kitchen-{$or->order_id}", 'general');

                } catch (\Exception $e) {
                    Toastr::warning('Push notification failed!');
                }
      
            }
        }
             Cart::destroy();
           return redirect()->route('order.order_track');

    }else if ($request->form == 2){
     
      

        $order_id = 100000 + $this->order->all()->count() + 1;

                $or= new Order();
                $or->id =$order_id;
                $or->user_id =33;
                $or->order_amount = Helpers::set_price(Cart::subtotal());
                $or->coupon_discount_title = 'coupon';
                $or->payment_status ='pending';
                $or->order_status = 'pending';
                $or->coupon_code = Helpers::set_price(Cart::subtotal());
                $or->payment_method = $ordeOrder->payment_method;
                $or->transaction_reference ='cash';
                $or->order_note = 'order pending';
                $or->order_type ='dine_in';
                $or->delivery_address_id = 1;
                $or->delivery_date = now();
                $or->delivery_time = '';
                $or->delivery_address ='';
                $or->delivery_charge =0;
                $or->preparation_time =0;
                $or->table_id =$ordeOrder->table_id ?? 0;
                $or->number_of_people = 2;
                $or->ordercode= Session::get('code') ?? 0;
                 $detail->order_more= $ordeOrder->id ?? 0;
                $or->created_at = now();
                $or->updated_at = now();
                $or->order_date = now();
                $or->save();
         
          $items = Cart::content();
        foreach($items as $key => $value){
 $detail= new OrderDetail();
         $detail->order_id = $or->id;
        $detail->product_id =$value->id;
        $detail->product_details =0;
        $detail->quantity =$value->qty ?? 0;
        $detail->price = $value->price ?? 0;
        $detail->tax_amount = 2;
        $detail->discount_on_product =0;
        $detail->discount_type = '';
        $detail->variant = '';
        $detail->add_on_ids='';
        $detail->variant ='';
        $detail->variation = '';
        $detail->add_on_ids = '';
        $detail->add_on_qtys='';
        $detail->add_on_prices ='';
        $detail->add_on_taxes = '';
        $detail->option1=$value->options->ordetype ?? '';
        $detail->option2=$value->options->choose ?? '';
        $detail->add_on_tax_amount=0.00;
        $detail->ins=Session::get('ins') ?? '';
        
         $detail->created_at = now();
        $detail->updated_at = now();
        $detail->save();

      





         if ($or->order_status == 'confirmed') {
                   $data = [
                    'title' => 'Thank you for Re-Ordering,Your order Has been confirmed with Previous Order',
                  'description' => $order_id,
                    'order_id' => $order_id,
                    'image' => '',
                ];

                try {
                    Helpers::send_push_notif_to_topic($data, "kitchen-{$or->order_id}", 'general');

                } catch (\Exception $e) {
                    Toastr::warning('Push notification failed!');
                }
      
            }
        }
             Cart::destroy();
            return redirect()->route('order.order_track');
        
    }
}


}
