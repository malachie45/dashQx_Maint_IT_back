<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\mission;
use App\Models\entree;

class technicien extends Model
{
    //
    protected $primarykey = 'id';
    use HasFactory;
    public $timestamp ;

    /**
     * the attributes that are mas 
     * 
     * @var array
     */
    protected $fillable = [
        'nom','pren','contact','matri','adress'
    ];


    public function mission(){
        
        return $this->hasMany(mission::class, 'id_tech');
    }

    public function entree(){
        
        return $this->hasMany(entree::class, 'id_tech');
    }
}
