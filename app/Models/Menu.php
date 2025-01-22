<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $fillable=[
        "nommenu",
    ];
    public function lignesMenu(){
        return $this->hasMany(LigneMenu::class,"menuID");
    }
}
