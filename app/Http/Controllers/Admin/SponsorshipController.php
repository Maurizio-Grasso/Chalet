<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ApartmentSponsorship;
use Illuminate\Support\Facades\Auth;
use App\Sponsorship;
use Illuminate\Support\Facades\Date;
use Carbon\Carbon;

class SponsorshipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store($apt_id, $spons_id, $status)
    {
        $spons=Sponsorship::find($spons_id);

        $new_apt_spons = new ApartmentSponsorship();
        $new_apt_spons->apartment_id = $apt_id;
        $new_apt_spons->sponsorship_id = $spons_id;
        $new_apt_spons->user_id = Auth::id();
        $new_apt_spons->amount = $spons->amount;
        $new_apt_spons->status = $status;
        $new_apt_spons->start_date = Carbon::now();
        $new_apt_spons->end_date=Carbon::now()->addHours($spons->hours);
        $new_apt_spons->save();

        return redirect()->route('admin.sponsorships.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
