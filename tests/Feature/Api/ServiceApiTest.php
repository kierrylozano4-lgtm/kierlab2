<?php

namespace Tests\Feature\Api;

use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @method $this withHeader(string $name, string $value)
 * @method \Illuminate\Testing\TestResponse getJson(string $uri, array $headers = [], int $options = 0)
 * @method \Illuminate\Testing\TestResponse postJson(string $uri, array $data = [], array $headers = [], int $options = 0)
 * @method \Illuminate\Testing\TestResponse putJson(string $uri, array $data = [], array $headers = [], int $options = 0)
 * @method \Illuminate\Testing\TestResponse patchJson(string $uri, array $data = [], array $headers = [], int $options = 0)
 * @method \Illuminate\Testing\TestResponse deleteJson(string $uri, array $data = [], array $headers = [], int $options = 0)
 * @method $this assertDatabaseHas(string $table, array $data = [], ?string $connection = null)
 * @method $this assertDatabaseMissing(string $table, array $data = [], ?string $connection = null)
 * @method $this assertDatabaseCount(string $table, int $count, ?string $connection = null)
 */
class ServiceApiTest extends TestCase
{
    use RefreshDatabase;

    private const API_KEY = 'feature-test-internal-api-key';
    private const API_USER_EMAIL = 'service.owner@example.test';

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'services.internal_api.key' => self::API_KEY,
            'services.internal_api.user_email' => self::API_USER_EMAIL,
        ]);
    }

    public function test_authenticated_owner_can_create_list_read_update_and_delete_a_service(): void
    {
        $owner = User::factory()->create([
            'email' => self::API_USER_EMAIL,
        ]);
        $otherOwner = User::factory()->create();
        $otherOwner->services()->create([
            'title' => 'Another user service',
            'category' => 'Tech',
            'description' => "This record must not appear in the owner's collection.",
        ]);

        $createResponse = $this->withHeader('X-API-KEY', self::API_KEY)
            ->postJson('/api/services', [
                'title' => 'API tutoring',
                'category' => 'Academic',
                'description' => 'Tutoring created through the internal API.',
                'price' => 225,
                'price_negotiable' => false,
                'price_note' => 'Per hour',
                'user_id' => $otherOwner->id,
                'status' => 'Inactive',
                'visible_in_dashboard' => true,
            ])
            ->assertCreated()
            ->assertJsonPath('data.title', 'API tutoring')
            ->assertJsonPath('data.user_id', $owner->id)
            ->assertJsonPath('data.status', 'Inactive')
            ->assertJsonPath('data.visible_in_dashboard', true);

        $serviceId = $createResponse->json('data.id');
        $createResponse->assertHeader('Location', route('api.services.show', $serviceId));

        $this->getJson('/api/services')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', $serviceId);

        $this->getJson('/api/services/'.$serviceId)
            ->assertOk()
            ->assertJsonPath('data.description', 'Tutoring created through the internal API.');

        $this->patchJson('/api/services/'.$serviceId, [
            'title' => 'Updated API tutoring',
            'price' => 250,
        ])
            ->assertOk()
            ->assertJsonPath('data.title', 'Updated API tutoring')
            ->assertJsonPath('data.price', '250.00');

        $this->assertDatabaseHas('services', [
            'id' => $serviceId,
            'title' => 'Updated API tutoring',
            'price' => '250.00',
        ]);

        $this->deleteJson('/api/services/'.$serviceId)
            ->assertOk()
            ->assertJsonPath('message', 'Service deleted successfully.');

        $this->assertDatabaseMissing('services', ['id' => $serviceId]);

        $this->getJson('/api/services/'.$serviceId)->assertNotFound();
    }

    public function test_api_returns_401_without_an_api_key_header(): void
    {
        $this->getJson('/api/services')->assertUnauthorized();
    }

    public function test_api_returns_401_for_an_invalid_api_key(): void
    {
        $this->withHeader('X-API-KEY', 'wrong-api-key')
            ->getJson('/api/services')
            ->assertUnauthorized();
    }

    public function test_api_returns_503_when_api_key_authentication_is_not_configured(): void
    {
        config([
            'services.internal_api.key' => null,
            'services.internal_api.user_email' => null,
        ]);

        $this->getJson('/api/services')
            ->assertServiceUnavailable()
            ->assertJsonPath('message', 'API key authentication is not configured.');
    }

    public function test_put_replaces_all_required_service_fields_and_persists_changes(): void
    {
        $owner = User::factory()->create([
            'email' => self::API_USER_EMAIL,
        ]);
        $service = $owner->services()->create([
            'title' => 'Old service title',
            'category' => 'Personal',
            'description' => 'Old service description.',
            'price' => 100,
            'price_negotiable' => false,
        ]);

        $this->withHeader('X-API-KEY', self::API_KEY)
            ->putJson('/api/services/'.$service->id, [
                'title' => 'Replacement title',
                'category' => 'Tech',
                'description' => 'Replacement description.',
                'price' => 300,
                'price_negotiable' => false,
            ])
            ->assertOk()
            ->assertJsonPath('data.title', 'Replacement title')
            ->assertJsonPath('data.category', 'Tech')
            ->assertJsonPath('data.price', '300.00');

        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'title' => 'Replacement title',
            'category' => 'Tech',
            'description' => 'Replacement description.',
            'price' => '300.00',
        ]);
    }

    public function test_put_returns_422_when_negotiability_is_omitted(): void
    {
        $owner = User::factory()->create([
            'email' => self::API_USER_EMAIL,
        ]);
        $service = $owner->services()->create([
            'title' => 'Existing service',
            'category' => 'Personal',
            'description' => 'Existing description.',
            'price' => 100,
            'price_negotiable' => false,
        ]);

        $this->withHeader('X-API-KEY', self::API_KEY)
            ->putJson('/api/services/'.$service->id, [
                'title' => 'Replacement title',
                'category' => 'Tech',
                'description' => 'Replacement description.',
                'price' => 300,
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['price_negotiable']);

        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'title' => 'Existing service',
            'price' => '100.00',
        ]);
    }

    public function test_api_returns_422_for_invalid_service_data(): void
    {
        User::factory()->create([
            'email' => self::API_USER_EMAIL,
        ]);

        $this->withHeader('X-API-KEY', self::API_KEY)
            ->postJson('/api/services', [
                'title' => '',
                'category' => 'Other',
                'description' => '',
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['title', 'category', 'description', 'price'])
            ->assertJsonPath('errors.title.0', 'The title field is required.')
            ->assertJsonPath('errors.category.0', 'The selected category is invalid.')
            ->assertJsonPath('errors.description.0', 'The description field is required.')
            ->assertJsonPath('errors.price.0', 'The price field is required.');

        $this->assertDatabaseCount('services', 0);
    }

    public function test_api_rejects_making_a_priceless_service_non_negotiable(): void
    {
        $owner = User::factory()->create([
            'email' => self::API_USER_EMAIL,
        ]);
        $service = $owner->services()->create([
            'title' => 'Negotiable tutoring',
            'category' => 'Academic',
            'description' => 'Price has not been set.',
            'price_negotiable' => true,
        ]);

        $this->withHeader('X-API-KEY', self::API_KEY)
            ->patchJson('/api/services/'.$service->id, [
                'price_negotiable' => false,
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['price']);

        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'price_negotiable' => true,
            'price' => null,
        ]);
    }

    public function test_api_returns_404_for_another_users_service(): void
    {
        $owner = User::factory()->create([
            'email' => self::API_USER_EMAIL,
        ]);
        $otherOwner = User::factory()->create();
        $service = Service::create([
            'user_id' => $otherOwner->id,
            'title' => 'Private listing',
            'category' => 'Tech',
            'description' => 'Owned by another user.',
            'status' => 'Active',
            'visible_in_dashboard' => true,
        ]);

        $this->withHeader('X-API-KEY', self::API_KEY)
            ->getJson('/api/services/'.$service->id)
            ->assertNotFound();
    }

    public function test_api_returns_404_when_updating_or_deleting_another_users_service(): void
    {
        $owner = User::factory()->create([
            'email' => self::API_USER_EMAIL,
        ]);
        $otherOwner = User::factory()->create();
        $service = $otherOwner->services()->create([
            'title' => 'Private listing',
            'category' => 'Tech',
            'description' => 'Owned by another user.',
        ]);

        $this->withHeader('X-API-KEY', self::API_KEY)
            ->patchJson('/api/services/'.$service->id, ['title' => 'Unauthorized change'])
            ->assertNotFound();

        $this->deleteJson('/api/services/'.$service->id)->assertNotFound();

        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'title' => 'Private listing',
        ]);
    }
}