<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;

use Carbon\Carbon;

use Tests\TestCase;

class EventApiTest extends TestCase
{
    use WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_create_download()
    {
        // Test that when the api receives a post request with correct data, the download data is
        // stored in the database.
        $data = [
            'type' => 'episode.downloaded',
            'event_id' => Str::uuid()->toString(),
            'occurred_at' => Carbon::now(),
            'data' => [
                'episode_id' => Str::uuid()->toString(),
                'podcast_id' => Str::uuid()->toString()
            ]
        ];

        $this->post(route('downloads.store'),$data)
            ->assertStatus(200);
    }
}
