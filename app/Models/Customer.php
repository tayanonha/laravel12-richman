<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    // เพิ่ม user_id เข้าไปใน array
    protected $fillable = ['user_id', 'name', 'email', 'phone', 'purchase_history'];

    // ผูกความสัมพันธ์ว่า ลูกค้านี้เป็นของ User คนไหน
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}