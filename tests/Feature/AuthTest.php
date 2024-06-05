<?php

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    public function test_login_failure_redirects_to_login_page()
    {
        User::create([
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => bcrypt('password123')
        ]);
        
        $response = $this->from('/login')->post('login', [
            'email' => 'jnt@jnt.com',
            'password' => 'pwd'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_login_success_redirects_to_previous_url()
    {
        User::create([
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => bcrypt('password123')
        ]);
        
        $response = $this->post('login', [
            'email' => 'user@user.com',
            'password' => 'password123'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/posts');
    }

    public function test_unauthenticated_user_cannot_access_admin()
    {
        $response = $this->get('/admin');
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }

    public function test_unauthenticated_user_cannot_access_todos()
    {
        $response = $this->get('/todos');
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }
}
