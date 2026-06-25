<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\entree;

class typetraitement extends Model
{
    //
    /**
     * the attributes that are mas 
     * 
     * @var array
     */
    protected $fillable = [
        'typ_trait'
    ];


    public function entrees(){
        
        return $this->hasMany(entree::class, 'id_typtrait');
    }
}
