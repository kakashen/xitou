<?php

namespace App\Http\Controllers;

use App\SecondHouse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SecondHouseController extends Controller
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SecondHouse  $secondHouse
     * @return \Illuminate\Http\Response
     */
    public function show(SecondHouse $secondHouse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SecondHouse  $secondHouse
     * @return \Illuminate\Http\Response
     */
    public function edit(SecondHouse $secondHouse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SecondHouse  $secondHouse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SecondHouse $secondHouse)
    {
        $link = $request->get('link');
        $all = $request->all();
        unset($all['link']);

        $ret = $secondHouse->updateOrInsert(['link' => $link], $all);

        return  new Response($ret ? 'success': 'fail');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SecondHouse  $secondHouse
     * @return \Illuminate\Http\Response
     */
    public function destroy(SecondHouse $secondHouse)
    {
        //
    }
}
