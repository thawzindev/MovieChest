<?php

namespace App\Http\Controllers\Admin;

use GuzzleHttp\Client;
use App\User;
use App\Filters\UserFilter;
use Illuminate\Http\Request;
use App\Library\MovieDB;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{

    public function __construct()
    {
        $this->moviedb = new MovieDB;   
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserFilter $filter)
    {
        if (request()->expectsJson()) {
            $name = request('q');
            $users = User::select('id', 'name')
                ->where('name', 'LIKE', "%{$name}%")
                ->limit(5)
                ->get();

            return response($users);
        }
        
        $users = User::filter($filter)->paginate();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = config('form.roles');

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt(request('password'));

        User::create($data);

        return redirect()
            ->route('admin.users.index')
            ->with('flash', 'Create User Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = config('form.roles');

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        unset($data['password']);

        if ($password = request('password')) {
            $data['password'] = bcrypt($password);
        }

        $user->update($data);

        return redirect()
            ->route('admin.users.index')
            ->with('flash', 'Update User Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return back();
    }

    public function test()
    {
        $data = $this->moviedb->test();
        return $data;
    }

    public function testing()
    {
        $client = new Client();
        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvYXBpXC9hZGRfcGluX2NvZGUiLCJpYXQiOjE1ODQzMjgyMDksImV4cCI6MTU4NDU0NDIwOSwibmJmIjoxNTg0MzI4MjA5LCJqdGkiOiJnWnFNTVp2bXVwcVV6cDRkIiwic3ViIjozLCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIn0.SnvY-4C1xxQAe2GkBJkoTqcgBocaf_KgSGvKupvTZ5w";

        $url = "localhost:8000/api/cash-in";

        $response = $client->get($url,
        [
            'headers' => [
                'Authorization' => 'bearer ' . $token,
            ],
        ]);

        // $data = json_decode($response, true);
        return $response;
    }
}
