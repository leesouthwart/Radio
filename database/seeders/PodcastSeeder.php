<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


class PodcastSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        foreach (range(1,15) as $index) {
            DB::table('podcasts')->insert([
                'title' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'podcast_uuid' => Str::uuid()->toString()
            ]);
        }   
        
    }
}
