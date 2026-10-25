<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherService
{
    /**
     * Retrieve current weather for a searched location or the configured default.
     *
     * @return array{
     *     city: string,
     *     country: string,
     *     temperature: float,
     *     condition: string,
     *     humidity: int,
     *     wind_speed: float,
     *     observed_at: string
     * }|null
     */
    public function current(?string $location = null): ?array
    {
        $configuration = config('services.weather', [
            'city' => 'Manila',
            'geocoding_endpoint' => 'https://api.openweathermap.org/geo/1.0/direct',
            'current_endpoint' => 'https://api.openweathermap.org/data/2.5/weather',
            'api_key' => 'demo-key',
            'verify_ssl' => true,
            'connect_timeout' => 10,
            'timeout' => 15,
        ]);
        $coordinates = $this->coordinatesFor($location ?: $configuration['city']);

        if ($coordinates === null) {
            return null;
        }

        try {
            $response = Http::acceptJson()
                ->withOptions(['verify' => $configuration['verify_ssl']])
                ->connectTimeout($configuration['connect_timeout'])
                ->timeout($configuration['timeout'])
                ->retry(2, 250, fn (\Throwable $exception): bool => $exception instanceof ConnectionException)
                ->get($configuration['current_endpoint'], [
                    'lat' => $coordinates['latitude'],
                    'lon' => $coordinates['longitude'],
                    'appid' => $configuration['api_key'],
                    'units' => 'metric',
                ])
                ->throw();
        } catch (ConnectionException|RequestException $exception) {
            Log::warning('OpenWeather request failed.', [
                'location' => $location,
                'message' => $exception->getMessage(),
            ]);

            return null;
        }

        $current = $response->json();

        $condition = data_get($current, 'weather.0.description');

        if (
            ! is_array($current)
            || ! is_numeric(data_get($current, 'main.temp'))
            || ! is_numeric(data_get($current, 'main.humidity'))
            || ! is_numeric(data_get($current, 'wind.speed'))
            || blank($current['dt'] ?? null)
            || blank($condition)
        ) {
            Log::warning('OpenWeather returned an invalid weather payload.', [
                'location' => $location,
            ]);

            return null;
        }

        return [
            'city' => $coordinates['city'],
            'country' => $coordinates['country'],
            'temperature' => (float) $current['main']['temp'],
            'condition' => ucfirst((string) $condition),
            'humidity' => (int) $current['main']['humidity'],
            'wind_speed' => (float) $current['wind']['speed'],
            'observed_at' => date('M d, Y H:i', (int) $current['dt']),
        ];
    }

    /**
     * @return array{city: string, country: string, latitude: float, longitude: float}|null
     */
    private function coordinatesFor(string $location): ?array
    {
        $configuration = config('services.weather', [
            'city' => 'Manila',
            'geocoding_endpoint' => 'https://api.openweathermap.org/geo/1.0/direct',
            'current_endpoint' => 'https://api.openweathermap.org/data/2.5/weather',
            'api_key' => 'demo-key',
            'verify_ssl' => true,
            'connect_timeout' => 10,
            'timeout' => 15,
        ]);

        try {
            $response = Http::acceptJson()
                ->withOptions(['verify' => $configuration['verify_ssl']])
                ->connectTimeout($configuration['connect_timeout'])
                ->timeout($configuration['timeout'])
                ->get($configuration['geocoding_endpoint'], [
                    'q' => $location,
                    'limit' => 1,
                    'appid' => $configuration['api_key'],
                ])
                ->throw();
        } catch (ConnectionException|RequestException $exception) {
            Log::warning('OpenWeather geocoding request failed.', [
                'location' => $location,
                'message' => $exception->getMessage(),
            ]);

            return null;
        }

        $place = $response->json('0');

        if (
            ! is_array($place)
            || blank($place['name'] ?? null)
            || ! is_numeric($place['lat'] ?? null)
            || ! is_numeric($place['lon'] ?? null)
        ) {
            return null;
        }

        return [
            'city' => (string) $place['name'],
            'country' => (string) ($place['country'] ?? ''),
            'latitude' => (float) $place['lat'],
            'longitude' => (float) $place['lon'],
        ];
    }
}
