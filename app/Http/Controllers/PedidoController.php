<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $user=User::find($id);
        $pedidos=Pedido::where('user_id',$id);
        return view('pedidos',['pedidos'=>$pedidos,'usuario'=>$usuario]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Pedido $pedido)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pedido $pedido)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedido $pedido)
    {
        //
    }
    public function validateOrder()
    {
        $cart=session()->get('cart');
        if(!$cart){
            return redirect()->back()->with('error', 'El carrito está vacío');
        }
        $total=0;
        $state="pending";
        foreach($cart as $line){
            $lineproduct=Product::find($line['id']);
            if($lineproduct->stock < $line['quantity']){
                return redirect()->back()->with('error', "No hay suficiente stock de: " . $lineproduct->name);
            }
            $total=$total+$line['price']*$line['quantity'];
        }
        DB::beginTransaction();
        try{
            $order= new Order();
            $order->user_id= Auth::id();
            $order->state="confirmed";
            $order->date=Carbon::now();
            $order->total=$total;
            $order->save();

            
            foreach($cart as $line){
                $lineproduct=Product::find($line['id']);
                $lineproduct->stock=$lineproduct->stock-$line['quantity'];
                $lineproduct->save();
                $actualLine= new Line();
                $actualLine->order_id=$order->id;
                $actualLine->product_id=$line['id'];
                $actualLine->amount=$line['quantity'];
                $actualLine->unitPrice=$line['price'];
                $actualLine->save();
            }
            DB::commit();
            session()->forget('cart');
            return redirect()->back()->with('success','Compra realizada!');
        }catch (\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error','Pedido cancelado!');
        }
    }

}
