<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\site;
use App\Models\entree;

class eqpuipement extends Model
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
        'nom_eqpt','model','cod_sit','serial_num','id_site'
    ];

    public function site(){

        return $this->belongTo(site::class);
    }

    public function entree(){

        return $this->hasMany(entree::class, 'id_eqpt');
    }

    public function sorti(){

        return $this->hasMany(sorties::class, 'id_eqpt');
    }

}
