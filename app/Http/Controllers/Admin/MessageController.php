<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Message;
use Illuminate\Support\Facades\DB;
use App\Apartment;
use Carbon\Carbon;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_apt)
    {
            $data = [
            // FILTRARE SOLO QUELLI DELL'UTENTE
            'messages' => Message::whereHas('apartment', function($query){
                $query->where('user_id', Auth::id());
            })->get(),
            'apartments' => Apartment::where('user_id', Auth::id())
            ->select('title','id')
            ->get(),
            'id_apt' => $id_apt
        ];


        return view('admin.messages.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'email_sender' => 'required|min:2|max:50',
            'message_text' => 'required',
            'apartment_id' => 'required',
        ]);

        $data = $request->all();
        $newMessage = new Message();
        $newMessage->apartment_id = $data['apartment_id'];
        $newMessage->date = Carbon::now();
        $newMessage->fill($data);
        $newMessage->save();

        // AGGIUNGERE MESSAGGIO SUCCESSO INVIO E SVUOTARE FORM senza far fare redirect

        return redirect()->route('guest_show_apartment' , [ 'id' => $data['apartment_id'] , 'messageSent' => true] );
    }

}
