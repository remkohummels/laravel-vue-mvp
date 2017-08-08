<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Restaurant\Hours as RestaurantHours;
use App\Models\DayPart;

class HoursOperationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.restaurant');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.frontend.dashboard');
    }

    /**
     * Get the restaurant hours info.
     *
     * @return \Illuminate\Http\Response
     */
    public function getInfo() {
        $restaurant = Auth::guard('restaurant')->user();
        $restaurantHoursList = $restaurant->restaurantHoursList();
        $restaurantHoursCollection = collect();
        $collection = collect();
        $previousrow = null;

        // update the restaurantHoursCollection with the restaurantHours list
        foreach ($restaurantHoursList as $key => $row) {
            if ($previousrow['dayofweek'] != $row['dayofweek']) {
                $collection = collect();
                $previousrow = $row;
            }
            $collection->push($row);
            $restaurantHoursCollection->put($row['dayofweek'], $collection);
        }

        $dayPartList = $restaurant->dayPartList();
        $dayPartCollection = collect();
        $collection2 = collect();
        $previousrow2 = null;

        // update the dayPartCollection with the dayPart list
        foreach ($dayPartList as $key => $row) {
            if ($previousrow2['dayofweek'] != $row['dayofweek']) {
                $collection2 = collect();
                $previousrow2 = $row;
            }

            $collection2->push($row);
            $dayPartCollection->put($row['dayofweek'], $collection2);
        }

        return response()->json([
            'restaurantHoursList' => $restaurantHoursCollection->all(),
            'dayPartList' => $dayPartCollection->all()
        ]);
    }

    /**
     * Update the day part time of the restaurant_hours table.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        // get the request data array
        $requestData = $request->all();

        // update the day part time indicated by rowPk & fieldName
        $restaurantHours = RestaurantHours::find($requestData['rowPk']);
        $restaurantHours[$requestData['fieldName']] = $requestData['time'];
        $restaurantHours->save();

        return response()->json(['success' => true]);
    }
}
