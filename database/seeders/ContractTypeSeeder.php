<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContractType;

class ContractTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContractType::create(
          [
            'name' => 'Fixed Term',
            'description' => 'Fixed Term Contract'
          ]
        );
        ContractType::create(
          [
            'name' => 'Temporary',
            'description' => 'Temporary Contract'
          ]
        );
        ContractType::create(
          [
            'name' => 'SSA',
            'description' => 'SSA Contract'
          ]
        );
        
    }
}
