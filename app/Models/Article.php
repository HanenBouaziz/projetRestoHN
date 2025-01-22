<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $fillable=[
        "nomarticle",
        'imagearticle',
        'prix',
        'categorieID'
    ];
    public function categorie()
    {
        return $this->belongsTo(Categorie::class,"categorieID");
    }
}
