<?php

namespace App\Http\Controllers;
use App\Library\MovieDB;
use Illuminate\Http\Request;
use App\Movie;
use App\MovieGenre;
use App\Jobs\FetchMovieJob;

class MovieController extends Controller
{

	public function __construct()
    {
        $this->moviedb = new MovieDB;   
    }


    public function index()
    {
        $access_token = 'EAAL053iOA9QBADPIc67cDkIwNQTU4xwx92KbdYxkV6kVI92EhP1JdNCJBfX6aTumJBGrZAaDoYXJ0LZBmv2vtZAd7UJPvVY4NCdpmYNiyVBvIMMfS2YZAJfZBERjj506exXHh88yRU07qlkKURZAl9BMck6P9Usu1GOvlUYPa5yunfFZCDCMRxBzZC7gdQZBDACtVWwmayzAWS0PRfe47wilOyANPJGBG3mvVCnMAqdMPvEzvSXyHU34QLX7zaB9awMsZD';

        $appsecret_proof= hash_hmac('sha256', $access_token, 'f5866bff80c6aca6c2dd5c0beced3396'); 
            $fields = 'id,email,name,picture'; 

            $query = http_build_query([
                'access_token'    => $access_token,
                'appsecret_proof' => $appsecret_proof,
                'fields'          => $fields
            ]);
            $endpoint = 'https://graph.facebook.com/v3.0/me?'. $query;

            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $endpoint,
                CURLOPT_RETURNTRANSFER => true,
            ]);
            $server_output = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $data = json_decode($server_output, true);   
            dd($data);


    	return "SUCCESS!";
    }
}
