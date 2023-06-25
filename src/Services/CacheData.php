<?php

namespace DavidO\PGChecker\Services;

use Illuminate\Support\Facades\Cache;

class CacheData
{
    public function retrieveResult($scanId)
    {
        $start = time();

        do {
            $results = Cache::get($scanId);
            sleep(5);
        } while ($results == null && (time() - $start) < 60); // Stop the loop after 1 minute (60 seconds)

        return response()->json($results);
    }

    public function saveResult($scanId, $result)
    {
        Cache::put($scanId, $result, 3600);
    }
}
