<?php

namespace App\Http\Controllers\Frontend;

use App\Models\ProductProjection;
use App\Models\Smg;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
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
     * Get the restaurant info.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRestaurantInfo() {
        $restaurant = Auth::guard('restaurant')->user();

        return response()->json([
                'restaurant' => $restaurant
        ]);
    }

    /**
     * Get the smg score.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSmgScore() {
        $restaurant = Auth::guard('restaurant')->user();

        $raw_smg = $restaurant->smg();
        $scoreArr = [
                'overall_satisfaction_score' => 0,
                'taste_of_food_score' => 0,
                'speed_of_service_score' => 0
        ];
        $smg = [
                'cw' => $scoreArr,
                'pw' => $scoreArr,
                'system' => $scoreArr
        ];

        // Get the global system score
        $smg_system = Smg::where('type_id', 3)->first();
        $systemCollection = collect($smg_system);
        $smg['system'] = $systemCollection->only(['overall_satisfaction_score', 'taste_of_food_score', 'speed_of_service_score'])->all();

        // Get the global SMG updated_at (equals to updated_at of system score)
        $smgUpdatedAt = Carbon::parse($smg_system->updated_at)->format("F jS Y");

        // Update the smg scores list with raw data
        foreach ($raw_smg as $row) {
            $type = $row->type()->name;
            $collection = collect($row);
            $smg[$type] = $collection->only(['overall_satisfaction_score', 'taste_of_food_score', 'speed_of_service_score'])->all();
        }

        // Get the product-mix modifier
        $productMixModifier = $restaurant->productMixModifier();

        // Get the edit status of yesterday-sales
        $yesterdaySales = $restaurant->salesInputList()->where('date', date('Y-m-d', strtotime('-1 days')));
        $yesterdaySalesEdited = false;
        if (!$yesterdaySales->isEmpty())
            $yesterdaySalesEdited = true;

        // Get the edit status of product-projection
        $todayProductProjection = ProductProjection::where('restaurant_id', $restaurant->restaurant_id)
                                                ->whereDate('created_at', date('Y-m-d'))
                                                ->get();
        $todayProductProjectionEdited = false;
        if (!$todayProductProjection->isEmpty())
            $todayProductProjectionEdited = true;

        return response()->json([
                'smg' => $smg,
                'smgUpdatedAt' => $smgUpdatedAt,
                'productMixModifier' => $productMixModifier,
                'yesterdaySalesEdited' => $yesterdaySalesEdited,
                'todayProductProjectionEdited' => $todayProductProjectionEdited
        ]);
    }
}
