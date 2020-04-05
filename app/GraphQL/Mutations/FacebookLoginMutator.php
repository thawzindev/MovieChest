<?php

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Facebook;
use App\User;

class FacebookLoginMutator
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
    public function fbLogin($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
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

        $newUser = User::create([
            'name'  => $user['name'],
            'fb_id' => $user['id'],
            'fb_profile_pic_link'   => $user['picture']['url'],
            'password'  => bcrypt($user['id'].$user['name'])
        ]);

        $token = $newUser->createToken($user['name']);

        $newUser['token'] = $token->plainTextToken;

        return $newUser;
    }
}
