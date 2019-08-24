<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserLogoutTest extends TestCase
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
    
    public function testLogoutSuccess()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'localization' => 'en',
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjlmOWUxN2U3Y2Y5MTg3OWIwMDllODUwMWMyYTAzZWJlMmY4ZTcyZGZmODYyODVkODM2Njk0NjAxZWQzY2ZkMDNhOWNhZGRhNWQxMjI3MGZjIn0.eyJhdWQiOiIyIiwianRpIjoiOWY5ZTE3ZTdjZjkxODc5YjAwOWU4NTAxYzJhMDNlYmUyZjhlNzJkZmY4NjI4NWQ4MzY2OTQ2MDFlZDNjZmQwM2E5Y2FkZGE1ZDEyMjcwZmMiLCJpYXQiOjE1NjYzNzQ1MzgsIm5iZiI6MTU2NjM3NDUzOCwiZXhwIjoxNTk3OTk2OTM4LCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.UHE6Ly2lcTHeiRJhAgwtTHbw_rKFKH8gAEhE_DpUuC-AH0--nlU1O94MIS7IEZqyCwmUbm5imuZ4cytiT0PCU2zkEsdEZ3HmJGaVDWmoVi3xsZNBLbZPKnGvYagdJLkRdbW6UIzABdgZIX3HtOW-iXn7TIHQw_UMOTaXSkZeMyvPNdHM1jrJcTsGyN1XDpxhLA_mM3SXAyRMBVgNv4XNAQjLk9926ClPqnkic2Mlt-g28sNiXJlBK9zy7Cog2xindRKyUCzIGKvexy0UYxRC4V_etxl5ax8xPMyZrEzfRd-PnHEUuzqm1RitF4bYLgR_iDx8JyncY32dBj-vEjZ3K6uoUBlqAKAZrEzkEvTWkLC0yMlDsbzc39586i0sStvrh7T4agcSm4sxz-P2IZpzaUr8fU3xeNRgliwK1lfauO1sL2AJ-EcjNL-P3rSjqzmiMlPTPstTYhvWMpz_myi7HHcyR45dihUVqx22q_qGLtaAtQNV7WZjm46s56bRTKoqXPeV4odRamzs_F_gk5wrkdKAh8IjDbg7ONdI2hH4e3Dybu68aaVEPF112qS0rcU3ni2xjUIm5S5JMKWU-Xbe88_LVG49VFO-mrzZppL_bpW3bLaOW0zTrcCTd9A4DXr093fQjgOKJIIesb0Kt3XVn0gYzeluH7KWZV2aaUrkFfs'
        ])
        ->json('POST', '/api/logout');        
       // $response->dumpHeaders();
        $response->dump();
        $response
        ->assertJson([
            'status' => 'success',
        ]);
    }
    
    public function testLogoutFailed()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'localization' => 'en'
        ])
        ->json('POST', '/api/logout');        
       // $response->dumpHeaders();
        $response->dump();
        $response
        ->assertJson([
            'status' => 'error',
        ]);
    }
}
