<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class NovaPoshtaService
{
    protected string $base = 'https://api.novaposhta.ua/v2.0/json/';

    public function searchCities(string $query): array
    {
        if (! $this->enabled()) {
            return $this->mockCities();
        }
        $cacheKey = 'np_cities_'.md5($query);
        return Cache::remember($cacheKey, $this->cacheTtl(), function () use ($query) {
            $resp = Http::post($this->base, [
                'apiKey' => $this->key(),
                'modelName' => 'Address',
                'calledMethod' => 'searchSettlements',
                'methodProperties' => [
                    'CityName' => $query,
                    'Limit' => 30,
                ],
            ]);
            if (! $resp->successful()) {
                return $this->mockCities();
            }
            $data = $resp->json('data.0.Addresses') ?? [];
            return collect($data)->map(fn($c) => [
                'name' => $c['Present'] ?? $c['MainDescription'] ?? 'Город',
                'ref' => $c['DeliveryCity'] ?? $c['Ref'] ?? '',
            ])->toArray();
        });
    }

    public function getWarehouses(string $cityRef): array
    {
        if (! $this->enabled()) {
            return $this->mockWarehouses();
        }
        $cacheKey = 'np_wh_'.$cityRef;
        return Cache::remember($cacheKey, $this->cacheTtl(), function () use ($cityRef) {
            $resp = Http::post($this->base, [
                'apiKey' => $this->key(),
                'modelName' => 'AddressGeneral',
                'calledMethod' => 'getWarehouses',
                'methodProperties' => [
                    'CityRef' => $cityRef,
                ],
            ]);
            if (! $resp->successful()) {
                return $this->mockWarehouses();
            }
            $data = $resp->json('data') ?? [];
            return collect($data)->map(fn($w) => [
                'name' => $w['Description'] ?? 'Отделение',
                'ref' => $w['Ref'] ?? '',
            ])->toArray();
        });
    }

    protected function cacheTtl(): int
    {
        return (int) (config('services.novaposhta.cache_hours', 12) * 3600);
    }

    protected function enabled(): bool
    {
        return (bool) $this->key();
    }

    protected function key(): ?string
    {
        return config('services.novaposhta.key');
    }

    protected function mockCities(): array
    {
        return [
            ['name' => 'Киев', 'ref' => 'demo-kyiv'],
            ['name' => 'Львов', 'ref' => 'demo-lviv'],
            ['name' => 'Одесса', 'ref' => 'demo-odessa'],
        ];
    }

    protected function mockWarehouses(): array
    {
        return [
            ['name' => 'Отделение №1 (ул. Примерная, 1)', 'ref' => 'wh-1'],
            ['name' => 'Отделение №2 (ул. Игровая, 5)', 'ref' => 'wh-2'],
        ];
    }
}
