<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use GuzzleHttp\Client;
use Illuminate\Contracts\Session\Session;

class LesbarhetsController extends Controller
{
    public function index()
    {
       // return view('lesbarhet.index');
       //return Inertia::render('Pages/Overview'); Lesbarhetresults
        return Inertia::render('Lesbarhet/Index');
    }

    public function beregn(Request $request)
    {
        $input = $request->input('tekst');
        $tekst = $this->hentTekst($input);

        $liks = $this->kalkulerLesbarhetsindeks($tekst);
        return Inertia::render('Pages/Lesbarhetresults', ['liks' => $liks])->with('csrf_token', Session::token());
        //return view('lesbarhet.resultat', ['liks' => $liks]);
    }

    protected function hentTekst($input)
    {
        if (filter_var($input, FILTER_VALIDATE_URL)) {
            // Anta at det er en URL, og prøv å hente teksten fra URLen
            $client = new Client();
            try {
                $response = $client->request('GET', $input);
                $body = $response->getBody()->getContents();
                return strip_tags($body);
            } catch (\Exception $e) {
                return "Kunne ikke hente innhold fra URL. Feil: " . $e->getMessage();
            }
        } else {
            // Ikke en URL, returner input som tekst
            return $input;
        }
    }

    protected function kalkulerLesbarhetsindeks($tekst)
    {
        $setninger = preg_split('/[.!?]+/', $tekst, -1, PREG_SPLIT_NO_EMPTY);
        $ord = preg_split('/\s+/', $tekst, -1, PREG_SPLIT_NO_EMPTY);
        $totaltAntallOrd = count($ord);
        $antallSetninger = count($setninger);

        $gjennomsnittOrdPerSetning = $antallSetninger > 0 ? $totaltAntallOrd / $antallSetninger : 0;

        $langeOrd = array_filter($ord, function ($ord) {
            return mb_strlen($ord) > 6;
        });
        $antallLangeOrd = count($langeOrd);
        $prosentLangeOrd = $totaltAntallOrd > 0 ? ($antallLangeOrd / $totaltAntallOrd) * 100 : 0;

        return $gjennomsnittOrdPerSetning + $prosentLangeOrd; // Eller annen formel etter behov
    }
}
