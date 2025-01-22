<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LigneCommande extends Model
{
    use HasFactory;
    protected $fillable=[
        "commandeID",
        'articleID',
        'quantite',
        'montant'
    ];
    public function commande()
    {
        return $this->belongsTo(Commande::class,"commandeID");
    }
    public function article()
    {
        return $this->belongsTo(Article::class,"articleID");
    }
}
