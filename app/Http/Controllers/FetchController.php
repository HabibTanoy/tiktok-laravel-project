<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class FetchController extends Controller
{
    /**
     * @throws \Exception
     */
    public function search(Request $request)
    {
        try {
            $payload = $this->prepareFirstAPICall($request->url);
        }catch (ConnectionException $exception) {
            $payload = $this->prepareSecondAPICall($request->url);
        }catch (\Exception $exception) {
            return back()->withErrors(['message' => 'Something went wrong. Try again with a valid url.']);
        }

        $resources = $this->generateAudioVideo($payload);
        return view('home',compact('resources','payload'));
    }

    public function downloadAudio(Request $request)
    {
        return response()->download($request->url);
    }

    public function downloadVideo(Request $request)
    {
        return response()->download($request->url);
    }

    private function prepareFirstAPICall($key)
    {
        $response = Http::timeout(10)->withHeaders([
            'x-rapidapi-host' => 'video-nwm.p.rapidapi.com',
            'x-rapidapi-key' => 'bfa25cc2eamshcf75fe2ef98e3afp1c23cfjsne3a6fb52723d'
        ])->get("https://video-nwm.p.rapidapi.com/url/?url=$key")->json();
        return [
            'id' => $response['item']['id'],
            'owner_avatar' => $response['item']['author']['avatarMedium'],
            'description' => $response['item']['desc'],
            'video' => $response['item']['video']['playAddr'][0]
        ];
    }
    private function prepareSecondAPICall($key)
    {
        $response = Http::withHeaders([
            'x-rapidapi-host' => 'tiktok-scrapper-downloader.p.rapidapi.com',
            'x-rapidapi-key' => 'bfa25cc2eamshcf75fe2ef98e3afp1c23cfjsne3a6fb52723d'
        ])->get("https://tiktok-scrapper-downloader.p.rapidapi.com/download?url=$key")->json();
        return [
            'id' => rand(),
            'owner_avatar' => null,
            'description' => null,
            'video' => $response['data']['downloadUrlNoWaterMark']
        ];
    }

    private function generateAudioVideo($payload)
    {
        $id = $payload['id'];
        $directory = round(microtime(true) * 1000);
        Storage::put("resources/$directory/$id.mp4",file_get_contents($payload['video'])); //Video Generation
        shell_exec("ffmpeg -i ".storage_path('app/resources/'.$directory.'/'.$id.'.mp4')." ".storage_path('app/resources/'.$directory.'/'.$id.'.mp3').""); //Audio Generation
        return [
            'video' => storage_path('app/resources/'.$directory.'/'.$id.'.mp4'),
            'audio' => storage_path('app/resources/'.$directory.'/'.$id.'.mp3')
        ];
    }
}
