<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class VisitorModel extends Seeder
{
    public function run()
    {
        $faker = Factory::create();
        $data = [];
        for ($i=0; $i < 100; $i++) { 
            $UAString = $faker->userAgent();
            
            $data[$i] = [
                'last_counter' => $faker->date(),
                'referred' => $faker->url(),
                'agent' => getBrowserName($UAString),
                'platform' => $faker->randomElement(['Windows', 'Linux', 'MacOS']),
                'UAString' => $UAString,
                'ip' => $faker->ipv4(),
                'location' => $faker->countryCode()
            ];
        }

        $this->db->table('tb_visitors')->truncate();
        $this->db->table('tb_visitors')->insertBatch($data);
    }
}
