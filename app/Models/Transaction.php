<?php

// app/Models/Transaction.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    // Các thuộc tính và phương thức khác

    /**
     * Mối quan hệ ngược lại với bảng products
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

