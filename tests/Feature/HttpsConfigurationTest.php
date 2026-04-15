<?php

namespace Tests\Feature;

use Tests\TestCase;

class HttpsConfigurationTest extends TestCase
{
    public function test_login_form_uses_https_when_request_comes_through_a_secure_proxy(): void
    {
        $response = $this
            ->withServerVariables([
                'HTTP_HOST' => 'agroventas.internal',
                'HTTP_X_FORWARDED_HOST' => 'secure.agroventas.test',
                'HTTP_X_FORWARDED_PROTO' => 'https',
                'HTTP_X_FORWARDED_PORT' => '443',
            ])
            ->get('/login');

        $response->assertOk();
        $response->assertSee('action="https://secure.agroventas.test/login"', false);
    }
}
