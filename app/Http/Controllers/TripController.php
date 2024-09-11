<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Http\Requests\StoreTripRequest;
use App\Http\Requests\UpdateTripRequest;
use App\Models\Status;
use App\Models\Stop;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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
        $statuses = Status::all();

        //dd($trips);

        return Inertia::render('trips/index', [
            'trips' => $trips,
            'statuses' => $statuses,
            'old' => old()
        ]);

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

        $trip = Trip::create($validated);

        return to_route('trips.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Trip $trip)
    {

        $statuses = Status::all();

        $stops = Stop::where('trip_id', '=', $trip->id)->get();

        return Inertia::render('trips/show', compact('trip', 'statuses', 'stops'));

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

        if (auth()->id() != $trip->user_id) {
            abort(403, 'Access denied');
        }

        $validated = $request->validated();

        //dd($request->all());
        //Gestisco l'immagine nel caso mi arrivi un valore nullo capace di sovrascrivere la mia ultima immagine dal useform
        if ($request->image == null) {

            unset($validated['image']);

        } else {

            if ($trip->image) {

                Storage::delete($trip->image);
            }

            $manager = new ImageManager(new Driver());

            $name_gen = hexdec(uniqid()) . '.' . 'jpeg';

            $img = $manager->read($request->file('image')->getRealPath());

            $destination = storage_path('app/public/uploads');

            $img->toJpeg()->save($destination . '/' . $name_gen);

            $validated['image'] = 'uploads/' . $name_gen;
        }


        //Assegno lo status
        $validated['status_id'] = $request->status;

        //dd($validated['status_id']);

        $trip->update($validated);


        return to_route('trips.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trip $trip)
    {

        if (auth()->id() != $trip->user_id) {
            abort(403, 'Access denied');
        }

        if ($trip->image) {
            Storage::delete($trip->image);
        }

        $trip->delete();

        return to_route('trips.index');
    }
}
