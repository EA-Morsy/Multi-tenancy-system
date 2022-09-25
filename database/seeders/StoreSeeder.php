<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $values=[[
            'name'=>'isupply'
        ],
        [
            'name'=>'pharmatix',
        ],
        [
            'name'=>'cosmatix'
        ]
        ];
        Store::insert($values);
    }
}
