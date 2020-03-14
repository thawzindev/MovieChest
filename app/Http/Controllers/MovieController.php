<?php

namespace App\Http\Controllers;
use App\Library\MovieDB;
use Illuminate\Http\Request;
use App\Movie;
use App\MovieGenre;

class MovieController extends Controller
{

	public function __construct()
    {
        $this->moviedb = new MovieDB;   
    }


    public function index()
    {
    	$data = $this->moviedb->getMovie();
   		// return $data;
    	foreach ($data['results'] as $key => $mov) {
    		// return $movie;
    		$movie = Movie::create([
	    			'popularity'	=> $mov['popularity'],
	    			'poster_path'	=> "http://image.tmdb.org/t/p/original/".$mov['poster_path'],
	    			'moviedb_id'	=> $mov['id'],
	    			'title'			=> $mov['title'],
	    			'vote_average'	=> $mov['vote_average'],
	    			'overview'		=> $mov['overview'],
	    			'release_date'	=> $mov['release_date'],
	    		]);


			$movie->genres()->sync($mov['genre_ids']);
    	}


    	return "SUCCESS!";
    }
}
