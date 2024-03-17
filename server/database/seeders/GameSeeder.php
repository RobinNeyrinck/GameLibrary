<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = fopen(storage_path('app/data/csv/games.csv'), 'r');

        fgetcsv($file);

        while (($row = fgetcsv($file)) !== false) {
            // Insert the data into the database
            DB::table('games')->insert([
                'title' => $row[0],
                'rating' => $row[1],
                'price' => $row[2],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        fclose($file);
    }
}
