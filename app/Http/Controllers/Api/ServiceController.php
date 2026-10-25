<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ServiceController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        // Admins can see all services; regular users see only their own
        $query = $request->user()->is_admin
            ? Service::query()
            : $request->user()->services();

        $services = $query->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(15);

        return ServiceResource::collection($services);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'category' => ['required', Rule::in(['Academic', 'Personal', 'Tech'])],
            'description' => ['required', 'string', 'max:5000'],
            'price' => [
                Rule::requiredIf(fn (): bool => ! $request->boolean('price_negotiable')),
                'nullable',
                'numeric',
                'min:0',
                'max:99999999.99',
            ],
            'price_negotiable' => ['sometimes', 'boolean'],
            'price_note' => ['nullable', 'string', 'max:500'],
            'status' => ['sometimes', 'string', Rule::in(['Active', 'Inactive'])],
            'visible_in_dashboard' => ['sometimes', 'boolean'],
        ]);

        $validated['price_negotiable'] = $request->boolean('price_negotiable');
        $validated['status'] = $validated['status'] ?? 'Inactive';
        $validated['visible_in_dashboard'] = $validated['visible_in_dashboard'] ?? true;

        $service = $request->user()->services()->create($validated);

        return (new ServiceResource($service))
            ->response()
            ->setStatusCode(201)
            ->header('Location', route('api.services.show', $service));
    }

    public function show(Request $request, Service $service): ServiceResource
    {
        // Allow if owner OR if user is an admin
        abort_unless($service->user_id === $request->user()->id || $request->user()->is_admin, 404);

        return new ServiceResource($service);
    }

    public function update(Request $request, Service $service): JsonResponse
    {
        // Allow if owner OR if user is an admin
        abort_unless($service->user_id === $request->user()->id || $request->user()->is_admin, 404);

        $required = $request->isMethod('PUT') ? 'required' : 'sometimes';
        
        $validated = $request->validate([
            'title' => [$required, 'string', 'max:150'],
            'category' => [$required, Rule::in(['Academic', 'Personal', 'Tech'])],
            'description' => [$required, 'string', 'max:5000'],
            'price' => [
                $request->isMethod('PUT')
                    ? Rule::requiredIf(fn (): bool => ! $request->boolean('price_negotiable'))
                    : 'sometimes',
                'nullable',
                'numeric',
                'min:0',
                'max:99999999.99',
            ],
            'price_negotiable' => [
                $request->isMethod('PUT') ? 'required' : 'sometimes',
                'boolean',
            ],
            'price_note' => ['sometimes', 'nullable', 'string', 'max:500'],
        ]);

        if ($validated === []) {
            throw ValidationException::withMessages([
                'service' => ['Provide at least one service field to update.'],
            ]);
        }

        $priceNegotiable = $validated['price_negotiable'] ?? $service->price_negotiable;
        $price = array_key_exists('price', $validated) ? $validated['price'] : $service->price;

        if (! $priceNegotiable && $price === null) {
            throw ValidationException::withMessages([
                'price' => ['A price is required unless the price is negotiable.'],
            ]);
        }

        $service->update($validated);
        $service->refresh();

        return response()->json([
            'message' => 'Service updated successfully.',
            'data' => new ServiceResource($service),
        ]);
    }

    public function destroy(Request $request, Service $service): JsonResponse
    {
        // Allow if owner OR if user is an admin
        abort_unless($service->user_id === $request->user()->id || $request->user()->is_admin, 404);

        $service->delete();

        return response()->json([
            'message' => 'Service deleted successfully.',
        ]);
    }
}