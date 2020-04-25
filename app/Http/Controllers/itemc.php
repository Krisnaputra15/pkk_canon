<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\item;
use Auth;
use DB;
use Validator;

class itemc extends Controller
{
    public function create(request $r){
        if(Auth::user()->level == 2){
            $validator = Validator::make($r->all(),[
                'id_jenis' => 'required',
                'nama_item' => 'required',
                'harga' => 'required',
                'status' => 'required'
            ]);
            $get = DB::table('kantin')->where('id_penjual','=',Auth::user()->id)
                                      ->select('kantin.id')
                                      ->first();
            $create = item::create([
                'id_jenis' => $r->id_jenis,
                'id_kantin' => $get->id,
                'nama_item' => $r->nama_item,
                'harga' => $r->harga,
                'status' => $r->status
            ]);
            if($create){
                return response('berhasil tambahkan menu');
            }
            else{
                return response('gagal tambahkan menu');
            }
        }
        else{
            return response('anda tidak berstatus pemilik kantin');
        }
    }
    public function get(){
        if(Auth::user()->level == 2){
            $get1 = DB::table('kantin')->where('id_penjual','=',Auth::user()->id)
                                       ->select('kantin.*')
                                       ->first();
            $get2 = DB::table('item')->join('jenis_item','jenis_item.id','=','item.id_jenis')
                                     ->where('id_kantin','=',$get1->id)
                                     ->select('item.*','jenis_item.*')
                                     ->get();
            $hasil2 = array();
            foreach($get2 as $g2){
                $hasil2[] = array(
                    'nama menu' => $g2->nama_item,
                    'jenis menu' => $g2->nama_jenis,
                    'harga' => $g2->harga,
                    'status' => $g2->status
                );
            } 
            $detail_kantin[] = array(
                'nama kantin' => $get1->nama_kantin,
                'detail menu' => $hasil2
            );
            return response()->json(compact('detail_kantin'));
        }
        else{
            return response('anda tidak berstatus pemilik kantin');
        }
    }
    public function delete($id){
        $get = DB::table('kantin')->where('id_penjual','=',Auth::user()->id)
                                  ->select('kantin.id')
                                  ->first();
        if(Auth::user()->level == 2){
            $delete = DB::table('item')->where('id','=',$id,'and','id_kantin','=',$get->id)
                                       ->delete();
            if($delete){
                return response('berhasil hapus item');
            }
            else{
                return response('gagal hapus item');
            }
        }
        else{
            return response('anda bukan penjual');
        }
    }
    public function update($id,request $r){
        $get = DB::table('kantin')->where('id_penjual','=',Auth::user()->id)
                                  ->select('kantin.id')
                                  ->first();
        if(Auth::user()->level == 2){
            $update = DB::table('item')->where('id','=',$id,'and','id_kantin','=',$get->id)
                                       ->update([
                                         'nama_item' => $r->nama_item,
                                         'id_jenis' => $r->id_jenis,
                                         'harga' => $r->harga,
                                         'status' => $r->status
                                         ]);
            if($update){
                return response('berhasil update item');
            }
            else{
                return response('gagal update item');
            }
        }
        else{
            return response('anda bukan penjual');
        }
    }
}
