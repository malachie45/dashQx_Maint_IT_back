<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\site;
use App\Models\eqpuipement;

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
        'model','date_entree','date_deb_trait','cod_sit','serial_num','motif','statut','image','id_site','id_eqpt'
    ];

    public function site(){
        
        return $this->belongTo(site::class);
    }

    public function equipement(){
        
        return $this->belongTo(eqpuipement::class);
    }
}
