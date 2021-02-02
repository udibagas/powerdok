<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserGroupRequest;
use App\Http\Resources\UserGroupCollection;
use App\Models\UserGroup;
use Illuminate\Http\Request;

class UserGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', UserGroup::class);

        return new UserGroupCollection(
            UserGroup::when($request->keyword, function($q) use ($request) {
                $q->where(function($q) use ($request) {
                    $q->where('field1', 'ILIKE', "%{$request->keyword}%")
                        ->orWhere('field2', 'ILIKE', "%{$request->keyword}%");
                });
            }) ->orderBy(
                $request->sort_field ?: 'name',
                $request->sort_direction == 'descending' ? 'desc' : 'asc'
            )->paginate($request->per_page)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserGroupRequest $request)
    {
        $this->authorize('create', UserGroup::class);
        $userGroup = UserGroup::create($request->all());
        return ['message' => 'Data has been saved', 'data' => $userGroup];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserGroup  $userGroup
     * @return \Illuminate\Http\Response
     */
    public function show(UserGroup $userGroup)
    {
        $this->authorize('view', $userGroup);
        return $userGroup;
    }

    /**
     * Update the specifphp artisan stub:publishied resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserGroup  $userGroup
     * @return \Illuminate\Http\Response
     */
    public function update(UserGroupRequest $request, UserGroup $userGroup)
    {
        $this->authorize('update', $userGroup);
        $userGroup->update($request->all());
        return ['message' => 'Data has been updated', 'data' => $userGroup];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserGroup  $userGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserGroup $userGroup)
    {
        $this->authorize('delete', $userGroup);
        $userGroup->delete();
        return ['message' => 'Data has been deleted'];
    }
}
