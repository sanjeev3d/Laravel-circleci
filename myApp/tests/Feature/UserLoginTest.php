<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserLoginTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
    
    public function testLoginRoute()
    {       
        $response = $this->call('POST', '/api/authenticate/login');
        $this->assertEquals(422, $response->getStatusCode());
    }

    public function testLoginSuccess()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'localization' => 'en'
        ])
        ->json('POST', '/api/authenticate/login', [
            "email" => "harish.agnitotech@gmail.com",
            "password"  => "Harish@123",            
        ]);        
       // $response->dumpHeaders();
        $response->dump();
        $response
        ->assertJson([
            'status' => 'success',
        ]);
    }
    
    public function testLoginFailed()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'localization' => 'en'
        ])
        ->json('POST', '/api/authenticate/login', [
            "email" => "tapasv729@gmail.com",
            "password"  => "Wrong Password",            
        ]);        
       // $response->dumpHeaders();
        $response->dump();
        $response
        ->assertJson([
            'status' => 'error',
        ]);
    }

    public function testLoginValidationFailed()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'localization' => 'en'
        ])
        ->json('POST', '/api/authenticate/login', [
            "email" => "",
            "password"  => "",
        ]);        
       // $response->dumpHeaders();
        $response->dump();
        $response
        ->assertJson([
            'status' => 'error',
        ]);
    }
}
