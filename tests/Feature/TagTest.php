<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\ArticleTag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagTest extends TestCase
{
    public function test_list()
    {
        $response = $this->withToken(config('app.api_key'))->get('/api/tags/list');
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
        $response->assertJsonPath('tags.0.name', fn ($v) => $v != '');
        $response->assertJsonPath('tags.0.articles.0.priority', fn ($v) => $v != '');
    }

    public function test_get()
    {
        $a = ArticleTag::findOrFail(2);
        $response = $this->withToken(config('app.api_key'))->get('/api/tags/2');
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
        $response->assertJsonPath('tags.name', $a->name);
        $response->assertJsonPath('tags.articles.0.priority', fn ($v) => $v != '');
    }

    public function test_search()
    {


        $response = $this->withToken(config('app.api_key'))
            ->get('/api/tags/search?field=title22');
        $response->assertStatus(422);

        $response = $this->withToken(config('app.api_key'))
            ->get('/api/tags/search?sort=title22');
        $response->assertStatus(422);

        $a = ArticleTag::findOrFail(2);
        $response = $this->withToken(config('app.api_key'))
            ->get('/api/tags/search?field=name&value=' . $a->name . '&sort=priority');
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
        $response->assertJsonPath('tags.0.name', $a->name);
        $response->assertJsonPath('tags.0.articles.0.priority', fn ($v) => $v != '');
    }
}
