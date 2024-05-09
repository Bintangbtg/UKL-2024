<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order_detail extends Model
{
    use HasFactory;
    protected $table = 'order_detail';
    public $fillable=['order_id','coffe_id','quantity','price'];
    public $timestamps=false;
}
