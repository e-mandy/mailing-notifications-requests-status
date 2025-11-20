<?php

describe('authentication test', function(){

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
        ->assertStatus(201)
        ->assertDatabaseHas('users', ['email' => "john@gmail.com"]);
    });
});