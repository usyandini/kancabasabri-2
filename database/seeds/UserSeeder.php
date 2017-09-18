<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// User::truncate();
    	// User::create(['name' => 'Ilyas Habiburrahman', 'email' => 'ilyashabiburrahman@gmail.com', 'password' => bcrypt('rahasia'), 'is_admin' => 1]);
     //    User::create(['name' => 'Rezqi', 'email' => 'rezqi@gmail.com', 'password' => bcrypt('rahasia'), 'is_admin' => 1, 'username' => 'rezqi']);
     //    User::create(['name' => 'Jeanni', 'email' => 'jeanni@gmail.com', 'password' => bcrypt('rahasia')]);
     //    User::create(['name' => 'Faisal', 'email' => 'faisal@gmail.com', 'password' => bcrypt('rahasia')]);
     //    User::create(['name' => 'Administrator', 'email' => 'admin@gmail.com', 'password' => bcrypt('rahasia'), 'is_admin' => 1]);
     //    User::create(['name' => 'Admin', 'email' => 'admin@admin.com', 'password' => bcrypt('admin123')]);
        User::create([
            'name' => 'Superadmin',
            'username' => 'superadmin', 
            'email' => 'admin@gmail.com',
            'password' => bcrypt('rahasia'),
            'perizinan' => [
                "data-cabang" => "off",
                "verifikasi-notif" => "on",
                "verifikasi2-notif" => "on",
                "update-notif" => "on",
                "info_t" => "on",
                "tambahBatch_t" => "on",
                "verifikasi_t" => "on",
                "verifikasi2_t" => "on",
                "insert_t" => "on",
                "update_t" => "on",
                "berkas_t" => "on",
                "hapus_t" => "on",
                "cari_t" => "on",
                "submit_t" => "on",
                "info_a" => "on",
                "riwayat_a" => "on",
                "persetujuan_a" => "on",
                "persetujuan2_a" => "on",
                "info_u" => "on",
                "tambah_u" => "on",
                "jenis_u" => "on",
                "tambah_jenis" => "on",
                "edit_u" => "on",
                "sdelete_u" => "on",
                "pdelete_u" => "on",
                "restore_u" => "on",
                "edit_jenis" => "on" ] 
            ]);
    }
}
