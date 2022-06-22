<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\Episode;
use App\Models\Podcast;

use Carbon\Carbon;

class DownloadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1,150) as $index) {
            $episode = Episode::inRandomOrder()->first();
            $podcast = Podcast::where('id', $episode->podcast_id)->first();

            // Make date be a random day within the last 7 days.
            $day = Carbon::now()->subDays(rand(1, 7));

            DB::table('downloads')->insert([
                'type' => 'downloaded.episode',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'occurred_at' => $day,
                'podcast_id' => $podcast->id,
                'episode_id' => $episode->id,
                'id' => Str::uuid()->toString()
            ]);
        }
    }
}
