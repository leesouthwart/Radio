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

    public function setUp() : void
        {  
            parent::setUp();
            $this->data = [
                'type' => 'episode.downloaded',
                'event_id' => Str::uuid()->toString(),
                'occurred_at' => Carbon::now(),
                'data' => [
                    'episode_id' => Str::uuid()->toString(),
                    'podcast_id' => Str::uuid()->toString()
                ]
            ];
        }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_create_download()
    {
        // Test that when the api receives a post request with correct data, the download data is
        // stored in the database.

        $this->post(route('downloads.store'),$this->data)
            ->assertStatus(200);
    }
    public function test_wrong_format_event_id_throws_302()
    {
        $dataBadFormat = $this->data;
        $dataBadFormat['event_id'] = 12345;

        $this->post(route('downloads.store'), $dataBadFormat)
            ->assertStatus(302);
    }

    public function test_wrong_format_episode_id_throws_302()
    {
        $dataBadFormat = $this->data;
        $dataBadFormat['data']['episode_id'] = 12345;

        $this->post(route('downloads.store'), $dataBadFormat)
            ->assertStatus(302);
    }

    public function test_wrong_format_podcast_id_throws_302()
    {
        $dataBadFormat = $this->data;
        $dataBadFormat['data']['podcast_id'] = 12345;

        $this->post(route('downloads.store'), $dataBadFormat)
            ->assertStatus(302);
    }
}
