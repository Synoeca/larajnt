<?php

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;



class PostsTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_posts_page_contains_empty_table()
    {
        $response = $this->get('/posts');
        $response->assertStatus(200);
        $response->assertSee('No Posts');
    }

    public function test_posts_page_contains_non_empty_table()
    {
        $post = Post::factory()->create(['user_id' => User::factory()]);
        $response = $this->get('/posts');
        $response->assertStatus(200);
        $response->assertDontSee('No Posts');
        $response->assertViewHas('posts', function ($collection) use ($post) {
            return $collection->contains($post);
        });
    }

    public function test_paginated_posts_table_doesnt_contain_7th_record()
    {
        $lastPost = Post::factory(7)->create([ 'user_id' => User::factory() ])->last();
        $response = $this->get('/posts');
        $response->assertStatus(200);
        $response->assertDontSee('No Posts');
        $response->assertViewHas('posts', function ($collection) use ($lastPost) {
            return !$collection->contains($lastPost);
        });
    }
}
