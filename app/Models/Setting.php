<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'welcomeAsSeller', 'adBanner'];
    protected $table = 'settings';
    protected $primaryKey = 'setting_id';
    public $timestamps = false;
}