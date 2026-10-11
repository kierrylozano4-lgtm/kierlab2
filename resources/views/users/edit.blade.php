@extends('layouts.app', ['title' => 'Edit user'])

@section('content')
<div class="mx-auto max-w-2xl"><a href="{{ route('users.index') }}" class="text-sm font-semibold text-orange-600">← Back to users</a><h1 class="mt-6 text-4xl font-black tracking-tight">Edit user</h1><p class="mt-2 text-stone-500">Update account details or change the assigned role.</p>
<form method="POST" action="{{ route('users.update', $user) }}" class="mt-8 space-y-6 border border-stone-200 bg-white p-6 shadow-sm">@csrf @method('PUT') @include('users.form', ['submitLabel' => 'Save changes'])</form></div>
@endsection