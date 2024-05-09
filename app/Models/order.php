<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;
    protected $table = 'order_list';
    public $fillable=["customer_name","order_type","order_date"];
    public $timestamps=false;
}