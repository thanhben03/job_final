<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\District;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function getDistrict($province_id)
    {
        $districts = District::where('province_code', $province_id)->get();

        return response()->json([
            'districts' => $districts
        ]);
    }
}
