@extends('layouts.app', ['title' => 'Add user'])

@section('content')
<div class="mx-auto max-w-2xl"><a href="{{ route('users.index') }}" class="text-sm font-semibold text-orange-600">← Back to users</a><h1 class="mt-6 text-4xl font-black tracking-tight">Add a user</h1><p class="mt-2 text-stone-500">Create an account and assign a project role.</p>
<form method="POST" action="{{ route('users.store') }}" class="mt-8 space-y-6 border border-stone-200 bg-white p-6 shadow-sm">@csrf @include('users.form', ['submitLabel' => 'Create user'])</form></div>
@endsection