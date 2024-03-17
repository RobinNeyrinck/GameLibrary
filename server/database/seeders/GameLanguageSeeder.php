<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GameLanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = fopen(storage_path('app/data/csv/gamelanguages.csv'), 'r');

        fgetcsv($file);

        while (($row = fgetcsv($file)) !== false) {
            $tags = explode(',', $row[3]);
            DB::table('games_languages')->insert([
                'game_id' => $row[0],
                'language' => $row[1],
                'description' => $row[2],
                'tags' => json_encode($tags),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        fclose($file);
    }
}
