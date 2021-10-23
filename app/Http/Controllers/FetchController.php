<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class FetchController extends Controller
{
    public function search(Request $request)
    {

    }

    public function downloadAudio()
    {

    }

    public function downloadVideo()
    {

    }

    private function prepareFirstAPICall($key)
    {
        $response = Http::withHeaders([
            'x-rapidapi-host' => 'video-nwm.p.rapidapi.com',
            'x-rapidapi-key' => 'SIGN-UP-FOR-KEY'
        ])->get("https://video-nwm.p.rapidapi.com/url/",[
            'url' => $key,
        ])->body();
        return [
            'owner_avatar' => $response->item->author->avatarMedium,
            'description' => $response->item->desc,
            'video' => $response->item->video->downloadAddr
        ];

    }
    private function prepareSecondAPICall()
    {

    }

    private function generateAudioVideo()
    {
        $directory = round(microtime(true) * 1000);
        Storage::put("$directory/video.mp4",''); //Video Generation
        shell_exec("ffmpeg -i $directory/video.mp4 -vn -acodec copy $directory/audio.mp3"); //Audio Generation

        return [
            'video' => $directory.'/video.mp4',
            'audio' => $directory.'/audio.mp3'
        ];

    }
}
