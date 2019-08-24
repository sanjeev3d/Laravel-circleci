<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserRegisterTest extends TestCase
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

    public function testRegisterRoute()
    {       
        $response = $this->call('POST', '/api/authenticate/register');
        $this->assertEquals(422, $response->getStatusCode());
    }

    public function testRegisterSuccessfully()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'localization' => 'en'
        ])
        ->json('POST', '/api/authenticate/register', [
            "username"  => "tapasv729",
            "email" => "tapasv729@gmail.com",
            "password"  => "Tapas@123",
            "first_name"    => "Tapas",
            "last_name" => "Vishwas",
            //"activation_code"   => "a123",
            "external_id"   => "external id 2222",
            "metadata"  => "hello",
            "timezone"  => "asia/calcutta",
            "dob" => "21 Aug 2019",
            "phone" => "+919827764969",
        ]);        
       // $response->dumpHeaders();
        $response->dump();
        $response
        ->assertJson([
            'status' => 'success',
        ]);
    }

    public function testRegisterValidation()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'localization' => 'en'
        ])
        ->json('POST', '/api/authenticate/register', [
            "username"  => "",
            "email" => "tapasv729@gmail",
            "password"  => "",
            "first_name"    => "",
            "last_name" => "",
            "activation_code"   => "a123",
            "external_id"   => "external id 2222",
            "metadata"  => "hello",
            "timezone"  => "asia/calcutta",
        ]);        
       // $response->dumpHeaders();
        $response->dump();
        $response
        ->assertJson([
            'status' => 'error',
        ]);
    }

    public function testRegisterInValidActivationCode()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'localization' => 'en'
        ])
        ->json('POST', '/api/authenticate/register', [
            "username"  => "tapasv729",
            "email" => "tapasv729@gmail.com",
            "password"  => "Tapas@123",
            "first_name"    => "Tapas",
            "last_name" => "Vishwas",
            "activation_code"   => "Invalid Activation Code",
            "external_id"   => "external id 2222",
            "metadata"  => "hello",
            "timezone"  => "asia/calcutta",
        ]);        
       // $response->dumpHeaders();
        $response->dump();
        $response
        ->assertJson([
            'status' => 'error',
        ]);
    }
}
