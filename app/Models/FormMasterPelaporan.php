<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\MasterItemPelaporanAnggaran;
use App\Models\MasterItemArahanRUPS;

class FormMasterPelaporan extends Model
{
    //

    protected $connection = 'sqlsrv';

    protected $table = 'form_master_pelaporan';

    protected $fillable = 
    		['tanggal_mulai', 
    		'tanggal_selesai',
    		'tw_dari', 
    		'tw_ke',
    		'kategori',
            'active',
            'is_template',
    		'id_master',
    		'created_at', 
    		'updated_at'];



    public function unit_kerja(){
        
        $kategori = $this->kategori;
        $unit="";
        if($kategori == "laporan_anggaran"){
            $item = MasterItemPelaporanAnggaran::where('id_form_master',$this->id)->get();
            foreach ($item as $row) {
                $unit = $row->unit_kerja;
            }
        }else if($kategori == "arahan_rups"){
            $item = MasterItemArahanRUPS::where('id_form_master',$this->id)->get();
            foreach ($item as $row) {
                $unit = $row->unit_kerja;
            }
        }

        if($this->is_template == 1){
            $unit_kerja = "master";
        }
        
        return $unit;
    }
}
