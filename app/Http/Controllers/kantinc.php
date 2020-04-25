<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\kantin;
use DB;
use Validator;

class kantinc extends Controller
{
    public function update($id,request $r){
        $id1 = Auth::user()->id;
        $id2 = DB::table('kantin')->where('id','=',$id)
                                  ->select('kantin.id_penjual')
                                  ->first();
        if(Auth::user()->level == 2 && $id1 == $id2->id_penjual){
            $validator = Validator::make($r->all(),[
                'nama_kantin' => 'required'
            ]);
            $update = kantin::where('id',$id)->update([
                'nama_kantin' => $r->nama_kantin
            ]);
            if($update){
                return response('berhasil update data kantin');
            }
            else{
                return response('gagal update data kantin');
            }
        }
        else{
            return response('anda harus berstatus penjual dan anda hanya bisa mengubah data kantin anda sendiri');
        }
    }
    public function get(){
        if(Auth::user()->level == 2){
            $get = DB::table('kantin')->join('petugas','petugas.id','=','kantin.id_penjual')
                                      ->where('kantin.id_penjual','=',Auth::user()->id)
                                      ->select('kantin.*','petugas.*')
                                      ->first();
            $data_kantin[] = array(
                'nama kantin' => $get->nama_kantin,
                'nama penjual' => $get->nama_petugas
            );
            return response()->json(compact('data_kantin'));
        }
        else{
            return response('anda tidak berstatus penjual');
        }
    }
    public function show($id){
        $get1 = DB::table('kantin')->where('id_penjual','=',$id)
                                   ->select('kantin.*')
                                   ->first();
        $get2 = DB::table('item')->join('jenis_item','jenis_item.id','=','item.id_jenis')
                                   ->where('id_kantin','=',$get1->id)
                                   ->select('item.*','jenis_item.*')
                                   ->get();
        $nama_kantin = array();
        foreach($get1 as $g1){
            $hasil2 = array();
            foreach($get2 as $g2){
                $hasil2[] = array(
                    'nama menu' => $g2->nama_item,
                    'jenis menu' => $g2->nama_jenis,
                    'harga' => $g2->harga,
                    'status' => $g2->status
                );
            }
        $nama_kantin[] = array(
            'nama kantin' => $g1->nama_kantin,
            'menu' => $hasil2
        );
        }
        return response()->json(compact('nama_kantin'));
    }
    public function delete($id){
        $get = DB::table('kantin')->where('kantin.id','=',$id)
                                  ->select('kantin.*')
                                  ->first();
        if(Auth::user()->level == 1){
            $delete = kantin::where('id',$id)->delete();
            if($delete){
                return response('berhasil hapus data kantin');
            }
            else{
                return response('gagal hapus data kantin');
            }
        }
        if(Auth::user()->id == $get->id_penjual){
            $delete = kantin::where('id',$id)->delete();
            if($delete){
                return response('berhasil hapus data kantin');
            }
            else{
                return response('gagal hapus data kantin');
            }
        }
        else{
            return response('anda harus berstatus admin atau anda hanya bisa menghapus kantin anda sendiri');
        }
    }
    public function create(request $r){
        $idnya = Auth::user()->id;
        $get = DB::table('kantin')->where('kantin.id_penjual','=',$idnya)
                                  ->select('kantin.id')
                                  ->first();
        if($get == null){
            $validator = Validator::make($r->all(),[
                'nama_kantin' => 'required'
            ]);
            $create = kantin::create([
                'nama_kantin' => $r->nama_kantin,
                'id_penjual' => Auth::user()->id
            ]);
            if($create){
                return response('berhasil membuat kantin');
            }
            else{
                return response('gagal membuat kantin');
            }
        }
        else{
            return response('anda sudah memiliki kantin');
        }
    }

}
