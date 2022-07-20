<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;
    protected $table = 'income';
    public $incrementing = true;
    public $timestamps = true;

    // Relation to Category
    public function Category()
    {
        return $this->hasOne('App\Models\Category', 'id', 'id_category');
    }
}
