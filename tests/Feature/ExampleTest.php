<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_login_page_returns_a_successful_response(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /**
     * Test that root redirects to login if unauthenticated.
     */
    public function test_root_redirects_to_login_when_unauthenticated(): void
    {
        $response = $this->get('/');

        $response->assertStatus(302);
    }

    /**
     * Test that security headers are present in response.
     */
    public function test_security_headers_are_present(): void
    {
        $response = $this->get('/login');

        $response->assertHeader('Content-Security-Policy');
        $this->assertStringContainsString("form-action 'self'", $response->headers->get('Content-Security-Policy'));
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
    }

    /**
     * Test that 404 error pages also receive security headers.
     */
    public function test_404_page_has_security_headers(): void
    {
        $response = $this->get('/non-existent-page-123456');

        $response->assertStatus(404);
        $response->assertHeader('Content-Security-Policy');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
    }
}
