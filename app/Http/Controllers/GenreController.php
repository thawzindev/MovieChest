<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\MovieDB;
use App\Genre;

class GenreController extends Controller
{

	public function __construct()
    {
        $this->moviedb = new MovieDB;   
    }

    public function index()
    {
    	$data = $this->moviedb->getGenre();
        foreach ($data['genres'] as $key => $genre) {
        	Genre::create([
        		'genre_id'	=> $genre['id'],
        		'name'		=> $genre['name'],
        	]);
        }

        return "SUCCESS!";
    }
}
