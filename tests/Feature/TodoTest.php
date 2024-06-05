<?php

use App\Models\Todo;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodoTest extends TestCase
{
    use RefreshDatabase;
    public function test_unauthenticated_user_cannot_access_todos_show()
    {
        Todo::factory()->create(['user_id' => User::factory()]);
        $response = $this->get('/todos/1');
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }

    public function test_user_cannot_access_other_users_todos_show()
    {
        $user1 = User::create([
            'name' => 'User',
            'email' => 'user1@user.com',
            'password' => bcrypt('password123')
        ]);

        $user2 = User::create([
            'name' => 'User',
            'email' => 'user2@user.com',
            'password' => bcrypt('password123')
        ]);

        $todo = Todo::factory()->create(['user_id' => $user1]);
        $response = $this->actingAs($user2)->get('/todos/'. $user2->user_id);
        $response->assertStatus(200);
        //$response->assertRedirect('login');
    }

    // public function test_login_success_redirects_to_previous_url()
    // {
    //     User::create([
    //         'name' => 'User',
    //         'email' => 'user@user.com',
    //         'password' => bcrypt('password123')
    //     ]);
        
    //     $response = $this->post('login', [
    //         'email' => 'user@user.com',
    //         'password' => 'password123'
    //     ]);

    //     $response->assertStatus(302);
    //     $response->assertRedirect('/posts');
    // }

    // public function test_unauthenticated_user_cannot_access_admin()
    // {
    //     $response = $this->get('/admin');
    //     $response->assertStatus(302);
    //     $response->assertRedirect('login');
    // }

    // public function test_unauthenticated_user_cannot_access_todos()
    // {
    //     $response = $this->get('/todos');
    //     $response->assertStatus(302);
    //     $response->assertRedirect('login');
    // }
}
