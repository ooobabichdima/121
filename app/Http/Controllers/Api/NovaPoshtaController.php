<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\NovaPoshtaService;
use Illuminate\Http\Request;

class NovaPoshtaController extends Controller
{
    public function __construct(protected NovaPoshtaService $np) {}

    public function cities(Request $request)
    {
        $query = $request->get('q', '');
        return response()->json($this->np->searchCities($query));
    }

    public function warehouses(Request $request)
    {
        $cityRef = $request->get('cityRef', '');
        return response()->json($this->np->getWarehouses($cityRef));
    }
}
