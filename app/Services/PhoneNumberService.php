<?php

namespace App\Services;

class PhoneNumberService
{
    private array $countries = [
        'Cameroon' => ['code' => '+237', 'regex' => '/\(237\)\ ?[2368]\d{7,8}$/'],
        'Ethiopia' => ['code' => '+251', 'regex' => '/\(251\)\ ?[1-59]\d{8}$/'],
        'Morocco' => ['code' => '+212', 'regex' => '/\(212\)\ ?[5-9]\d{8}$/'],
        'Mozambique' => ['code' => '+258', 'regex' => '/\(258\)\ ?[28]\d{7,8}$/'],
        'Uganda' => ['code' => '+256', 'regex' => '/\(256\)\ ?\d{9}$/'],
    ];

    public function detectCountry(string $phone): ?string
    {
        foreach ($this->countries as $country => $info) {
            if (preg_match('/^\(' . substr($info['code'], 1) . '\)/', $phone)) {
                return $country;
            }
        }
        return null;
    }

    public function detectCountryCode(string $phone): ?string
    {
        $country = $this->detectCountry($phone);
        return $country ? $this->countries[$country]['code'] : null;
    }

    public function isValid(string $phone): bool
    {
        $country = $this->detectCountry($phone);
        if (!$country) {
            return false;
        }

        return preg_match($this->countries[$country]['regex'], $phone) === 1;
    }

    public function getCountriesList(): array
    {
        return array_keys($this->countries);
    }
}
