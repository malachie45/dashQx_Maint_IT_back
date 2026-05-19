<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\site;
use App\Models\technicien;

class mission extends Model
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
        'objet_mission','observation','dat_deb','dat_fin','id_site','id_tech'
    ];

    public function site(){

        return $this->belongTo(site::class);
    }

    public function technicien(){
        
        return $this->belongTo(technicien::class);
    }

}
