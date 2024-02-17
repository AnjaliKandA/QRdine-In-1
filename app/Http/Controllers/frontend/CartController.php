<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cart;
use App\Models\Prefeneces;
use Session;
use App\Model\Coupon;

class CartController extends Controller
{
public function cartitem(Request $request){
    $items = Cart::content();

    if(!empty($request->id)){
$coupondata=Coupon::where('code',$request->id)->first();

    }else{
        $coupondata='';
    }
  
 


return view('frontend.cart',compact('items','coupondata'));
}


public function cartremove(){
 Cart::destroy();
Session::flush();
 return redirect()->route('home');
}

public function checkout(){

   
   $prefeneces=Prefeneces::with('productData','categoryData')->where('pre_count',0)->where('order_no',Session::get('code'))->where('orderstatus',1)->get();
    $prefenecesitem=Prefeneces::with('productData','categoryData')->where('status',0)->where('order_no',Session::get('code'))->where('orderstatus',1)->get();
  


    return view('frontend.preferences',compact('prefeneces','prefenecesitem'));

}
public function preferences(Request $request){
    $prefenecesitem=Prefeneces::where('status',0)->orderBy('id','desc')->where('orderstatus',1)->first();
    if(!empty($prefenecesitem)){
        $pre=$request->select;
        foreach($pre as $key => $value){
            $preferences= Prefeneces::find($pre[$key]);
            $preferences->pre_count = $prefenecesitem->pre_count+1;
            $preferences->status=0 ;
            $preferences->save();
  
      }
    }else{
        $pre=$request->select;
        foreach($pre as $key => $value){
            $preferences= Prefeneces::find($pre[$key]);
            $preferences->pre_count = $preferences->pre_count+1;
            $preferences->status=0 ;
            $preferences->save();
  
      }   
    }
    return redirect()->back();
}


public function paymentoption(Request $request){
Session::put('paymentid', $request->val);
Session::put('ins', $request->ins);

    


}


function cartqtyplus(Request $request){
    Cart::update($request->dataId, ['qty' => $request->qty+1]);

}
function cartqtyminus(Request $request){
    Cart::update($request->dataId, ['qty' => $request->qty-1]);

}


function coupon(){
    $data=Coupon::orderBy('id','desc')->get();
     return view('frontend.coupon',compact('data'));
}

public function applycoupon(Request $request){
    $data=Coupon::where('code',$request->coupon_code)->first();
    if(!empty($data)){
            Session::put('coupon', $data->discount ?? 0);
       
        return redirect()->route('cart.item',['id'=>$request->coupon_code]);
    
    }else{
        return redirect()->back()->with('error','Invalid Coupon Code');
    }
   
    }


}
