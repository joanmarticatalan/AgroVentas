<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class CarritoController extends Controller
{


    public function all()
    {
        $cart=session()->get('carrito');
        return view('carrito',['carro'=>$cart]);
    }

    public function add(Request $request,$id)
    {
        $producto=Producto::find($id);
        $carrito= session()->get('carrito',[]);

        if(isset($carrito[$id])){
            $carrito[$id]['quantity']++;
        }else{
            $carrito[$id]=[
                'id'=>$producto->id,
                'name'=>$producto->nombre,
                'quantity'=>1,
                'price'=>$producto->precio
            ];
        }
        session()->put('carrito',$carrito);
        return redirect()->back();
    }

    public function deleteOne($id){
        $carrito=session()->get('carrito');
        if(isset($carrito[$id])){
            $carrito[$id]['quantity']--;
            if($carrito[$id]['quantity']<=0){
                unset($carrito[$id]);
            } 
            session()->put('carrito',$carrito);
        }
        return redirect()->back();
    }

    public function deleteAll()
    {
        $carrito=session()->get('carrito',[]);
        session()->forget('carrito');
        return redirect()->back();
    }
}