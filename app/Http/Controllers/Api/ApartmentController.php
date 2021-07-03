<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Apartment;
use App\Image;
use App\Service;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  Mostra lista appartamenti
    public function index()
    {
        $apartments=Apartment::all();

        return response()->json([
            'success'=> true,
            'results'=> $apartments
        ]);
    }

    //  Mostra lista appartamenti filtrata per utente
    public function getAptUserList()
    {
        $apartments=Apartment::where('user_id', Auth::id())->get();

        return response()->json([
            'success'=> true,
            'results'=> $apartments
        ]);
    }

     //  Mostra lista appartamenti utente filtrata per sponsorizzazioni
     public function getUserSponsoredAptList()
     {
        
        //  return response()->json([
        //      'success'=> true,
        //      'results'=> $filteredApartments
        //  ]);
     }
    
    //  Ritorna lista servizi

    public function services()
    {
        $services=DB::table('services')
        ->select('service_name' , 'id')
        ->get();

        return response()->json([
            'success'=> true,
            'results'=> $services
        ]);
    }

    /*
    **  Dato l'ID di un Appartamento
    **  controlla se ci sono sponsorizzazioni attive
    */

    public function checkSponsorship($aptID)
    {
        $currentDate = date("Y-m-d H:i:s");
        $checkSponsor = DB::table('apartment_sponsorship')
        ->where([
            ['apartment_id',$aptID] ,
            ['status' , 1]
            ])
        ->whereDate('end_date' , '>' , $currentDate)
        ->first();
        
        $is_sponsored = $checkSponsor ? true : false;
        return $is_sponsored;
    }

    /*
    **  Dato l'ID di un Appartamento
    **  ne restituisce la list di servizi
    */

    public function getAptServiceList($aptID)
    {
        $services = DB::table('apartment_service')
        ->select('service_id')
        ->where('apartment_id',$aptID)
        ->get();
        return $services;
    }
    
    /*
    **  Dato l'ID di un Appartamento
    **  ne restituisce l'img di copertina
    */

    public function getAptCoverImg($aptID)
    {
        $cover_img = DB::table('images')->where(
            [
                ['apartment_id', '=' , $aptID] ,
                ['is_cover' ,    '=' , '1']
            ]
            )->first();
            
            // Se trova l'immagine di copertina ne ricava il path, altrimenti imposta il path su una stringa vuota                    
            $cover_img ? $cover_img = $cover_img->img_path : $cover_img = '';

            return $cover_img;
    } 

    /*
     * RESTITUISCE ARRAY DI APPARTAMENTI SPONSORIZZATI
     * Richiede come parametro nOfItems, equivalente al numero di apt richiest
     * se nOfItems == 0, verranno restituiti TUTTI gli apt
     */

    public function getSponsoredApt(Request $request) {        
        
        $currentDate = date("Y-m-d H:i:s");
        
        //  Cerca tutte le sponsorizzazioni attive
        
        $sponsorships = DB::table('apartment_sponsorship')
        ->select('apartment_id')
        ->where('status' , 1)
        ->whereDate('end_date' , '>' , $currentDate)
        ->get();
                
        $sponsoredAptIDS = [];
        //  Cicla tutte le sponsorizzazioni attive ed aggiunge il corrispondente Id dell'appartamento
        //  all'Array $sponsoredAptIDS, il quale, al termine del foreach conterrà gli ID di tutti gli apt sponsorizzati
        foreach ($sponsorships as $sponsorship) {
            if(!in_array($sponsorship->apartment_id , $sponsoredAptIDS))
            array_push($sponsoredAptIDS , $sponsorship->apartment_id );
        }
        
        $sponsoredAptAll = []; // array contenente **tutti** gli apt sponsorizzati presenti nel DB
        
        //  Dall'array di Id degli apt sponsorizzati ricava le effettive informazioni relative all'apt
        foreach ($sponsoredAptIDS as $aptID) {
            $apt =  DB::table('apartments')
            ->select('id' , 'price_per_night' , 'beds_n' , 'rating' , 'title' , 'description')
            ->where('id',$aptID)
            ->first();

            $excerpt = substr($apt->description , 0 ,100) . '...';

            $cover_img = $this->getAptCoverImg($aptID);
     
            // Salva le informazioni ottenute in un nuovo array, pushato poi in $filteredApt

            $filteredApt = array( 
                'name' => $apt->title,
                'id' => $apt->id , 
                'price' => $apt->price_per_night ,
                'beds' => $apt->beds_n , 
                'rating' => $apt->rating ,
                'cover_img' => $cover_img ,
                'is_sponsored' => true,
                'excerpt'   => $excerpt
             );

            array_push($sponsoredAptAll , $filteredApt);
        }

        $sponsoredApt = [];

        $nOfItems = $request->input('nOfItems');    // Numero di Apt  richiesti
        
        if($nOfItems > count($sponsoredAptAll) || $nOfItems == 0)
            $nOfItems = count($sponsoredAptAll);

        for ($i=0; $i < $nOfItems; $i++) { 
            array_push($sponsoredApt , $sponsoredAptAll[$i]);
        }

        //  Compila l'array finale $sponsoredApt in base al numero di apt richiesti nella chiamata API
        //  e finalmente lo restituisce
        
        return response()->json([
            'success'=> true,
            'results'=> $sponsoredApt
        ]);
    }

    /**
     * RICERCA APT VISIBILI NEL DB 
     * ALL'INTERNO DI UN DETERMINATO RAGGIO 
     * A PARTIRE DAL PUNTO DI RICERCA INSERITO */
    
    public function location(Request $request)
    {
        //  Richiede al db tutti gli apt visibili
        $apartments=Apartment::where('visible','1')->get();
        
        $location = $request->input('location');    // Query Location
        $radius   = $request->input('radius');      // Query Radius

        // Chiamata a TomTom per ottenere coordinate di $location
        $response = Http::withOptions(['verify' => false])->get('https://api.tomtom.com/search/2/geocode/' . $location . '.json?limit=1&key=qISPPmwNd3vUBqM2P2ONkZuJGTaaQEmb')->json();
        
        $lat = $response['results'][0]['position']['lat'];
        $lon = $response['results'][0]['position']['lon'];
        
        // Coordinate (conversione da decimali a radianti)        
        $radLat1 =   (M_PI / 180) * $lat;
        $radLon1 =   (M_PI / 180) * $lon;

        $sinRadLat1 = sin($radLat1);    // Seno Latitudine input utente
        $cosRadLat1 = cos($radLat1);    // Coseno Latitudine input utente
        
        $earthRadius = 6371; // Raggio Terrestre (KM)
                
        $chalets = array();

        foreach($apartments as $apartment) {

            // calcola distanza radiale dal punto di ricerca inserito
            $dist = acos( $sinRadLat1 * sin((M_PI / 180) * $apartment['latitude']) + $cosRadLat1 * cos((M_PI / 180) * $apartment['latitude']) * cos($radLon1 - (M_PI / 180) * $apartment['longitude']) ) * $earthRadius;

            if ($dist <= $radius) {

                //  Richiede img di copertina apt
                $cover_img = $this->getAptCoverImg($apartment['id']);
                
                //  Richiede lista servizi
                $services = $this->getAptServiceList($apartment['id']);
                    
                // Controllo Eventuale Sponsorizzazione Attiva
                $is_sponsored = $this->checkSponsorship($apartment['id']);

                // Genera una descrizione breve
                $excerpt = substr($apartment['description'] , 0 ,100) . '...';

                // Crea array con i dati necessari per stampa e filtri    
                $newChalet = array(
                    'id' => $apartment['id'] ,
                    'name' => $apartment['title'] ,
                    'lat'  => $apartment['latitude'] ,
                    'lon'  => $apartment['longitude'] ,
                    'dist' => $dist ,
                    'excerpt' => $excerpt,
                    'cover_img' => $cover_img,
                    'rooms' => $apartment['rooms_n'],
                    'beds' => $apartment['beds_n'],
                    'price' => $apartment['price_per_night'],
                    'rating' => $apartment['rating'],
                    'services' => $services ,
                    'id' =>    $apartment['id'],
                    'is_sponsored'  => $is_sponsored
                );

                //  Pusha dati apt nell'array dei risultati
                array_push($chalets , $newChalet);
            }
        }
        
        return response()->json([
            'success'=> true,
            'results'=> $chalets ,
            'base_lat' => $lat ,
            'base_lon' => $lon
        ]);
    }    
}