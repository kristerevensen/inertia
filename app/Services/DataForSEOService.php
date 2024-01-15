<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DataForSEOService
{
    protected $baseUrl;
    protected $username;
    protected $password;

    public function __construct()
    {
        $this->baseUrl = config('services.dataforseo.url');
        $this->username = config('services.dataforseo.username');
        $this->password = config('services.dataforseo.password');
    }

    public function getLocationsAndLanguages()
    {
        $response = Http::withBasicAuth($this->username, $this->password)
            ->get($this->baseUrl . '/v3/dataforseo_labs/locations_and_languages');

        if ($response->successful()) {
            return $response->json();
        } else {
            throw new \Exception('Failed to retrieve data from DataForSEO');
        }
    }
}
