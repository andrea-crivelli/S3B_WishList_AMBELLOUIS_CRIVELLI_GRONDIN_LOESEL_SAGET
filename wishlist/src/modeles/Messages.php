<?php

namespace wishlist\modeles;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model {

    protected $table = 'message';
    protected $primaryKey = 'idMessage';
    public $timestamps=false;

    public function liste(){
        return $this->belongsTo('\wishlist\modeles\Liste','liste_id');
    }
}