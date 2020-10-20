<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    use HasFactory;
    protected $fillable = ['admin_id', 'log'];
    protected $table = 'logs';
    protected $primaryKey = 'log_id';
}
