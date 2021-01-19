<?php
namespace wishlist\modeles;
use Illuminate\Database\Eloquent\Model;

class Liste extends Model {

    protected $table = 'liste';
    protected $primaryKey = 'no';
    public $timestamps=false;

    public function items(){
        return $this->hasMany('\wishlist\modeles\Item','liste_id');
    }

    public function message(){
        return $this->hasMany('\wishlist\modeles\Messages','idListe');
    }



}