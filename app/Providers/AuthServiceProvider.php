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
        $permissions = [
            'info_d', 'tarikTunai_d', 'penyesuaian_d', 'insertTT_d', 'insertPD_d', 'verifikasiTT_d', 'verifikasiPD_d', 'verifikasiPD2_d',
            'info_t', 'tambahBatch_t', 'verifikasi_t', 'berkas_t', 'verifikasi2_t', 'insert_t', 'update_t', 'hapus_t', 'cari_t', 'submit_t',
            'info_a', 'riwayat_a', 'persetujuan_a', 'persetujuan2_a',
            'info_u', 'tambah_u', 'jenis_u', 'tambah_jenis', 'edit_u', 'sdelete_u', 'pdelete_u', 'restore_u', 'edit_jenis',
            'info_i', 'tambah_i', 'listAlasan_r', 'tambahAlasan_r','jenis_i', 'kelompok_i', 'pos_i', 'simpan_i', 'delete_i', 'edit_i', 'simpan_r', 'delete_r', 'edit_r'
            ];
        
        foreach ($permissions as $permission) {
            \Gate::define($permission, function ($user) use ($permission) {
                return $user->hasAccess($permission);
            });
        }
    }
}
