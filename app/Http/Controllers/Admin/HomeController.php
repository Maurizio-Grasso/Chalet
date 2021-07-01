<?php

namespace App\Http\Controllers\Admin;

use App\Apartment;
use App\Http\Controllers\Controller;
use App\View;
use App\Message;
use App\Sponsorship;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [

            //prendere lista appartamenti user
            'apartments' => Apartment::where('user_id', Auth::id())->count(),

            //prendere views di tutti gli apppartamenti dell'utente
            'views' => View::whereHas('apartment', function($query){
                $query->where('user_id', Auth::id());
            })->get(),

            //prendere messaggi degli apppartamenti dell'utente
            'messages' => Message::whereHas('apartment', function($query){
                $query->where('user_id', Auth::id());
            })->count(),

            // prendere il t otale delle spese
            'sponsored_apartments' => DB::table('apartment_sponsorship')
                ->where('user_id', Auth::id())
                ->where('status',1)->sum('amount')
        ];

        return view('admin.dashboard.index',$data);
    }


        //pagina statistiche
    public function statistics($id_apt)
    {
        $data = [
            //prendere lista appartamenti user
            'apartments' => Apartment::where('user_id', Auth::id())
                ->select('title','id')
                ->get(),

            //prendere views di tutti gli apppartamenti dell'utente
            'views' => View::whereHas('apartment', function($query){
                $query->where('user_id', Auth::id());
            })->get(),

            //prendere messaggi degli apppartamenti dell'utente
            'messages' => Message::whereHas('apartment', function($query){
                $query->where('user_id', Auth::id());
            })->select('apartment_id')->get(),

            //prendere somma pagata eèr sponsorizzazioni degli apppartamenti dell'utente
            'sponsorships' => DB::table('apartment_sponsorship')
                ->where('user_id', Auth::id())->where('status',1)
                ->select('apartment_id','amount')
                ->get(),
            
            'id_apt' => $id_apt
        ];

        return view('admin.statistics.index',$data);
    }


    //sezione sponsorizzate
    public function sponsorship(){
        $data = [
            
            //prendere lista appartamenti user e apt dell 'user sponsorizzati
            'apartments' => Apartment::where('user_id', Auth::id())->get(),
            'sponsorships' => Sponsorship::all(),
            // 'sponsored_apartments' => DB::table('apartment_sponsorship')
            //     ->where('user_id', Auth::id())
                // ->where('start_date','<=',$now)
                // ->where('end_date','>=',$now)

            'sponsored_apartments' => DB::table('apartment_sponsorship')
                ->where('user_id', Auth::id())->get(),
        ];

        return view('admin.sponsorships.index',$data);
    }
}
