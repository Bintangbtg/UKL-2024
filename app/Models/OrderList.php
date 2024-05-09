<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderList extends Model
{
    protected $table = 'order_list';

    protected $fillable = ['customer_name', 'order_type', 'order_date', 'createdAt', 'updatedAt'];

    public $timestamps = false;

    public function detailOrders()
    {
        return $this->hasMany(DetailOrder::class,'order_id');
    }
}