<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use Illuminate\Http\Response;
use Validation;

class BillingController extends Controller
{
    public function show($id){
        $order = Order::findOrFail($id);
        return response()->json($order)->setStatusCode(Response::HTTP_OK);
    }

    public function index(Request $req){
        $orders = Order::all();
        return response()->json($orders)->setStatusCode(Response::HTTP_OK);
    }

    public function update($id, Request $req){
        $order = Order::findOrFail($id);
        $order->sum = $req->input('sum');
        $order->porpose = $req->input('porpose');
        $order->save();
        return response()->json(array('ok' => 200, 'message' => 'Order with id ' . $id . ' was updated'))->setStatusCode(Response::HTTP_OK);
    }

    public function destroy($id = null, Request $req){
        $name = $req->input('name');
        $number = $req->input('number');
        $expiration = $req->input('expiration');
        $cvv = $req->input('cvv');
        if(isset($id)){
            $order = Order::findOrFail($id);
            $order->delete();
            $r = array('ok' => 200, 'message' => 'Order with id ' . $id . ' was deleted');
            return response()->json($r);
        }elseif (Validation::isCardValid($number, $name, $cvv, $expiration)) {
            $orders = Order::find($req->input('array'));
            foreach ($orders as $order) {
                $order->delete();
            }
            $r = array('ok' => 200, 'message' => 'Order with id ' . $req->getContent() . ' was deleted' . $orders);
            return response()->json($r);
        }else{
            $bol = Validation::isCardValid($number, $name, $cvv, $expiration);
            $bol = var_dump($bol);
            return response()->json(['message' => 'Invalid input data', 'data' => $name . ' ' . $number . ' ' . $expiration . ' ' . $cvv . '  ' . "errors - $bol", 'errors' => Validation::$errors])->setStatusCode(Response::HTTP_REQUEST_TIMEOUT);
        }
    }

    public function store(Request $req){
        $order = new Order();
        $order->sum = $req->input('sum');
        $order->porpose = $req->input('porpose');
        $order->save();
        $hash = hash('ripemd160', 'Your order, please');
        //return redirect('/payment/paymentId=' . $hash)->with(response()->json(array('ok' => 200, 'message' => 'Order successfully added', 'paymentId' => $hash)));
        return response()->json(array('ok' => 200, 'message' => 'Order successfully added', 'paymentId' => hash('ripemd160', 'Your order, please')))->setStatusCode(Response::HTTP_CREATED);
    }



}
