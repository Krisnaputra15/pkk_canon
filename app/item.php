<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class item extends Model
{
    protected $table = "item";
    protected $fillable = ['id_jenis','id_kantin','nama_item','harga','status'];
    public $timestamps = false;
}
