<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LigneMenu extends Model
{
    use HasFactory;
    protected $fillable=[
        "menuID",
        'articleID',
    ];
    public function menu()
    {
        return $this->belongsTo(Menu::class,"menuID");
    }
    public function article()
    {
        return $this->belongsTo(Article::class,"articleID");
    }
}
