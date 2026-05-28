<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $total = 1000000; // total rows to insert
        $batch = 1000;   // insert per loop (tune this based on your server)

        // Try to detect max category id if categories table exists
        $maxCategory = DB::table('categories')->max('id') ?? 1;

        $loops = (int) ceil($total / $batch);

        for ($i = 0; $i < $loops; $i++) {
            $products = [];

            // generate batch data
            for ($j = 0; $j < $batch && ($i * $batch + $j) < $total; $j++) {
                $products[] = [
                    'product_code' => 'SP' . (string)$i . (string)$j . time(),
                    'product_name' => $faker->words(3, true),
                    'price' => $faker->numberBetween(100000, 500000),
                    'category_id' => $maxCategory ? random_int(1, $maxCategory) : null,
                    'state' => 'active',
                    'quantity' => $faker->numberBetween(1, 100),
                    'details' => $faker->sentence(),
                    'image' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // raw insert is much faster and uses far less memory than creating Eloquent models
            DB::table('products')->insert($products);

            $inserted = min(($i + 1) * $batch, $total);
            echo "Inserted: {$inserted}\n";
        }
    }
}