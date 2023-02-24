<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'category';
    public $incrementing = true;
    public $timestamps = true;

    public const TYPE = [
        'INCOME' => 'Pemasukan',
        'EXPENSE' => 'Pengeluaran'
    ];
}
