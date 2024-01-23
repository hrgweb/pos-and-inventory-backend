<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionSessionTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_a_transaction_session(): void
    {
        $response = $this->postJson(route('transaction_sessions.store'), [])
            ->assertCreated();

        $this->assertDatabaseHas('transaction_sessions', ['session_no' => $response['session_no']]);
    }
}
