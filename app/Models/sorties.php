<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\site;
use App\Models\technicien;

class sorties extends Model
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
        'model','sit','eqpt','date_sorti','date_fin_trait','cod_sit','serial_num','observ','statut','image','id_site'
    ];


    public function site(){

        return $this->belongTo(site::class);
    }

    public function equipement(){
        
        return $this->belongTo(eqpuipement::class);
    }


}
