<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Carbon\Carbon;

use App\Models\Episode;

class DownloadsApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function setUp() : void
    {  
        parent::setUp();
        // ensure data is present to test
        $this->seed();
        $this->id = Episode::inRandomOrder()->first()->id;
    }
    
    // Test that the response is json
    public function test_check_that_api_response_is_json()
    {
        
        $this->get(route('downloads.view', ['id' => $this->id]))
            ->assertStatus(200)
            ->assertHeader('Content-Type', 'application/json');
    }

    // Test that the last 7 days are included in the data
    public function test_check_dates_are_correct()
    {
        $data = [];

        foreach (range(1, 7) as $i) {
            // Set each day initially as 0 views. Days with 0 views wont be present in the collection so this ensures the
            // 0 day downloads are represented properly.
            $data[] = Carbon::today()->subDays($i)->toDateString();
        }
       
        $this->get(route('downloads.view', ['id' => $this->id]))
        ->assertStatus(200)
        ->assertJsonStructure([
            $data[0],
            $data[1],
            $data[2],
            $data[3],
            $data[4],
            $data[5],
            $data[6]
        ]);
    }

    public function test_check_episode_id_must_exist()
    {
        $this->get(route('downloads.view', ['id' => 'complete_false_test_id']))
        ->assertJson(['response' => 'No episode exists with this id.']);
    }
}
