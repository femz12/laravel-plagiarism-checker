<?php

namespace DavidO\PGChecker\Services;

use GuzzleHttp\Client;

class Copyleaks
{
    protected $client;

    protected $apiKey;

    protected $isSandbox;

    protected $apiEmail;

    protected $webhookBase;

    protected $scanId;

    public function __construct($scanId)
    {
        $this->client = new Client([
            'base_uri' => 'https://api.copyleaks.com/v3/',
        ]);

        $this->apiKey = config('copyleaks.key');
        $this->apiEmail = config('copyleaks.email');
        $this->isSandbox = config('copyleaks.sandbox');
        $this->webhookBase = config('copyleaks.webhookBase');
        $this->scanId = $scanId;

    }

    public function authenticate()
    {
        $authClient = new Client([
            'base_uri' => 'https://id.copyleaks.com/v3/',
        ]);

        $response = $authClient->post('account/login/api', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'key' => $this->apiKey,
                'email' => $this->apiEmail,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    public function submitFileForScan($scanId, $fileData, $action = 0, $includeHtml = true)
    {
        $webhook = $this->webhookBase ? "{$this->webhookBase}/api/plagiarism/webhook/{STATUS}" : url('/api/plagiarism/webhook/{STATUS}');
        $response = $this->client->put("scans/submit/file/{$scanId}", [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$this->authenticate()['access_token'],
            ],
            'json' => [
                'base64' => $fileData,
                'filename' => "{$scanId}.txt",
                'properties' => [
                    'action' => $action,
                    'includeHtml' => $includeHtml,
                    'sandbox' => $this->isSandbox,
                    'webhooks' => [
                        'status' => $webhook,
                    ],
                ],
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    public function submitScan($content)
    {
        $fileData = base64_encode($content);

        return $this->submitFileForScan($this->scanId, $fileData);
    }
}
