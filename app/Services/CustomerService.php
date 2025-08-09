<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerService
{
    public function __construct(public PhoneNumberService $phoneService) {}

    public function getCustomers(Request $request): LengthAwarePaginator
    {
        $customers = Customer::query()->get()->map(function ($customer) {
            $customer->country = $this->phoneService->detectCountry($customer->phone);
            $customer->country_code = $this->phoneService->detectCountryCode($customer->phone);
            $customer->state = $this->phoneService->isValid($customer->phone) ? 'Valid' : 'Invalid';
            return $customer;
        });

        if ($request->filled('country')) {
            $customers = $customers->where('country', $request->country);
        }
        if ($request->filled('state')) {
            $customers = $customers->where('state', $request->state);
        }

        $perPage = 10;
        $page = $request->get('page', 1);
        $paginated = $customers->forPage($page, $perPage);

        return new LengthAwarePaginator(
            $paginated,
            $customers->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
    }

    public function getCountriesList(): array
    {
        return $this->phoneService->getCountriesList();
    }
}
