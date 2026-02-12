<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CarritoController extends Controller
{


    public function all()
    {
        $cart=session()->get('carrito');
        return view('carrito',['carro'=>$cart]);
    }

    public function add(Request $request,$id)
    {
        $producto=Product::find($id);
        $carrito= session()->get('cart',[]);

        if(isset($carrito[$id])){
            $carrito[$id]['quantity']++;
        }else{
            $carrito[$id]=[
                'id'=>$producto->id,
                'name'=>$producto->name,
                'quantity'=>1,
                'price'=>$producto->price
            ];
        }
        session()->put('cart',$carrito);
        return redirect()->back();
    }

    public function deleteOne($id){
        $carrito=session()->get('cart');
        if(isset($carrito[$id])){
            $carrito[$id]['quantity']--;
            if($carrito[$id]['quantity']<=0){
                unset($carrito[$id]);
            } 
            session()->put('cart',$carrito);
        }
        return redirect()->back();
    }

    public function deleteAll()
    {
        $carrito=session()->get('cart',[]);
        session()->forget('cart');
        return redirect()->back();
    }
}