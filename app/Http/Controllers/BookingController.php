<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Booking::withTrashed()->get()->dd();
        $bookings=Booking::with(['room.roomType', 'users:name'])->orderBy('created_at', 'desc')->paginate(5);
        
        return view('booking.index')
        ->with('bookings',$bookings);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rooms=Room::get()->pluck('number','id')->prepend('none');
        $users=User::get()->pluck('name','id')->prepend('none');
        return view('booking.create')
        ->with('rooms',$rooms)
        ->with('users',$users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $booking=Booking::create($request->input());
        
        $booking->users()->attach($request->input('user_id'));
        // DB::table('bookings_users')->insert([
        //     'booking_id'=>$booking->id,
        //     'user_id'=>$request->input('user_id')
        // ]);
        return redirect()->action([BookingController::class,'index']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        // dd($booking);
        return view('booking.show')
        ->with('booking',$booking);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        // dd($booking);
        $users=DB::table('users')->get()->pluck('name','id');
        $rooms=Room::get()->pluck('number','id')->prepend('none');
        
        $bookings_users=DB::table('bookings_users')->get()->where('booking_id',$booking->id)->first();
        // dd($users,$rooms,$bookings_users);
        return view('booking.edit')
        ->with('users',$users)
        ->with('rooms',$rooms)
        ->with('bookings_users',$bookings_users)
        ->with('booking', $booking);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        $booking->fill($request->input());
        $booking->save();
        $booking->users()->sync($request->input('user_id'));

        // DB::table('bookings_users')
        // ->where('booking_id',$booking->id)
        // ->update([
        //     'user_id'=>$request->input('user_id')
        // ]);
        
        return redirect()->action([BookingController::class,'index']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        // dd($booking);
        //deleting booking user record from bridge table
        
        //using Laravel Eloquent Model in which we define Relationship
        $booking->users()->detach();
        // DB::table('bookings_users')->where('booking_id',$booking->id)->delete();
        
        //deleting booking Record        
        $booking->delete();

        // DB::table('bookings')->where('id',$booking->id)->delete();
        
        return redirect()->action([BookingController::class,'index']);
    }
}
