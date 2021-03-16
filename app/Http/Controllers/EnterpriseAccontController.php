<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnterpriseAccontRequest;
use App\Http\Resources\EnterpriseAccontCollection;
use App\Models\EnterpriseAccont;
use Illuminate\Http\Request;

class EnterpriseAccontController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', EnterpriseAccont::class);

        return new EnterpriseAccontCollection(
            EnterpriseAccont::when($request->keyword, function($q) use ($request) {
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
    public function store(EnterpriseAccontRequest $request)
    {
        $this->authorize('create', EnterpriseAccont::class);
        $enterpriseAccont = EnterpriseAccont::create($request->all());
        return ['message' => 'Data has been saved', 'data' => $enterpriseAccont];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EnterpriseAccont  $enterpriseAccont
     * @return \Illuminate\Http\Response
     */
    public function show(EnterpriseAccont $enterpriseAccont)
    {
        $this->authorize('view', $enterpriseAccont);
        return $enterpriseAccont;
    }

    /**
     * Update the specifphp artisan stub:publishied resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EnterpriseAccont  $enterpriseAccont
     * @return \Illuminate\Http\Response
     */
    public function update(EnterpriseAccontRequest $request, EnterpriseAccont $enterpriseAccont)
    {
        $this->authorize('update', $enterpriseAccont);
        $enterpriseAccont->update($request->all());
        return ['message' => 'Data has been updated', 'data' => $enterpriseAccont];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EnterpriseAccont  $enterpriseAccont
     * @return \Illuminate\Http\Response
     */
    public function destroy(EnterpriseAccont $enterpriseAccont)
    {
        $this->authorize('delete', $enterpriseAccont);
        $enterpriseAccont->delete();
        return ['message' => 'Data has been deleted'];
    }
}
