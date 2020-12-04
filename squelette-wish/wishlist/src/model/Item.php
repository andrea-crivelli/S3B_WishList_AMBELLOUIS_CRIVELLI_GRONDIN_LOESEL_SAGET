<?php


namespace wishlist\model;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'item';
    protected $primaryKey = 'id';
    public $timestamps=false;

    public function liste(){
        return $this->belongsTo('\wishlist\model\Liste','liste_id');
    }

    public static function ListerItem(){
        $items=Item::all();
        foreach ($items as $item){
            print $item->id.' '.$item->nom."<br>";
        }
    }

    public static function afficherItem(int $id){
        print (Item::select('id','nom')->where('id','=',$id)->first()."<br>");
    }
    //Club::where('id','=','12')->first();
    //Select * from club where id=12 (limit 1, premiere ligne)

    public static function creerEtAjouterItem(int $listeid, string $nom){
        $item=new Item();
        $item->liste_id=$listeid;
        $item->nom=$nom;
        $item->save();
        print ("Item ajouté<br>");
    }
}