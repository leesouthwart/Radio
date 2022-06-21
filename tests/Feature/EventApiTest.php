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
                'occurred_at' => Carbon::now()->toDateString(),
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
        
        $this->postJson(route('downloads.store'),$this->data)
            ->assertStatus(200);
    }
    public function test_wrong_format_event_id_throws_302()
    {
        // A non uuid format event_id should throw 302 error due to the validate function.
        $dataBadFormat = $this->data;
        $dataBadFormat['event_id'] = 12345;

        $this->postJson(route('downloads.store'), $dataBadFormat)
            ->assertStatus(422);
    }

    public function test_wrong_format_episode_id_throws_302()
    {
        // A non uuid format episode_id should throw 302 error due to the validate function.
        $dataBadFormat = $this->data;
        $dataBadFormat['data']['episode_id'] = 12345;

        $this->postJson(route('downloads.store'), $dataBadFormat)
            ->assertStatus(422);
    }

    public function test_wrong_format_podcast_id_throws_302()
    {
        // A non uuid format podcast_id should throw 302 error due to the validate function.
        $dataBadFormat = $this->data;
        $dataBadFormat['data']['podcast_id'] = 12345;

        $this->postJson(route('downloads.store'), $dataBadFormat)
            ->assertStatus(422);
    }

    // Check that the event type is 'episode.downloaded', if not, handler should throw an exception.
    public function test_event_type_must_be_episode_downloaded()
    {
        $dataBadFormat = $this->data;
        $dataBadFormat['type'] = 'Not episode.downloaded';
        
        $this->postJson(route('downloads.store'), $dataBadFormat)
            ->assertJson(['message' => 'Event Type was not the expected type.'], $strict = false);
    }
}
