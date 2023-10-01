<?php

namespace DavidO\PGChecker\Services;

use Illuminate\Support\Facades\Cache;

class CacheData
{
    public function retrieveResult($scanId)
    {
        $start = time();

        do {
            $results = Cache::get("result-{$scanId}");
            sleep(5);
        } while ($results == null && (time() - $start) < 60); // Stop the loop after 1 minute (60 seconds)

        return response()->json($results);
    }

    public function saveResult($scanId, $result)
    {
        Cache::put("result-{$scanId}", $result, 3600);
    }

    public function retrieveToken($scanId)
    {
        return Cache::get("token-{$scanId}");
    }

    public function saveToken($scanId, $token)
    {
        Cache::put("token-{$scanId}", $token, 3600);
        return $token;
    }
}
