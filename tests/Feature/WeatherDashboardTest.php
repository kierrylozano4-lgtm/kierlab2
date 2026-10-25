<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\WeatherService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class WeatherDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_weather_service_maps_openweather_data_for_a_searched_location(): void
    {
        Http::fake([
            'api.openweathermap.org/geo/1.0/direct*' => Http::response([
                [
                    'name' => 'Tokyo',
                    'country' => 'JP',
                    'lat' => 35.6762,
                    'lon' => 139.6503,
                ],
            ]),
            'api.openweathermap.org/data/2.5/weather*' => Http::response([
                'dt' => 1789981200,
                'main' => [
                    'temp' => 26.5,
                    'humidity' => 70,
                ],
                'wind' => [
                    'speed' => 3.2,
                ],
                'weather' => [
                    ['description' => 'light rain'],
                ],
            ]),
        ]);

        $weather = (new WeatherService)->current('Tokyo');

        $this->assertSame('Tokyo', $weather['city']);
        $this->assertSame('JP', $weather['country']);
        $this->assertSame(26.5, $weather['temperature']);
        $this->assertSame('Light rain', $weather['condition']);
        $this->assertSame(70, $weather['humidity']);
        $this->assertSame(3.2, $weather['wind_speed']);
    }

    public function test_weather_service_returns_null_when_openweather_fails(): void
    {
        Http::fake([
            'api.openweathermap.org/geo/1.0/direct*' => Http::response([], 404),
        ]);

        $this->assertNull((new WeatherService)->current('Unknown Place'));
    }

    public function test_admin_weather_page_renders_with_a_registered_data_endpoint(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->get(route('admin.weather.page'))
            ->assertOk()
            ->assertSee(route('admin.weather.data'), false);
    }

    public function test_admin_weather_data_endpoint_returns_the_requested_location(): void
    {
        Http::preventStrayRequests();
        Http::fake([
            'api.openweathermap.org/geo/1.0/direct*' => Http::response([
                [
                    'name' => 'Tokyo',
                    'country' => 'JP',
                    'lat' => 35.6762,
                    'lon' => 139.6503,
                ],
            ]),
            'api.openweathermap.org/data/2.5/weather*' => Http::response([
                'dt' => 1789981200,
                'main' => [
                    'temp' => 26.5,
                    'humidity' => 70,
                ],
                'wind' => [
                    'speed' => 3.2,
                ],
                'weather' => [
                    ['description' => 'light rain'],
                ],
            ]),
        ]);
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->getJson(route('admin.weather.data', ['location' => 'Tokyo']))
            ->assertOk()
            ->assertJsonPath('city', 'Tokyo')
            ->assertJsonPath('country', 'JP');
    }

    public function test_non_admin_cannot_access_weather_page_or_data(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.weather.page'))
            ->assertForbidden();

        $this->get(route('admin.weather.data'))
            ->assertForbidden();
    }
}
