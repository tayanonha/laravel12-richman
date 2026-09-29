<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weight extends Model
{
    use HasFactory;

    // ต้องมีชื่อคอลัมน์ตรงนี้ให้ครบ Laravel ถึงจะยอมเซฟลงฐานข้อมูลให้
    protected $fillable = [
        'user_id', 
        'weight', 
        'recorded_on'
    ]; 
}