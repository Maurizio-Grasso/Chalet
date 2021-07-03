<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Apartment;
use App\Image;
use App\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
    }

    /*
    *   Dato l'id di un appartamento, questo metodo
    *   restituisce l'oggetto che lo rappresenta
    */
    public function show($id , $messageSent=false)
    {
        // Trova appartamento il cui ID corrisponde a quello richiesto

        $apt = Apartment::where('id', $id)->first();

        // Dall'apaprtamento trovato filtro solo le info utili alla visualizzazione 

        $apartment=array(
            'title'             => $apt->title ,
            'id'                => $apt->id ,
            'address'           => $apt->address ,
            'rooms_n'           => $apt->rooms_n ,
            'beds_n'            => $apt->beds_n ,
            'bathroom_n'        => $apt->bathroom_n ,
            'dimensions'        => $apt->dimensions ,
            'latitude'          => $apt->latitude ,
            'longitude'         => $apt->longitude ,
            'description'       => $apt->description ,
            'price_per_night'   => $apt->price_per_night ,
            'rating'            => $apt->rating
        );

        // Trova info relative all'host dell'apt

        $apt_host = DB::table('users')
        ->where('id' , $apt->user_id)
        ->first();

        $host = array(
            'id'            => $apt_host->id ,
            'name'          => $apt_host->name ,
            'surname'       => $apt_host->surname ,
            'profile_pic'   => $apt_host->profile_pic
        );

        $apartment['host']    = $host;

        // Trova immagini associate all'appartamento
        $apt_images = Image::where('apartment_id' , $id)->get();
        
        $images = array();

        // Pusho le info necessarie relative ad ogni img trovata all'interno di un array
        foreach ($apt_images as $img) {
            $images[] = array(
                                'img_path'      => $img->img_path ,
                                'is_cover'      => $img->is_cover == 1 ? true : false ,
                                'description'   => $img->description
                            );                          
        }

        // Aggiungo l'array di img alle info dell'apt
        $apartment['images'] = $images;


        //  Creo un array contenente la lista degli id dei servizi associati all'apt
        $provided_services = app('App\Http\Controllers\Api\ApartmentController')->getAptServiceList($id);
        $services = array();

        // Cerco il nome associato al servizio avente l'ID precedentemente ricavato
        foreach ($provided_services as $service) {
            $service_details = DB::table('services')
            ->where('id' , $service->service_id)
            ->first();

            $services[] = array(
                                'service_id'      => $service_details->id ,
                                'service_name'    => $service_details->service_name ,
                                'service_icon'    => $service_details->service_icon
                            );                          
        }

        // Inserisco le info relative ai servizi
        
        $apartment['services']  = $services;

        $data = [
            'apartment' => $apartment ,
            'messageSent' => $messageSent
        ];

        //crea nuova visualizzazione dell'appartamento

        $new_view = new View;
        $new_view->apartment_id = $id;
        $new_view->save();

        return view('guest.singleApartment',$data);
    }
}
