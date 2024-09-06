<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Http\Requests\StoreTripRequest;
use App\Http\Requests\UpdateTripRequest;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trips = Trip::all();

        //dd($trips);
        
        return Inertia::render('trips/index', compact('trips'));

        /*return Inertia::render('trips/index', [
            'trips' => $trips
        ]);*/

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
    public function store(StoreTripRequest $request)
    {
        $validated = $request->validated();
        
        if($request->has('image')){

            $manager = new ImageManager(new Driver());

            $name_gen = hexdec(uniqid()) . '.' . 'jpeg';

            $img = $manager->read($request->file('image')->getRealPath());

            $destination = storage_path('app/public/uploads');

            $img->toJpeg()->save($destination . '/' . $name_gen);

            $validated['image'] = 'uploads/' . $name_gen;

        }

        //$validated[''] = $request->

        $trip = Trip::create($validated);

        return to_route('trips.index');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Trip $trip)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Trip $trip)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTripRequest $request, Trip $trip)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trip $trip)
    {
        //
    }
}
