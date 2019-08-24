<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use URL;

class HelperController extends Controller
{
    public static function response($status, $msg = '', $data = array(), $extra = array())
    {
        //dump($data);
        if(count($data) == 0 && count($extra) == 0)
            return response(['status' => $status, 'message' => $msg]);
        else if( is_array($extra) and count($extra) == 0)
            return response(['status' => $status, 'message' => $msg, 'data' => $data]);
        else
            return response(['status' => $status, 'message' => $msg, 'data' => $data, $extra]);
    }

    public static function login($email, $password)
    {        
        $http = new Client;
        if($_SERVER["PHP_SELF"] == "/Generic-Incentivisation-Platform/index.php"){
            $url = url('oauth/token');
        }/*elseif($_SERVER["PHP_SELF"] == "vendor/bin/phpunit"){
            $url = url('Generic-Incentivisation-Platform/oauth/token');
        }elseif($_SERVER["PHP_SELF"] == "C:\xampp\htdocs\Generic-Incentivisation-Platform\myApp\vendor\bin\/../phpunit/phpunit/phpunit"){
            $url = url('Generic-Incentivisation-Platform/oauth/token');
        }*/else{
            $url = url('Generic-Incentivisation-Platform/oauth/token');
        }

    	//return $http->post(url('oauth/token'), [
        return $http->post($url, [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => '2',
                'client_secret' => 'VVUqEUwjV14hqcLsnd7EF8KPu7CruwYmDwzkFKBO',
                'username' => $email,
                'password' => $password,
                'scope' => '',
            ],
        ]);
    }

    public static function refreshToken($refresh_token)
    {
        $http = new Client;
        if($_SERVER["PHP_SELF"] == "/Generic-Incentivisation-Platform/index.php"){
            $url = url('oauth/token');
        }else{
            $url = url('Generic-Incentivisation-Platform/oauth/token');
        }
        return $http->post($url, [
            'form_params' => [
                'grant_type' => 'refresh_token',
                'refresh_token' => $refresh_token,
                'client_id' => '2',
                'client_secret' => 'VVUqEUwjV14hqcLsnd7EF8KPu7CruwYmDwzkFKBO',
                'scope' => '',
            ],
            'http_errors' => false // add this to return errors in json
            ]);        
    }


}
