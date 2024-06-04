<?php

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use function Pest\Laravel\get;

it('/posts returns a successful response', function () {
    $response = $this->get('/posts');

    $response->assertStatus(200);
});

test('homepage contains non empty table', function () { 
    Post::create([
        'user_id' => 1,
        'title'  => 'Testing Post 1',
        'content' => '12345678910111213',
        'thumbnail' => ""
    ]);
 
    get('/posts')
        ->assertStatus(200)
        ->assertDontSee(__('No Posts'));
}); 
