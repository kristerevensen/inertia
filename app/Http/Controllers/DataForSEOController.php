<?php

// app/Http/Controllers/DataForSEOController.php

namespace App\Http\Controllers;

use DFSClientV3\DFSClient;
use DFSClientV3\Models\CommonApi\User;
use DFSClientV3\Models\SerpApi\SettingSerpLiveAdvanced;

class DataForSEOController extends Controller
{
    public function index()
    {
        $client = new DFSClient();
        $client->setConfig(config('dataforseo'));

        // Example usage
        $userModel = new User();
        $userData = $userModel->get();
        print_r($userData);

        $serpModel = new SettingSerpLiveAdvanced();
        $serpModel->setSe("google")
                  ->setSeType("organic")
                  ->setKeyword("seo")
                  ->setLocationCode(2840)
                  ->setLanguageCode("en");

        $serpData = $serpModel->getAsJson();
        print_r($serpData);

        // Return response or view as needed
    }
}
