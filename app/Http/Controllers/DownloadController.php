<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Models\Download;

use Carbon\Carbon;

class DownloadController extends Controller
{
    //
    public function store(Request $request) 
    {
        
        $validatedData = $request->validate([
            'type' => 'required',
            'event_id' => ['required', 'uuid'],
            'occurred_at' => ['required', 'date'],
            'data.episode_id' => ['required', 'uuid'],
            'data.podcast_id' => ['required', 'uuid']
        ]);

        $request = $request->json()->all();

        if ($request['type'] == 'episode.downloaded') {
            $download = new Download;
            $download->type = $request['type'];
            $download->id = $request['event_id'];
            $download->occurred_at = $request['occurred_at'];
            $download->episode_id = $request['data']['episode_id'];
            $download->podcast_id = $request['data']['podcast_id'];
            $download->save();
        } else {
            // For now we only want to save downloads with the correct type.
            return response()->json(['message' => 'Event Type was not the expected type.'], 500);
        }
        return;
    }

    public function view_downloads_data($id)
    {
        // Get downloads for a specific ID, grouped by day and counted.
        $downloads = Download::where('episode_id', $id)->whereDate('occurred_at', '>=', Carbon::today()->subDays(7))
        ->select(DB::raw('DATE(occurred_at) as occurred_at_date'), DB::raw('count(*) as downloads'))
        ->groupBy('occurred_at')
        ->get();
        
        $data = [];

        foreach (range(1, 7) as $i) {
            // Set each day initially as 0 views. Days with 0 views wont be present in the collection so this ensures the
            // 0 day downloads are represented properly.
            $data[Carbon::today()->subDays($i)->toDateString()] = 0;
        }
        
        // Loop the downloads and assign the count values to the correct days
        foreach($downloads as $d) {
            $data[$d->occurred_at_date] = $d->downloads;
        }
        
        //return json_encode($data);
        return Response::json($data, 200, array('Content-Type' => 'application/json'), JSON_UNESCAPED_UNICODE);
    }
}
