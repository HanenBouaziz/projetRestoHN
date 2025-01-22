<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;
    protected $fillable=[
        "num",
        'prixTotal',
        'etat',
        'userID',
    ];
    public function user()
    {
        return $this->belongsTo(User::class,"userID");
    }
    public function lignesCommande(){
        return $this->hasMany(LigneCommande::class,"commandeID");
    }
}
