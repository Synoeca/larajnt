<?php

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_page_should_validate_name()
    {
        $response = $this->from('/register')->post('register', [
            'name' => '',
            'email' => 'jntcompany@jnt.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ]);
        $error_response = $this->get('/register');
        $error_response->assertSee('The name field is required.');
        $response->assertStatus(302);
        $response->assertRedirect('/register');


        $response = $this->from('/register')->post('register', [
            'name' => 'jnt',
            'email' => 'jntcompany@jnt.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ]);
        $error_response = $this->get('/register');
        $error_response->assertSee('The name field must be at least 5 characters.');
        $response->assertStatus(302);
        $response->assertRedirect('/register');


        $response = $this->from('/register')->post('register', [
            'name' => 'jntcompany',
            'email' => 'jntcompany@jnt.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ]);
        $error_response = $this->get('/register');
        $error_response->assertDontSee('The name field is required.');
        $error_response->assertDontSee('The name field must be at least 5 characters.');
        $response->assertStatus(302);
        $response->assertRedirect('/posts');
        
    }

    public function test_register_page_should_validate_email()
    {
        User::factory()->create(['email' => 'admin@example.com']);
        
        $response = $this->from('/register')->post('register', [
            'name' => 'jntcompany',
            'email' => '',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ]);
        $error_response = $this->get('/register');
        $error_response->assertSee('The email field is required.');
        $response->assertStatus(302);
        $response->assertRedirect('/register');


        $response = $this->from('/register')->post('register', [
            'name' => 'jntcompany',
            'email' => 'jnt.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/register');


        $response = $this->from('/register')->post('register', [
            'name' => 'jntcompany',
            'email' => 'admin@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ]);
        $error_response = $this->get('/register');
        $error_response->assertSee('The email has already been taken.');
        $response->assertStatus(302);
        $response->assertRedirect('/register');


        $response = $this->from('/register')->post('register', [
            'name' => 'jntcompany',
            'email' => 'admin@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ]);
        $error_response = $this->get('/register');
        $error_response->assertSee('The email has already been taken.');
        $response->assertStatus(302);
        $response->assertRedirect('/register');


        $response = $this->from('/register')->post('register', [
            'name' => 'jntcompany',
            'email' => 'jnt@jntcompany.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ]);
        $error_response = $this->get('/register');
        $error_response->assertDontSee('The email field is required.');
        $error_response->assertDontSee('The email has already been taken.');
        $response->assertStatus(302);
        $response->assertRedirect('/posts');
    }

    public function test_register_page_should_validate_password()
    {
        User::factory()->create(['email' => 'admin@example.com']);
        
        $response = $this->from('/register')->post('register', [
            'name' => 'jntcompany',
            'email' => 'jnt@jntcompany.com',
            'password' => '',
            'password_confirmation' => 'password123'
        ]);
        $error_response = $this->get('/register');
        $error_response->assertSee('The password field is required.');
        $response->assertStatus(302);
        $response->assertRedirect('/register');

        $response = $this->from('/register')->post('register', [
            'name' => 'jntcompany',
            'email' => 'jnt@jntcompany.com',
            'password' => 'password123',
            'password_confirmation' => ''
        ]);
        $error_response = $this->get('/register');
        $error_response->assertSee('The password field confirmation does not match.');
        $response->assertStatus(302);
        $response->assertRedirect('/register');


        $response = $this->from('/register')->post('register', [
            'name' => 'jntcompany',
            'email' => 'jnt@jntcompany.com',
            'password' => 'pwd',
            'password_confirmation' => 'pwd'
        ]);
        $error_response = $this->get('/register');
        $error_response->assertSee('The password field must be at least 8 characters.');
        $response->assertStatus(302);
        $response->assertRedirect('/register');


        $response = $this->from('/register')->post('register', [
            'name' => 'jntcompany',
            'email' => 'jnt@jntcompany.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ]);
        $error_response = $this->get('/register');
        $error_response->assertDontSee('The password field is required.');
        $error_response->assertDontSee('The password field confirmation does not match.');
        $error_response->assertDontSee('The password field must be at least 8 characters.');
        $response->assertStatus(302);
        $response->assertRedirect('/posts');
    }
}