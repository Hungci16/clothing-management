<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    // Các trường có thể được gán giá trị thông qua mass assignment
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'category_id',
        'image',
        'size',
        'color',
        'product_code',
    ];

    // Định nghĩa mối quan hệ One-to-One với Transaction
    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class, 'product_id');
    }
}
