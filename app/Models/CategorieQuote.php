<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategorieQuote extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'category_id',
        'quote_id',
    ];
}
