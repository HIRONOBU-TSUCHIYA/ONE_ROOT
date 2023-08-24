<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Validator;  //この1行だけ追加！

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          $orders = Order::orderBy('created_at', 'asc')->paginate(3);
    return view('orders', [
        'orders' => $orders
    ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            //バリデーション
    $validator = Validator::make($request->all(), [
         'driver_name' => 'required|min:1|max:255',
         'car_number' => 'required | min:1 | max:255',
         'item' => 'required|min:1|max:255',
         'published'   => 'required',
    ]);

    //バリデーション:エラー 
    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }
    //以下に登録処理を記述（Eloquentモデル）

  // Eloquentモデル
  $orders = new Order;
  $orders->driver_name   = $request->driver_name;
  $orders->car_number = $request->car_number;
  $orders->item = $request->item;
  $orders->published   = $request->published;
  $orders->save(); 
  return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //{books}id 値を取得 => Book $books id 値の1レコード取得
        return view('ordersedit', ['order' => $order]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), [
         'driver_name' => 'required|min:1|max:255',
         'car_number' => 'required | min:1 | max:255',
         'item' => 'required|min:1|max:255',
         'published'   => 'required',
    ]);

    //バリデーション:エラー 
    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }
    //以下に登録処理を記述（Eloquentモデル）

  // データ更新
  $orders = Order::find($request->id);
  $orders->driver_name   = $request->driver_name;
  $orders->car_number = $request->car_number;
  $orders->item = $request->item;
  $orders->published   = $request->published;
  $orders->save(); 
  return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();       //追加
        return redirect('/');  //追加
    }
}
