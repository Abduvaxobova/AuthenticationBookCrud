<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Author extends Model
{
    use HasFactory;

    use HasFactory;

    protected $fillable = [
        'name', 
        'email',
        'bio'
    ];
    public function books()
    {
        return $this->belongsToMany(Book::class);
    }
}