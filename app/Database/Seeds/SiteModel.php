<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Ramsey\Uuid\Uuid;

class SiteModel extends Seeder
{
    public function run()
    {
        $data = [
            'site_id'    => Uuid::uuid4()->toString(),
            'site_name'  => 'Big Data BPS',
            'site_name_alt' => 'BPS',
            'site_description'  => 'Repositori Big Data Badan Pusat Statistik',
            'site_author' => 'Muhammad Ridwan Na\'im',
            'site_logo' => 'logo.png',
            'info_adm' => '{"no_surat_dinas":"http:\/\/s.bps.go.id\/surat2025_3671","no_sk_kpa":"http:\/\/s.bps.go.id\/SK2025_3671","laporan_keuangan":"files\/TPL0462_PERTEMUAN%20KE-8_HUBUNGAN%20METODE%20DUAL%20SIMPLEKS%20DAN%20PRIMAL%20DUAL.pdf","monitoring_kegiatan":"https:\/\/s.bps.go.id\/monitoringkegiatan3671"}',
            'pedoman_adm_keuangan' => '{"file_pok":"files\/POK%20Revisi%20Satker%20IV_23%20Mei.pdf","file_pak":"files\/TPL0462_PERTEMUAN%20KE-8_HUBUNGAN%20METODE%20DUAL%20SIMPLEKS%20DAN%20PRIMAL%20DUAL.pdf","file_peraturan":"files\/228424115.pdf"}',
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->table('tb_site_settings')->truncate();
        $this->db->table('tb_site_settings')->insert($data);
    }
}
