<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use Auth;
use Validator;
use App\transaksi;
use App\detail_transaksi;

class transaksic extends Controller
{
    //pelanggan
    public function create(request $r){
        if(Session('level') == 3){
            $validator = Validator::make($r->all(),[
                'id_kantin' => 'required',
            ]);
            $create = transaksi::create([
                'id_pelanggan' => Session('id'),
                'id_kantin' => $r->id_kantin,
                'tgl_transaksi' => date('Y-m-d H:i:s'),
                'status' => "Unconfirmed, Paid"
            ]);
            $info = "Anda berhasil membuat transaksi";
            return response()->json(compact('info'));
        }
        else{
            return response('anda harus berstatus pembeli untuk membeli menu');
        }
    }
    public function additem(request $r){
        $get = DB::table('transaksi')->where('id','=',$r->id_transaksi)
                                    ->select('transaksi.*')
                                    ->first();
        if($get->id_pelanggan == Session('id') && $get->status = "Uncorfimed, Paid"){
            $get2 = DB::table('item')->where('id_kantin','=',$r->id_kantin,'and','id','=',$r->id_item)
                                 ->select('item.harga')
                                 ->first();
            $hargatotal = $get2->harga * $r->qty_item;
            $create2 = detail_transaksi::create([
                    'id_transaksi' => $r->id_transaksi,
                    'id_item' => $r->id_item,
                    'qty_item' => $r->qty_item,
                    'harga_total' => $hargatotal
            ]);
            if($create2){
                return response('berhasil tambah detail transaksi');
            }
            else{
                return response('gagal tambah detail transaksi');
            }
        }
        else{
            return response('anda hanya bisa menambah transaksi milik anda sendiri dan yang belum dikonfirmasi');
        }
        
    }
    public function show(request $r){
     if(Session('level') == 3){
        $g1 = DB::table('transaksi')->join('kantin','kantin.id','=','transaksi.id_kantin')
                                    ->join('pelanggan','pelanggan.id','=','transaksi.id_pelanggan')
                                    ->where('transaksi.id_pelanggan','=',Session('id'))
                                    ->where('transaksi.status','like','%Unconfirmed, Paid%')
                                    ->select('transaksi.id','kantin.nama_kantin','pelanggan.nama_pelanggan','transaksi.status')
                                    ->get();
        
        $data_transaksi = array();
        foreach($g1 as $g1){
            $g2 = DB::table('detail_transaksi')->join('item','item.id','=','detail_transaksi.id_item')
                                             ->where('detail_transaksi.id_transaksi','=',$g1->id)
                                             ->select('detail_transaksi.*','item.*')
                                             ->get();
            $hasil2 = array();
            $grand = DB::table('detail_transaksi')->where('id_transaksi','=',$g1->id)
                                                  ->groupBy('id_transaksi')
                                                  ->select(DB::raw('sum(harga_total) as grandt'))
                                                  ->first();
            foreach($g2 as $g2){
                $hasil2[] = array(
                    'nama menu' => $g2->nama_item,
                    'harga' => $g2->harga,
                    'jumlah pemesanan' => ''.$g2->qty_item.' porsi'
                );
            }
            $data_transaksi[] = array(
                'id transaksi' => $g1->id,
                'nama pelanggan' => $g1->nama_pelanggan,
                'nama kantin' => $g1->nama_kantin,
                'total bayar' => $grand->grandt,
                'status' => $g1->status,
                'detail' => $hasil2
            );
        }
        return response()->json(compact('data_transaksi'));
     }
     else{
         return response('anda bukan pembeli');
     }
    }
    //petugas
    public function confirmation($id){
        if(Auth::user()->level == 2){
            $satu = DB::table('transaksi')->where('transaksi.id','=',$id)
                                          ->select('transaksi.id_kantin')
                                          ->first();
            $dua = DB::table('kantin')->where('kantin.id','=',$satu->id_kantin)
                                        ->select('kantin.id_penjual')
                                        ->first();
            if($dua->id_penjual == Auth::user()->id){
                $confirm = transaksi::where('id',$id)->update([
                'status' => "confirmed, paid"
                ]);
                if($confirm){
                    return response("Transaksi telah dikonfirmasi");
                }
                else{
                    return response("Transaksi gagal dikonfirmasi");
                }
            }
            else{
                return response('ini bukan kantin anda');
            }
        }
        else{
            return response('anda bukan pemilik kantin');
        }
    }
}
