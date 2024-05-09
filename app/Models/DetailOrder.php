<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailOrder extends Model
{
    protected $table = 'order_detail';
    protected $fillable = ['coffe_id', 'price', 'quantity', 'createdAt', 'updatedAt'];
    public $timestamps = false;

    public function orderList()
    {
        return $this->belongsTo(OrderList::class,'order_id');
    }
}