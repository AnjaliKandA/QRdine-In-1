<?php
namespace App\Http\Controllers\frontend;
use Illuminate\Http\Request;
use App\Models\OrderDetail;
use App\Models\Order;
use Carbon\Carbon;
use App\CentralLogics\helpers;
use App\CentralLogics\OrderLogic;
use App\Http\Controllers\Controller;
use App\Model\AddOn;
use App\Model\BusinessSetting;
use App\Model\CustomerAddress;
use App\Model\DMReview;
use App\Model\Product;
use App\Model\ProductByBranch;
use App\Models\GuestUser;
use App\Models\OfflinePayment;
use App\Models\OrderPartialPayment;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use function App\CentralLogics\translate;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Table;
use App\Models\Category;
use App\Models\Prefeneces;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{
    public function __construct(

        private Order           $order,
        private OrderDetail     $order_detail,


    ) {
    }

    public function place_order(Request $request)
    {
        //  generateUniqueCode();
        if ($request->sizeOption == 1) {

            // $order_id = 100000 + $this->order->all()->count() + 1;
            $order_id = 100000 + Order::count() + 1;
            while (Order::find($order_id)) {
                $order_id++;
            }
            Session::put('generatecode', $order_id);
            $or = new Order();
            $or->id = $order_id;
            $or->user_id = 33;
            // $or->user_id = $user_id;

            $orderAmount = str_replace(',', '', Cart::subtotal());
            $or->order_amount = is_numeric($orderAmount) ? $orderAmount : 0;
            $or->coupon_discount_title = 'coupon';
            $or->payment_status = 'pending';
            $or->order_status = 'pending';

            $or->coupon_code = Cart::subtotal();
            $or->payment_method = Session::get('paymentid');
            $or->transaction_reference = 'cash';
            $or->order_note = 'order pending';
            $or->order_type = 'dine_in';
            $or->delivery_address_id = 1;
            $or->delivery_date = now();
            $or->delivery_time = '';
            $or->delivery_address = '';
            $or->delivery_charge = 0;
            $or->preparation_time = 0;
            // $or->table_id = 5;
            $or->table_id = Session::get('tableid') ?? 0;
            $or->number_of_people = 2;
            $or->ordercode = Session::get('code') ?? 0;
            $or->created_at = now();
            $or->updated_at = now();
            $or->order_date = now();
            // dd($or);
            $or->save();
            $items = Cart::content();
            foreach ($items as $key => $value) {
                $detail = new OrderDetail();
                $detail->order_id = $or->id;
                $detail->product_id = $value->id;
                $detail->product_details = 0;
                $detail->quantity = $value->qty ?? 0;
                $detail->price = $value->price ?? 0;
                $detail->tax_amount = 0;
                $detail->discount_on_product = 0;
                $detail->discount_type = '';
                $detail->variant = '';
                $detail->add_on_ids = '';
                $detail->variant = '';
                $detail->variation = '';
                $detail->add_on_ids = '';
                $detail->add_on_qtys = '';
                $detail->add_on_prices = '';
                $detail->add_on_taxes = '';
                $detail->option1 = $value->options->ordetype ?? '';
                $detail->option2 = $value->options->choose ?? '';
                $detail->add_on_tax_amount = 0.00;
                $detail->ins = Session::get('ins') ?? '';
                $detail->created_at = now();
                $detail->updated_at = now();
                $detail->save();


                if ($or->order_status == 'confirmed') {
                    $data = [
                        'title' => 'You have a new order - (Order Confirmed).',
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
            return redirect()->route('order.place.success');
        } else if ($request->form == 2) {

            // $order_id = 100000 + $this->order->all()->count() + 1;
            $order_id = 100000 + Order::count() + 1;
            while (Order::find($order_id)) {
                $order_id++;
            }
            Session::put('generatecode', $order_id);
            $or = new Order();
            $or->id = $order_id;
            $or->user_id = 33;
            // $or->user_id = $user_id;

            $orderAmount = str_replace(',', '', Cart::subtotal());
            $or->order_amount = is_numeric($orderAmount) ? $orderAmount : 0;
            $or->coupon_discount_title = 'coupon';
            $or->payment_status = 'pending';
            $or->order_status = 'pending';

            $or->coupon_code = Cart::subtotal();
            $or->payment_method = Session::get('paymentid');
            $or->transaction_reference = 'cash';
            $or->order_note = 'order pending';
            $or->order_type = 'dine_in';
            $or->delivery_address_id = 1;
            $or->delivery_date = now();
            $or->delivery_time = '';
            $or->delivery_address = '';
            $or->delivery_charge = 0;
            $or->preparation_time = 0;
            // $or->table_id = 5;
            $or->table_id = Session::get('tableid') ?? 0;
            $or->number_of_people = 2;
            $or->ordercode = Session::get('code') ?? 0;
            $or->created_at = now();
            $or->updated_at = now();
            $or->order_date = now();
            // dd($or);
            $or->save();
            $items = Cart::content();
            foreach ($items as $key => $value) {
                $detail = new OrderDetail();
                $detail->order_id = $or->id;
                $detail->product_id = $value->id;
                $detail->product_details = 0;
                $detail->quantity = $value->qty ?? 0;
                $detail->price = $value->price ?? 0;
                $detail->tax_amount = 0;
                $detail->discount_on_product = 0;
                $detail->discount_type = '';
                $detail->variant = '';
                $detail->add_on_ids = '';
                $detail->variant = '';
                $detail->variation = '';
                $detail->add_on_ids = '';
                $detail->add_on_qtys = '';
                $detail->add_on_prices = '';
                $detail->add_on_taxes = '';
                $detail->option1 = $value->options->ordetype ?? '';
                $detail->option2 = $value->options->choose ?? '';
                $detail->add_on_tax_amount = 0.00;
                $detail->ins = Session::get('ins') ?? '';
                $detail->created_at = now();
                $detail->updated_at = now();
                $detail->save();

                $user = new CustomerAddress();
                $user->contact_person_name = $request->name ?? '';
                $user->contact_person_number = $request->phone ?? '';
                $user->address = '';
                $user->address = '';
                $user->address_type = '';
                $user->order_no = $order_id;
                $user->save();





                if ($or->order_status == 'confirmed') {
                    $data = [
                        'title' => 'You have a new order - (Order Confirmed).',
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
            return redirect()->route('order.place.success');
        }
    }
    public function order_success()
    {

        return view('frontend.order');
    }

    // public function trackorder()
    // {
    //     // $orderdetail = Order::With('tabledata')->where('id', session()->get('generatecode'))->orderBy('id', 'desc')->first();
    //     $order_id = session()->get('generatecode');
    //     if (!$order_id) {
    //         return redirect()->back()->with('error', 'Invalid order ID');
    //     }

    //     $orderdetail = Order::With('tabledata')->where('id', $order_id)->orderBy('id', 'desc')->first();
    //     dd($orderdetail->tabledata->id);
    //     $tabledata = Table::With('waiter')->where('table_id', $orderdetail->tabledata->id)->first();


    //     return view('frontend.track', compact('orderdetail', 'tabledata'));
    // }
    public function trackorder()
    {
        $order_id = session()->get('generatecode');
        if (!$order_id) {
            return redirect()->back()->with('error', 'Invalid order ID');
        }

        $orders = Order::with('tabledata')->where('id', $order_id)->orderBy('id', 'desc')->get();

        if ($orders->isEmpty()) {
            return redirect()->back()->with('error', 'No orders found');
        }

        $orderdetail = [];

        foreach ($orders as $order) {
            if ($order->tabledata) {
                $tableDataId = $order->tabledata->id;
                // Retrieve 'waiter' relationship within 'tabledata'
                $tabledata = Table::with('waiter')->where('id', $tableDataId)->first();

                $orderdetail[] = [
                    'order' => $order,
                    'tabledata' => $order->tabledata,
                    'waiter' => $tabledata->waiter ?? null,
                ];
            } else {
                $orderdetail[] = [
                    'order' => $order,
                    'error' => 'Table data not found for the order',
                ];
            }
        }

        return view('frontend.track', compact('orderdetail'));
    }




    public function success()
    {
        Session::forget('generatecode');
        return view('frontend.success');
    }

    public function order_more(Request  $request)
    {
        $category = Category::where('supplier', 0)->orderBy('id', 'desc')->limit(8)->get();
        $detail = BusinessSetting::where(['key' => 'restaurant_name'])->first();
        $logo = BusinessSetting::where(['key' => 'logo'])->first();
        $address = BusinessSetting::where(['key' => 'address'])->first();
        $items = Cart::content();
        $order = Order::where('id', Session::get('generatecode'))->first();
        return view('ordermore.order_more', compact('category', 'detail', 'logo', 'address', 'items', 'order'));
    }
}