<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detail_transaksi extends Model
{
    protected $table = "detail_transaksi";
    protected $fillable = ['id_transaksi','id_item','qty_item','harga_total'];
    public $timestamps = false;
}
