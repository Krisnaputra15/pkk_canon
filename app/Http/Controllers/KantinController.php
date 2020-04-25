<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kantin;
use Auth;
use Illuminate\Support\Facades\Validator;

class KantinController extends Controller
{
    public function show()
    {
        if(Auth::user()->level == 'admin'){
            $dt_kantin=Kantin::get();
            return Response()->json($dt_kantin);
        }else{
            return Response()->json('Anda Bukan admin');
        }
    }

    public function store(Request $req){
        if(Auth::user()->level == 'admin'){
        
        $validator = Validator::make($req->all(),
        [
            'nama_kantin'=>'required',
            'id_penjual'=>'required'
        ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $simpan = Kantin::create([
            'nama_pelanggan'=>$req->nama_pelanggan,
            'id_penjual'=>$req->id_penjual
        ]);
        if($simpan){
            return Response()->json('Data Kantin berhasil ditambahkan');
        }else{
            return Response()->json('Data Kantin gagal ditambahkan');
        }
    }else{
        return Response()->json('Anda Bukan admin');
    }
    }

    public function update($id,Request $req){
        if(Auth::user()->level == 'admin'){

        $validator = Validator::make($req->all(),
        [
            'nama_kantin'=>'required',
            'id_penjual'=>'required'
        ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $ubah = Kantin::where('id', $id)->update([
            'nama_pelanggan'=>$req->nama_pelanggan,
            'id_penjual'=>$req->id_penjual
        ]);
        if($ubah){
            return Response()->json('Data Kantin berhasil diubah');
        }else{
            return Response()->json('Data Kantin gagal diubah');
        }
    }else{
        return Response()->json('Anda Bukan admin');
    }
    }

    public function destroy($id){
        if(Auth::user()->level == 'admin'){

        $hapus = Kantin::where('id', $id)->delete();
        if($hapus){
            return Response()->json('Data Kantin berhasil dihapus');
        }else{
            return Response()->json('Data Kantin gagal dihapus');
        }
    }else{
        return Response()->json('Anda Bukan admin');
    }
    }
}
