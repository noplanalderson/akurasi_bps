<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Ramsey\Uuid\Uuid;

class OrgModel extends Seeder
{
    public function run()
    {
        $data = [
            'org_id'    => Uuid::uuid4()->toString(),
            'org_name'  => 'Badan Pusat Statistik',
            'org_profile'  => 'Badan Pusat Statistik adalah Lembaga Pemerintah Nonkementerian yang bertanggung jawab langsung kepada Presiden. Sebelumnya, BPS merupakan Biro Pusat Statistik, yang dibentuk berdasarkan UU Nomor 6 Tahun 1960 tentang Sensus dan UU Nomor 7 Tahun 1960 tentang Statistik.',
            'org_vision' => 'Penyedia Data Statistik Berkualitas untuk Indonesia Maju',
            'org_missions' => '<ol><li>Menyediakan statistik berkualitas yang berstandar nasional dan internasional</li><li>Membina K/L/D/I melalui Sistem Statistik Nasional yang berkesinambungan</li><li>Mewujudkan pelayanan prima di bidang statistik untuk terwujudnya Sistem Statistik Nasional</li><li>Membangun SDM yang unggul dan adaptif berlandaskan nilai profesionalisme, integritas dan amanah</li></ol>',
            'org_slogan' => '-',
            'org_address' => 'Gedung 2 Lantai 1 (Kepala Biro Humas dan Hukum Badan Pusat Statistik) Jln. Dr. Sutomo 6-8, Jakarta Pusat 10710',
            'org_phone' => '(021) 3857046',
            'org_social_media' => json_encode([
                'facebook' => 'https://www.facebook.com/bpsstatistics',
                'twitter' => 'https://twitter.com/bps_statistic',
                'instagram' => 'https://www.instagram.com/bps_statistics/',
                'youtube' => 'https://www.youtube.com/c/bpsstatistics/',
                'email' => 'ppid@bps.go.id'
            ]),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->table('tb_org_settings')->truncate();
        $this->db->table('tb_org_settings')->insert($data);
    }
}
