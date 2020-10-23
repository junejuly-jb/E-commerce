<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = ['item_id','seller_id','item_photo','item_name','category','item_desc','item_price','item_quantity', 'item_status'];
    protected $table = 'items';
    protected $primaryKey = 'item_id';
}
