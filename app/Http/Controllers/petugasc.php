<?php

namespace App\Http\Controllers;

use App\User;
use App\Kantin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Session;
use Auth;
use DB;

class petugasc extends Controller
{
    public function register(request $r){
    if($r->level == 2){
        $validator = Validator::make($r->all(), [
            'nama_petugas' => 'required',
            'username' => 'required',
            'password' => 'required',
            'level' => 'required',
            'nama_kantin' => 'required'
        ]);
        $regpet = User::create([
            'nama_petugas' => $r->nama_petugas,
            'username' => $r->username,
            'password' => Hash::make($r->password),
            'level' => $r->level,
        ]);
        $id = DB::table('petugas')->where('nama_petugas','=',$r->nama_petugas,'and','username','=',$r->username,
                                          'and','level','=',$r->level)
                                  ->select('petugas.id')
                                  ->first();
        $kantin = Kantin::create([
            'nama_kantin' => $r->nama_kantin,
            'id_penjual' =>$id->id
        ]);
        $token = JWTAuth::fromUser($regpet);
        if($kantin && $regpet){
            $status = 'berhasil daftar penjual';
            return response()->json(compact('status','token'));
        }
        else{
            return response('gagal daftar penjual');
        }
    }
    else{
        $validator = Validator::make($r->all(), [
            'nama_petugas' => 'required',
            'username' => 'required',
            'password' => 'required',
            'level' => 'required',
        ]);
        $regpet = User::create([
            'nama_petugas' => $r->nama_petugas,
            'username' => $r->username,
            'password' => Hash::make($r->password),
            'level' => $r->level,
        ]);
        $token = JWTAuth::fromUser($regpet);
        if($regpet){
            $status = 'berhasil daftar penjual';
            return response()->json(compact('status','token'));
        }
        else{
            return response('gagal daftar penjual');
        }
    }
    }
    public function login(request $r){
        $credentials = $r->only('username', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }
    public function update(request $r,$id){
        $validator = Validator::make($r->all(), [
            'nama_petugas' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);
        $regpet = User::where('id',$id)->update([
            'nama_petugas' => $r->nama_petugas,
            'username' => $r->username,
            'password' => Hash::make($r->password),
        ]);
        if($regpet){
            $status = 'berhasil update penjual';
            return response()->json(compact('status'));
        }
        else{
            return response('gagal update penjual');
        }
    }
}
