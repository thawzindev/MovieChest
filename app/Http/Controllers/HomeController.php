<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Facebook;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function test()
    {
        // dd(env('FB_APP_SECRET'));
        $fb = new Facebook\Facebook([
          'app_id' => env('FB_APP_ID'),
          'app_secret' => env('FB_APP_SECRET'),
          'default_graph_version' => 'v6.0',
          ]);

        try {
          // Returns a `Facebook\FacebookResponse` object
          $response = $fb->get('/me?fields=id,name,birthday,picture', env('MY_FACEBOOK_TOKEN'));
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
          echo 'Graph returned an error: ' . $e->getMessage();
          exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
          echo 'Facebook SDK returned an error: ' . $e->getMessage();
          exit;
        }

        $user = $response->getGraphUser();

        dd($user);
        // OR
        // echo 'Name: ' . $user->getName();
    }
}
