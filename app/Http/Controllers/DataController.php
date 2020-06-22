<?php

namespace App\Http\Controllers;

use App\Data;
use Illuminate\Http\Request;

use App\Order;

class DataController extends Controller
{
    public function index(){
        $orders = Order::all();
        return response()->json($orders);
    }

    public function getPayment(){
        return view('payment');
    }

    public function show($id){
        $order = Order::findOrFail($id);
        //$r = array('ok' => 200);
        return response()->json($order);
    }


    public function update($id, Request $req){
        $order = Order::findOrFail($id);
        $order->sum = $req->input('sum');
        $order->porpose = $req->input('porpose');
        $order->save();
        return response()->json(array('ok' => 200, 'message' => 'Order with id ' . $id . ' was updated'));
    }

    public function destroy($id, Request $req){
        Order::destroy($id);
        $r = array('ok' => 200, 'message' => 'Order with id ' . $id . ' was deleted');
        return response()->json($r);
    }

    public function store(Request $req){
        $name = $req->input('name');
        $number = $req->input('number');
        $expiration = $req->input('expiration');
        $cvv = $req->input('cvv');
        $res = [];
        if($this->isValidCreditCard($number)){
            $res = [
                "status" => true,
                "message" => 'good',
            ];
        }else{
            $res = [
                "status" => false,
                "message" => 'bad number',
            ];
        }
        return response()->json($res);
    }

    private function isValidCreditCard($num) {
        $num = preg_replace('/[^\d]/', '', $num);
        $sum = '';

        for ($i = strlen($num) - 1; $i >= 0; -- $i) {
            $sum .= $i & 1 ? $num[$i] : $num[$i] * 2;
        }

        return array_sum(str_split($sum)) % 10 === 0;
    }

}
