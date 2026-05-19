<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\entree;
use App\Models\mission;
use App\Models\equipement;
use App\Models\sorties;

class site extends Model
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
        'nom_site','adress','contact','chef_agce'
    ];


     public function entree(){
        
        return $this->hasMany(entree::class, 'id_site');
    }

    public function equipement(){
        
        return $this->hasMany(eqpuipement::class, 'id_site');
    }

    public function mission(){
        
        return $this->hasMany(mission::class, 'id_site');
    }

    public function sorties(){
        
        return $this->hasMany(sorties::class, 'id_site');
    }
    
}
