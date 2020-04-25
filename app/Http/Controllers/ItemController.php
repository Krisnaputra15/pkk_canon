<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use Auth;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    public function show()
    {
        if(Auth::user()->level == 'admin'){
            $dt_item=Item::get();
            return Response()->json($dt_item);
        }else{
            return Response()->json('Anda Bukan admin');
        }
    }

    public function store(Request $req){
        if(Auth::user()->level == 'admin'){
        
        $validator = Validator::make($req->all(),
        [
            'id_kantin'=>'required',
            'nama_item'=>'required',
            'jenis_item'=>'required',
            'harga'=>'required',
            'stock'=>'required'
        ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $simpan = Item::create([
            'id_kantin'=>$req->id_kantin,
            'nama_item'=>$req->nama_item,
            'jenis_item'=>$req->jenis_item,
            'harga'=>$req->harga,
            'stock'=>$req->stock
            
        ]);
        if($simpan){
            return Response()->json('Data Item berhasil ditambahkan');
        }else{
            return Response()->json('Data Item gagal ditambahkan');
        }
    }else{
        return Response()->json('Anda Bukan admin');
    }
    }

    public function update($id,Request $req){
        if(Auth::user()->level == 'admin'){

        $validator = Validator::make($req->all(),
        [
            'id_kantin'=>'required',
            'nama_item'=>'required',
            'jenis_item'=>'required',
            'harga'=>'required',
            'stock'=>'required'
        ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $ubah = Item::where('id', $id)->update([
            'id_kantin'=>$req->id_kantin,
            'nama_item'=>$req->nama_item,
            'jenis_item'=>$req->jenis_item,
            'harga'=>$req->harga,
            'stock'=>$req->stock
            
        ]);
        if($ubah){
            return Response()->json('Data Item berhasil diubah');
        }else{
            return Response()->json('Data Item gagal diubah');
        }
    }else{
        return Response()->json('Anda Bukan admin');
    }
    }

    public function destroy($id){
        if(Auth::user()->level == 'admin'){

        $hapus = Item::where('id', $id)->delete();
        if($hapus){
            return Response()->json('Data Item berhasil dihapus');
        }else{
            return Response()->json('Data Item gagal dihapus');
        }
    }else{
        return Response()->json('Anda Bukan admin');
    }
    }
}
