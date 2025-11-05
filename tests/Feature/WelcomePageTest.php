<?php

namespace Tests\Feature;

use Tests\TestCase;

class WelcomePageTest extends TestCase
{
    /**
     * Test welcome page loads successfully.
     */
    public function test_welcome_page_loads(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('iLab UNMUL');
        $response->assertSee('Pusat Unggulan Studi Tropis');
    }
}
