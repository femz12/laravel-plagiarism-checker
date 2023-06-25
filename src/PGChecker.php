<?php

namespace DavidO\PGChecker;

use DavidO\PGChecker\Services\CacheData;
use DavidO\PGChecker\Services\Copyleaks;
use Illuminate\Http\Request;

class PGChecker
{
    public static function scanText(string $content, $scanId = null)
    {
        $scanId = $scanId ?? uniqid();
        $copyleaksService = new Copyleaks($scanId);
        $copyleaksService->submitScan($content);

        return (new CacheData)->retrieveResult($scanId);
    }

    public static function submitText(string $content, $scanId = null)
    {
        $scanId = $scanId ?? uniqid();
        $copyleaksService = new Copyleaks($scanId);
        $copyleaksService->submitScan($content);

        return $scanId;
    }

    public static function retrieveResult($scanId)
    {
        return (new CacheData)->retrieveResult($scanId);
    }

    public function saveResult(Request $request, string $status)
    {
        if ($status == 'completed') {
            $info = $request->scannedDocument;
            (new CacheData)->saveResult($info['scanId'], $request->results);
        }

        return response()->json(true);
    }
}
