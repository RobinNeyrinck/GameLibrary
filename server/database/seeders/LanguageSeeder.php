<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = fopen(storage_path('app/data/csv/languages.csv'), 'r');

        fgetcsv($file);

        while (($row = fgetcsv($file)) !== false) {
            // Insert the data into the database
            DB::table('languages')->insert([
                'language' => $row[0],
                'library_title' => $row[1],
                'previous_title' => $row[2],
                'next_title' => $row[3],
                'language_title' => $row[4],
                'add_title' => $row[5],
                'edit_title' => $row[6],
                'username' => $row[7],
                'password' => $row[8],
                'register_title' => $row[9],
                'home_description' => $row[10],
                'cancel' => $row[11],
                'title' => $row[12],
                'rating' => $row[13],
                'price' => $row[14],
                'description' => $row[15],
                'tags' => $row[16],
                'tags_description' => $row[17],
                'delete' => $row[18],
                'search_title' => $row[19],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        fclose($file);
    }
}