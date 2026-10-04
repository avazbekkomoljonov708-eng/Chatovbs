<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GifController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function search(Request $request)
    {
        $query = trim((string) $request->query('q', ''));
        $limit = 24;

        $apiKey = config('services.giphy.key');

        if (!$apiKey) {
            return response()->json(['gifs' => []]);
        }

        $endpoint = $query !== ''
            ? 'https://api.giphy.com/v1/gifs/search'
            : 'https://api.giphy.com/v1/gifs/trending';

        $params = [
            'api_key' => $apiKey,
            'limit'   => $limit,
            'rating'  => 'pg-13',
        ];
        if ($query !== '') {
            $params['q'] = $query;
        }

        try {
            $response = Http::timeout(8)->get($endpoint, $params);
        } catch (\Throwable $e) {
            Log::warning('GIPHY request failed: ' . $e->getMessage());
            return response()->json(['gifs' => []]);
        }

        if (!$response->successful()) {
            Log::warning('GIPHY non-success response: ' . $response->status());
            return response()->json(['gifs' => []]);
        }

        // MUHIM: Laravel 7'dagi $response->json() o'rniga xom json_decode ishlatamiz —
        // chunki json() metodi ba'zan noto'liq/bo'sh natija qaytargan.
        $decoded = json_decode($response->body(), true);
        $data = $decoded['data'] ?? [];
        if (!is_array($data)) {
            $data = [];
        }

        $gifs = collect($data)->map(function ($item) {
            if (!is_array($item) || empty($item['id'])) {
                return null;
            }
            return [
                'id'       => $item['id'],
                'preview'  => $item['images']['fixed_width']['url'] ?? ($item['images']['original']['url'] ?? null),
                'full_url' => $item['images']['original']['url'] ?? null,
                'width'    => $item['images']['fixed_width']['width'] ?? null,
                'height'   => $item['images']['fixed_width']['height'] ?? null,
            ];
        })->filter(function ($gif) {
            return $gif && !empty($gif['preview']) && !empty($gif['full_url']);
        })->values();

        return response()->json(['gifs' => $gifs]);
    }
}