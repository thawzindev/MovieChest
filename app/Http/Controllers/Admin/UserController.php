<?php

namespace App\Http\Controllers\Admin;

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
}
