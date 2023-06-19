<?php

namespace App\Http\Controllers\API;

use App\Models\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function all_customer()
    {
        $customers = Customer::orderBy('firstname', 'ASC')->get();
        return response()->json([
            'customers' => $customers,
        ], 200);
    }
}
