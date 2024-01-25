<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OAuthTest extends TestCase
{
    public function test_authorize_redirect_url(): void
    {
        $response = $this->get(route('oauth.redirect'));

        $response->assertFound();
    }

    public function test_authorize_callback_url(): void
    {
        $this->get(route('oauth.callback'))
            ->assertOk();
    }
}
