<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $fillable = ['id_barang', 'nama', 'jumlah', 'total', 'user_id'];
}