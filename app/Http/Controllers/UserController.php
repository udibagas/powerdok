<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = User::when($request->keyword, function ($q) use ($request) {
            $q->where(function ($q) use ($request) {
                $q->where('name', 'ILIKE', "%{$request->keyword}%")
                    ->orWhere('email', 'ILIKE', "%{$request->keyword}%")
                    ->orWhere('position', 'ILIKE', "%{$request->keyword}%")
                    ->orWhereHas('department', function ($q) use ($request) {
                        $q->where('name', 'ILIKE', "%{$request->keyword}%");
                    });
            });
        })->orderBy($request->sort_field ?: 'name', $request->sort_direction ?: 'asc');

        return $request->paginated ? $data->paginate($request->per_page) : $data->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $user = User::create($request->all());
        return response(['message' => 'Data has been saved', 'data' => $user], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->all());
        return response(['message' => 'Data has been updated', 'data' => $user], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response(['message' => 'Data has been deleted', 'data' => $user], 201);
    }
}
