<?php

namespace App\GraphQL\Queries;

use App\Exceptions\CustomException;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Movie;

class MovieQuery
{
    /**
     * Return a value for the field.
     *
     * @param  null  $rootValue Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param  mixed[]  $args The arguments that were passed into the field.
     * @param  \Nuwave\Lighthouse\Support\Contracts\GraphQLContext  $context Arbitrary data that is shared between all fields of a single query.
     * @param  \GraphQL\Type\Definition\ResolveInfo  $resolveInfo Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     * @return mixed
     */
    public function addCount($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {

        // throw new CustomException(
        //         422,
        //         'The reason why this error was thrown, is rendered in the extension output.'
        //     );

        $movie = Movie::orderBy('id', 'desc')->paginate(5,['*'],'page',1);
        // dd($movie);
        // return $movie;
        return [
            "data" => $movie,
            "page" => [
                "currentPage" => 120,
                "count" => $movie->count(),
                "lastPage"  => $movie->lastPage(),
            ]
        ];
    }
}
