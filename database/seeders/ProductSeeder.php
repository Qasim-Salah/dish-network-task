<?php

namespace Database\Seeders;

use App\Models\Product as ProductModel;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{

    public function run()
    {
         ProductModel::factory(20)->create();
    }
}
