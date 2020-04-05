<?php

namespace App\Library;

use App\Aws\S3\MultipartUploader;
use App\Http\Controllers\Controller;
use Aws\Exception\MultipartUploadException;
use Aws\S3\S3Client;
use GuzzleHttp\Client;
use Illuminate\Http\Request;


class MovieDB
{
    /**
     * Create Auth Header
     * @return [type] [description]
     */

    public function get_auth_header()
    {
        // base64 encode client/client secret


        $client = new Client();

        $response = $client->post('https://oauth.brightcove.com/v3/access_token?grant_type=client_credentials',
            [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Authorization' => 'Basic ' . $credentials,
                ],
            ]);

        try {
            $status_code = $response->getStatusCode();
            $obj = json_decode($response->getBody());
            $AT = $obj->access_token;
            return array('Authorization' => ' Bearer ' . $AT, 'Content-Type: ' => 'application/json');

        } catch (\Exception $e) {
            echo $e->getResponse()->getBody();
        }

    }

    /**
     * Step 1: CMS API POST request to create the video object in Video Cloud (same as for pull-based ingestion)
     * @return function
     */

    public function getMovie($date='')
    {
        $client = new Client();
        $key = env('MOVIEDB_KEY');

        $response = $client->get("https://api.themoviedb.org/3/movie/now_playing?api_key=$key&append_to_response=videos");
        $obj = json_decode($response->getBody(), true);
        // dd($obj);
        return $obj;
    }

    public function getCasts($movieID)
    {
        $client = new Client();
        $key = env('MOVIEDB_KEY');

        $response = $client->get("https://api.themoviedb.org/3/movie/$movieID/credits?api_key=$key&append_to_response=videos");
        $obj = json_decode($response->getBody(), true);
        // dd($obj);
        return $obj;
    }


    public function searchByCastID($id)
    {
        $client = new Client();
        $key = env('MOVIEDB_KEY');

        $response = $client->get("https://api.themoviedb.org/3/person/$id?api_key=$key&append_to_response=credits");
        $obj = json_decode($response->getBody(), true);
        // dd($obj);
        return $obj;
    }

    public function getGenre()
    {
        $client = new Client();
        $key = env('MOVIEDB_KEY');

        $response = $client->get("https://api.themoviedb.org/3/genre/movie/list?api_key=$key");
        $obj = json_decode($response->getBody(), true);
        // dd($obj);
        return $obj;
    }

}