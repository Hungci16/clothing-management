<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Transaction extends Model
{
    use HasFactory;

    // Quan hệ một-một (mỗi Transaction thuộc về một Product)
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Quan hệ nhiều-nhiều (một Transaction có thể có nhiều Products)
    public function products(): BelongsToMany
{
    return $this->belongsToMany(Product::class, 'custom_pivot_table_name');
}

}    
