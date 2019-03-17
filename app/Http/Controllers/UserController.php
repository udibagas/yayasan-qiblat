<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Donation;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkRole:' . \App\User::ROLE_ADMIN);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort = $request->sort ? $request->sort : 'name';
        $order = $request->order == 'ascending' ? 'asc' : 'desc';

        return User::when($request->keyword, function ($q) use ($request) {
            return $q->where('name', 'LIKE', '%' . $request->keyword . '%')
                ->orWhere('email', 'LIKE', '%' . $request->keyword . '%');
        })->when($request->role, function ($q) use ($request) {
            return $q->whereIn('role', $request->role);
        })->when($request->status, function ($q) use ($request) {
            return $q->whereIn('status', $request->status);
        })->orderBy($sort, $order)->paginate($request->pageSize);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:0,1,9',
            'status' => 'required|boolean'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($request->password);
        $input['api_token'] = str_random(60);
        return User::create($input);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => ['required', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|in:0,1,9',
            'status' => 'required|boolean'
        ];

        $input = $request->all();

        if ($request->password) {
            $rules['password'] = 'required|string|min:6|confirmed';
            $input['password'] = Hash::make($request->password);
        }

        $request->validate($rules);
        $user->update($input);
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->user()->id) {
            return response(['message' => 'Tidak boleh menghapus user sendiri'], 500);
        }

        $hasDonation = Donation::where('user_id', $user->id)->get();

        if ($hasDonation) {
            return response(['message' => 'User memiliki data donasi'], 500);
        }

        $user->delete();
        return ['message' => 'OK'];
    }
}
