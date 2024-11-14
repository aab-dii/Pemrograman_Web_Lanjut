<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    // Specify the table name if it doesn't follow the default convention
    protected $table = 'transactions';

    // Specify the attributes that are mass assignable
    protected $fillable = [
        'product_id',
        'transaction_type',
        'quantity',
        'date',
        'user_id',
    ];

    // Define relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

// class Transaction extends Model
// {
//     //
// }
