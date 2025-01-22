<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;
    protected $fillable=[
        "nomcategorie",
        'imagecategorie',
    ];
    public function article(){
        return $this->hasMany(Article::class,"categorieID");
    }
}
