<?php

use Illuminate\Database\Seeder;
use App\Models\ItemMaster;

class ItemMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	ItemMaster::truncate();
    	ItemMaster::create([
		    "kode_item" => "RUU",
		    "nama_item" => "RUPA-RUPA INVENTARIS KANTOR PUSAT",
		    "jenis_anggaran" => "T1",
		    "kelompok_anggaran" => "T2",
		    "pos_anggaran" => "T3",
		    "sub_pos" => "Barang Cetak Produksi",
		    "mata_anggaran" => "Mesin Faksimile",
		    "SEGMEN_1" => "1205011101",
		    "SEGMEN_2" => "THT",
		    "SEGMEN_3" => "07",
		    "SEGMEN_4" => "06",
		    "SEGMEN_5" => "007",
		    "SEGMEN_6" => "0007",
		    "created_by" => "1",
		  ]);

    	ItemMaster::create([
		    "kode_item" => "TES",
		    "nama_item" => "BEBAN SARANA PEMBAYARAN KLAIM",
		    "jenis_anggaran" => "T1",
		    "kelompok_anggaran" => "T2",
		    "pos_anggaran" => "T3",
		    "sub_pos" => "Biaya",
		    "mata_anggaran" => "Kebutuhan Dapur",
		    "SEGMEN_1" => "5402010121",
		    "SEGMEN_2" => "THT",
		    "SEGMEN_3" => "01",
		    "SEGMEN_4" => "00",
		    "SEGMEN_5" => "001",
		    "SEGMEN_6" => "0601",
		    "created_by" => "1",
		  ]);
    }
}
