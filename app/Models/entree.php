<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\site;
use App\Models\eqpuipement;
use App\Models\typetraitement;
use App\Models\technicien;

class entree extends Model
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
        'model','date_entree','date_deb_trait','cod_sit','serial_num','motif','statut','image','id_site','id_eqpt','id_tech','id_typtrait'
    ];

    public function site(){
        
        return $this->belongTo(site::class);
    }

    public function equipement(){
        
        return $this->belongTo(eqpuipement::class);
    }

    public function technicien(){
        
        return $this->belongTo(technicien::class);
    }

    public function typetraitement(){
        
        return $this->belongTo(typetraitement::class);
    }
}
