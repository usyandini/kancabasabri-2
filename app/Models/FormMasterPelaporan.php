<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\MasterItemPelaporanAnggaran;
use App\Models\MasterItemArahanRUPS;
use App\Models\ItemUsulanProgram;

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
        $unit = array();
        if($kategori == "laporan_anggaran"){
            $item = MasterItemPelaporanAnggaran::where('id_form_master',$this->id)->get();
            foreach ($item as $row) {
                array_push($unit,$row->unit_kerja);
            }
        }else if($kategori == "arahan_rups"){
            $item = MasterItemArahanRUPS::where('id_form_master',$this->id)->get();
            foreach ($item as $row) {
                array_push($unit,$row->unit_kerja);
            }
        }else if($kategori == "usulan_program"){
            $item = ItemUsulanProgram::where('id_form_master',$this->id)->get();
            foreach ($item as $row) {
                array_push($unit,$row->unit_kerja);
            }
        }

        // if($this->is_template == 1){
            // $unit_kerja = "master";
            // array_push($unit,"master");
        // }
        
        return $unit;
    }
}
