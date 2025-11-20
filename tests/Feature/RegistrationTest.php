<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

describe('authentication test', function(){
    uses(RefreshDatabase::class);
    beforeEach(function(){
        $this->data = [
            'name' => "John",
            'email' => "john@gmail.com",
            'password' => "password",
            'password_confirmation' => "password"
        ];


    });

    test('user can access the login page', function(){
        $this->get('/register')->assertStatus(200);
    });
    
    test('the request failed because of unvalid password', function(){
        $this->post('/register', [
            'name' => "John",
            'email' => "john@gmail.com",
            'password' => 'password',
            'password_confirmation' => 'pass'
        ])
        ->assertSessionHasErrors(['password'])
        ->assertStatus(302);
    });

    test('the user can sign up with success response', function(){
        $this->post('/register', $this->data)
        ->assertStatus(302);
        $this->assertDatabaseHas('users', ['email' => "john@gmail.com"]);
    });

    test('the user email is at null', function(){
        $this->post('/register', $this->data);

        $user = User::where('email', "john@gmail.com")->first();

        expect($user->email_verified_at)->toBeNull();
    });

    test('the user is authenticated', function(){
        $this->post('/register', $this->data)
        ->assertRedirect('/home');

        $this->assertAuthenticated();
    });
});