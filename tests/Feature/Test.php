<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_auth()
    {
        $response = $this->get('/api/articles/list');
        $response->assertStatus(409);

        $response = $this->withToken(config('app.api_key'))->get('/api/articles/list');
        $response->assertStatus(200);
    }

    public function test_404()
    {
        $response = $this->get('/api/artic223les/l232ist');
        $response->assertStatus(404);
    }
}
