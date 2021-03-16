<?php

namespace App\Http\Controllers;

use App\Http\Requests\MasterFormRequest;
use App\Http\Resources\MasterFormCollection;
use App\Models\MasterForm;
use Illuminate\Http\Request;

class MasterFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', MasterForm::class);

        return new MasterFormCollection(
            MasterForm::when($request->keyword, function ($q) use ($request) {
                $q->where(function ($q) use ($request) {
                    $q->where('name', 'ILIKE', "%{$request->keyword}%")
                        ->orWhere('description', 'ILIKE', "%{$request->keyword}%");
                });
            })->orderBy(
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
    public function store(MasterFormRequest $request)
    {
        $this->authorize('create', MasterForm::class);

        $masterForm = MasterForm::create(array_merge(
            $request->all(),
            ['owner_id' => auth()->id()]
        ));

        return ['message' => 'Data has been saved', 'data' => $masterForm];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MasterForm  $masterForm
     * @return \Illuminate\Http\Response
     */
    public function show(MasterForm $masterForm)
    {
        $this->authorize('view', $masterForm);
        return $masterForm;
    }

    /**
     * Update the specifphp artisan stub:publishied resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MasterForm  $masterForm
     * @return \Illuminate\Http\Response
     */
    public function update(MasterFormRequest $request, MasterForm $masterForm)
    {
        $this->authorize('update', $masterForm);
        $masterForm->update($request->all());
        return ['message' => 'Data has been updated', 'data' => $masterForm];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MasterForm  $masterForm
     * @return \Illuminate\Http\Response
     */
    public function destroy(MasterForm $masterForm)
    {
        $this->authorize('delete', $masterForm);
        $masterForm->delete();
        return ['message' => 'Data has been deleted'];
    }
}
