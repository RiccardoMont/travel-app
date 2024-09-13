<?php

namespace App\Http\Controllers;

use App\Models\Stop;
use App\Http\Requests\StoreStopRequest;
use App\Http\Requests\UpdateStopRequest;
use Inertia\Inertia;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class StopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('stops/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStopRequest $request)
    {
        $validated = $request->validated();

        //dd($request->all());
        $trip_id = $request->trip_id;

        if ($request->image !== null) {

            $manager = new ImageManager(new Driver());

            $name_gen = hexdec(uniqid()) . '.' . 'jpeg';

            $img = $manager->read($request->file('image')->getRealPath());

            $destination = storage_path('app/public/uploads');

            $img->toJpeg()->save($destination . '/' . $name_gen);

            $validated['image'] = 'uploads/' . $name_gen;
        }

        //Segna errore ma in realtà riesce a prenderlo
        $validated['user_id'] = auth()->id();

        //Aggiungo ":00" per i secondi, in modo che postgres non abbia problemi nell'inserire il dato nella colonna
        $validated['date_and_hour'] = date('Y-m-d H:i:s', strtotime($request->date_and_hour . ':00'));

        //$validated['trip_id'] = $request->trip_id;
        //$validated['status_id'] = $request->status;

        $stop = Stop::create($validated);

        return to_route('trips.show', ['trip' => $trip_id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Stop $stop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stop $stop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStopRequest $request, Stop $stop)
    {

        dd($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stop $stop)
    {
        //
    }
}
