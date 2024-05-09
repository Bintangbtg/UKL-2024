<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coffe extends Model
{
    protected $table = 'coffe';
    protected $fillable = ['name', 'size', 'price', 'image'];
}