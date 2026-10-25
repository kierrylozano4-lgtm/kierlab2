<?php

namespace Tests\Feature;

use App\Models\Notification;
use App\Models\Profile;
use App\Models\Review;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_profile_does_not_disclose_contact_identity_or_campus_address(): void
    {
        $viewer = User::factory()->create();
        $student = User::factory()->create([
            'email' => 'private.student@example.test',
            'student_id' => 'PRIVATE-123',
        ]);
        Profile::create([
            'user_id' => $student->id,
            'campus_address' => 'Private Dorm Room 12',
            'grade_level' => '3rd year',
            'course_major' => 'Computer Science',
        ]);
        Notification::create([
            'user_id' => $student->id,
            'message' => 'Private notification content.',
            'is_read' => false,
        ]);

        $this->actingAs($viewer)
            ->get(route('profile.show', ['user' => $student, 'tab' => 'notifications']))
            ->assertOk()
            ->assertSee('Computer Science')
            ->assertDontSee('private.student@example.test')
            ->assertDontSee('PRIVATE-123')
            ->assertDontSee('Private Dorm Room 12')
            ->assertDontSee('Private notification content.');
    }

    public function test_student_can_review_a_completed_request_from_their_profile(): void
    {
        $requester = User::factory()->create();
        $provider = User::factory()->create();
        $service = Service::create([
            'user_id' => $provider->id,
            'title' => 'Calculus tutoring',
            'category' => 'Academic',
            'description' => 'Help with calculus.',
            'status' => 'Active',
            'visible_in_dashboard' => true,
        ]);
        $serviceRequest = ServiceRequest::create([
            'service_id' => $service->id,
            'requester_id' => $requester->id,
            'provider_id' => $provider->id,
            'status' => 'Completed',
        ]);

        $this->actingAs($requester)
            ->get(route('profile.edit', ['tab' => 'reviews']))
            ->assertOk()
            ->assertSee(route('reviews.store', $serviceRequest), false)
            ->assertSee('Review completed requests');

        $this->post(route('reviews.store', $serviceRequest), [
            'rating' => 5,
            'comment' => 'Excellent tutoring.',
        ])->assertRedirect();

        $this->assertDatabaseHas('reviews', [
            'service_request_id' => $serviceRequest->id,
            'reviewer_id' => $requester->id,
            'reviewed_user_id' => $provider->id,
            'rating' => 5,
            'comment' => 'Excellent tutoring.',
        ]);
    }

    public function test_student_cannot_submit_a_second_review_for_the_same_request(): void
    {
        $requester = User::factory()->create();
        $provider = User::factory()->create();
        $service = Service::create([
            'user_id' => $provider->id,
            'title' => 'Calculus tutoring',
            'category' => 'Academic',
            'description' => 'Help with calculus.',
            'status' => 'Active',
            'visible_in_dashboard' => true,
        ]);
        $serviceRequest = ServiceRequest::create([
            'service_id' => $service->id,
            'requester_id' => $requester->id,
            'provider_id' => $provider->id,
            'status' => 'Completed',
        ]);
        Review::create([
            'service_request_id' => $serviceRequest->id,
            'reviewer_id' => $requester->id,
            'reviewed_user_id' => $provider->id,
            'rating' => 4,
            'comment' => 'Good session.',
        ]);

        $this->actingAs($requester)
            ->from(route('profile.edit', ['tab' => 'reviews']))
            ->post(route('reviews.store', $serviceRequest), [
                'rating' => 1,
                'comment' => 'Duplicate review.',
            ])
            ->assertRedirect(route('profile.edit', ['tab' => 'reviews']))
            ->assertSessionHasErrors('review');

        $this->assertDatabaseCount('reviews', 1);
    }
}
