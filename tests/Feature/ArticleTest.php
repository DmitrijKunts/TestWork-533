<?php

namespace Tests\Feature;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    public function test_list()
    {
        $response = $this->withToken(config('app.api_key'))->get('/api/articles/list');
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
        $response->assertJsonPath('articles.0.body', fn ($v) => $v != '');
        $response->assertJsonPath('articles.0.tags.0.priority', fn ($v) => $v != '');
    }

    public function test_get()
    {
        $a = Article::findOrFail(2);
        $response = $this->withToken(config('app.api_key'))->get('/api/articles/2');
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
        $response->assertJsonPath('articles.title', $a->title);
        $response->assertJsonPath('articles.tags.0.priority', fn ($v) => $v != '');
    }

    public function test_search()
    {
        $response = $this->withToken(config('app.api_key'))
            ->get('/api/articles/search?field=title22');
        $response->assertStatus(422);

        $response = $this->withToken(config('app.api_key'))
            ->get('/api/articles/search?sort=title22');
        $response->assertStatus(422);

        $a = Article::findOrFail(2);
        $response = $this->withToken(config('app.api_key'))
            ->get('/api/articles/search?field=title&value=' . $a->title . '&sort=name');
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
        $response->assertJsonPath('articles.0.title', $a->title);
        $response->assertJsonPath('articles.0.tags.0.priority', fn ($v) => $v != '');
    }
}
