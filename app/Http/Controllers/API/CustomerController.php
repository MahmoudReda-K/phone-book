<?php


namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct(public CustomerService $customerService){}

    public function index(Request $request)
    {
        return view('customers.index', [
            'customers' => $this->customerService->getCustomers($request),
            'countries' => $this->customerService->getCountriesList(),
        ]);
    }
}
