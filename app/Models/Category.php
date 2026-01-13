<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // If your primary key is not 'id'
    protected $primaryKey = 'categoryId';

    // If your primary key is not auto-incrementing
    public $incrementing = true; // set false if not auto-incrementing

    // If your primary key is not an integer
    protected $keyType = 'int'; // change to 'string' if needed

    // Fillable fields
    protected $fillable = [
        'categoryName'
    ];

    // Optional: if your table name is not 'categories'
    // protected $table = 'your_table_name';

    // Relationships

    // A category can have many items
    public function items()
    {
        return $this->hasMany(Item::class, 'category_id', 'categoryId');
    }
}
