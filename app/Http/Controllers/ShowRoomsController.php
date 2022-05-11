<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShowRoomsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // return response("all Rooms Listings", 200);
        $rooms=DB::table('rooms')->get();
        if ($request->query('id') !== null) {// check the request for query if there is some condition for specific value.
            $rooms=$rooms->where('room_type_id', $request->query('id'));
        }
        // return response()->json($rooms);
        return view('rooms.index',['rooms'=>$rooms]);

    }
}
