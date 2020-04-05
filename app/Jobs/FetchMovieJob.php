<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Movie;
use App\Cast;
use App\MovieGenre;
use App\Library\MovieDB;

class FetchMovieJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $from;
    protected $to;
    protected $moviedb;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
        $this->moviedb = new MovieDB;   
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = $this->moviedb->getMovie();
        foreach ($data['results'] as $key => $mov) {
                $movie = Movie::create([
                        'popularity'    => $mov['popularity'],
                        'poster_path'   => "http://image.tmdb.org/t/p/original/".$mov['poster_path'],
                        'moviedb_id'    => $mov['id'],
                        'title'         => $mov['title'],
                        'vote_average'  => $mov['vote_average'],
                        'overview'      => $mov['overview'],
                        'release_date'  => $mov['release_date'],
                    ]);

                    $movie->genres()->sync($mov['genre_ids']);

            $casts = $this->moviedb->getCasts($mov['id']);

            foreach ($casts['cast'] as $key => $val) {
                Cast::create([
                    'movie_id'  => $movie->id,
                    'cast_id'   => $val['cast_id'],
                    'character' => $val['character'],
                    'credit_id' => $val['credit_id'],
                    'gender'    => $val['gender'],
                    'caster_id' => $val['id'],
                    'name'      => $val['name'],
                    'order'     => $val['order'],
                    'profile_path'  => "http://image.tmdb.org/t/p/original".$val['profile_path'],
                ]);
            }
        }
    }
}
