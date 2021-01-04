<?php
namespace wishlist\model;
use Illuminate\Database\Eloquent\Model;

class Liste extends Model
{
    protected $table = 'liste';
    protected $primaryKey = 'no';
    public $timestamps=false;

    public function items(){
        return $this->hasMany('\wishlist\model\Item','liste_id');
    }

    public static function ListerListeSouhait(){
        $listes=Liste::all();
        foreach ($listes as $liste){
            print $liste->titre."<br>";
        }
    }


}