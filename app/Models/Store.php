<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = ['store_name', 'store_owner', 'store_address', 'store_website', 'store_description', 'store_status'];
    protected $table = 'stores';
    protected $primaryKey = 'store_id';
}
