<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Download;

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

        $download = new Download;
        $download->type = $request->type;
        $download->id = $request->event_id;
        $download->occurred_at = $request->occurred_at;
        $download->episode_id = $request->data['episode_id'];
        $download->podcast_id = $request->data['podcast_id'];

        $download->save();

        return;
    }
}
