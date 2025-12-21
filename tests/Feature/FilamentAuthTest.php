<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('filament login page loads', function () {
    $this->get('/admin/login')->assertStatus(200);
});

// Dashboard access behavior may vary by panel policies; focusing on auth pages.


test('filament register page loads', function () {
    $this->get('/admin/register')->assertStatus(200);
});
