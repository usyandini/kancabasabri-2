<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);
        $this->registerPostPolicies($gate);
        //
    }

    public function registerPostPolicies($gate)
    {

        $permissions = array();
        $unit = ["unit_0100","unit_0200","unit_0300","unit_0400","unit_0500","unit_0600",
                    "unit_0700","unit_0800","unit_0900","unit_1000","unit_1100","unit_1200",
                    "unit_1300","unit_1400","unit_1500","unit_1600","unit_1700","unit_1800",
                    "unit_1900","unit_2000","unit_2100","unit_2200","unit_2300","unit_2400",
                    "unit_2500","unit_2600","unit_2700","unit_2800","unit_2900","unit_3000",
                    "unit_3100","unit_3200","unit_3300","unit_0000","unit_0001","unit_0002","unit_0003",
                    "unit_0004","unit_0005","unit_0006","unit_0007","unit_0008","unit_0009",
                    "unit_0010","unit_0011","unit_0012","unit_0013","unit_0014","unit_0015"
                    ,"unit_0016"];

        for($i=0;$i<count($unit);$i++){
             $permissions[] = $unit[$i];
        }

        $dropping =["cari_d","lihat_tt_d","masuk_tt_d","setuju_tt_d","lihat_p_d","masuk_p_d","setuju_p_d","setuju_p2_d",
                    "notif_setuju_tt_d","notif_setuju_p_d","notif_setuju_p2_d","notif_ubah_tt_d","notif_ubah_p_d"] ;

        for($i=0;$i<count($dropping);$i++){
             $permissions[] = $dropping[$i];
        }

        $aju_dropping =["informasi_a_d","setuju_a_d",
                    "notif_setuju_a_d","notif_ubah_a_d"] ;

        for($i=0;$i<count($aju_dropping);$i++){
             $permissions[] = $aju_dropping[$i];
        }

        $transaksi = ["tambah_t","info_t","cari_t","tambah_item_t","ubah_item_t","hapus_item_t","berkas_t",
                    "simpan_t","ajukan_t","setuju_t","setuju2_t","notif_setuju_t","notif_setuju2_t",
                    "notif_ubah_t"];

        for($i=0;$i<count($transaksi);$i++){
             $permissions[] = $transaksi[$i];
        }

        $anggaran = ["info_a","cari_a","batas_a","tambah_a","tambah_item_a","ubah_item_a","hapus_item_a",
                    "berkas_item_a","kirim_a","setuju_ia","setuju_iia","setuju_iiia","setuju_iva",
                    "setuju_va","setuju_via","setuju_viia","setuju_viiia","riwayat_a","notif_setuju_ia",
                    "notif_setuju_iia","notif_setuju_iiia","notif_setuju_iva","notif_setuju_va",
                    "notif_setuju_via","notif_setuju_viia","notif_setuju_viiia","notif_setuju_ixa",
                    "notif_ubah_a"];

        for($i=0;$i<count($anggaran);$i++){
             $permissions[] = $anggaran[$i];
        }

        $manajemen_user = ["info_u","edit_u","sdelete_u","pdelete_u","restore_u","tambah_u","jenis_u",
                        "edit_jenis","tambah_jenis"];

        for($i=0;$i<count($manajemen_user);$i++){
             $permissions[] = $manajemen_user[$i];
        }

        $pelaporan = ["pelaporan_anggaran","cari_pelaporan_anggaran","tambah_pelaporan_anggaran",
                        "pelaporan_a_RUPS","cari_pelaporan_a_RUPS","tambah_pelaporan_a_RUPS",
                        "pelaporan_usulan_p_p","cari_pelaporan_usulan_p_p","tambah_pelaporan_usulan_p_p",
                        "pelaporan_tindak_lanjut","manajemen_u_k","t_l_internal","t_l_eksterenal",
                        "form_master","master_pelaporan_anggaran",
                        "cari_master_pelaporan_anggaran","tambah_master_pelaporan_anggaran",
                        "master_arahan_a_RUPS","cari_master_arahan_a_RUPS","tambah_master_arahan_a_RUPS",
                        "master_usulan_p_p","cari_master_usulan_p_p","tambah_master_usulan_p_p",
                        "notif_ajukan_p_a","notif_ajukan_a_RUPS","notif_ajukan_usulan_p_p",
                        "notif_tindak_lanjut","notif_tindak_lanjut2",
                        "notif_ajukan_master_p_a","notif_ajukan_master_a_RUPS","notif_ajukan_master_usulan_p_p"];

        for($i=0;$i<count($pelaporan);$i++){
             $permissions[] = $pelaporan[$i];
        }

        $manajemen_item = ["manajemen_k_i","manajemen_i_a","manajemen_a_m","manajemen_p_p","manajemen_a_RUPS"];

        for($i=0;$i<count($manajemen_item);$i++){
             $permissions[] = $manajemen_item[$i];
        }
        // $permissions = [
        //     'info_d', 'tarikTunai_d', 'penyesuaian_d', 'insertTT_d', 'insertPD_d', 'verifikasiTT_d', 'verifikasiPD_d', 'verifikasiPD2_d',
        //     'info_t', 'tambahBatch_t', 'verifikasi_t', 'berkas_t', 'verifikasi2_t', 'insert_t', 'update_t', 'hapus_t', 'cari_t', 'submit_t',
        //     'info_a', 'riwayat_a', 'persetujuan_a', 'persetujuan2_a',
        //     'info_u', 'tambah_u', 'jenis_u', 'tambah_jenis', 'edit_u', 'sdelete_u', 'pdelete_u', 'restore_u', 'edit_jenis'];

        foreach ($permissions as $permission) {
            \Gate::define($permission, function ($user) use ($permission) {
                return $user->hasAccess($permission);
            });
        }
    }
}
