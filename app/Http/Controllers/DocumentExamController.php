<?php

namespace App\Http\Controllers;

use App\Models\DocumentExam;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DocumentExamCollection;
use App\Http\Requests\DocumentExamRequest;

class DocumentExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', DocumentExam::class);

        return new DocumentExamCollection(
            DocumentExam::when($request->keyword, function($q) use ($request) {
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
    public function store(DocumentExamRequest $request)
    {
        $this->authorize('create', DocumentExam::class);
        $documentExam = DocumentExam::create($request->all());
        return ['message' => 'Data has been saved', 'data' => $documentExam];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DocumentExam  $documentExam
     * @return \Illuminate\Http\Response
     */
    public function show(DocumentExam $documentExam)
    {
        $this->authorize('view', $documentExam);
        return $documentExam;
    }

    /**
     * Update the specifphp artisan stub:publishied resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DocumentExam  $documentExam
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentExamRequest $request, DocumentExam $documentExam)
    {
        $this->authorize('update', $documentExam);
        $documentExam->update($request->all());
        return ['message' => 'Data has been updated', 'data' => $documentExam];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DocumentExam  $documentExam
     * @return \Illuminate\Http\Response
     */
    public function destroy(DocumentExam $documentExam)
    {
        $this->authorize('delete', $documentExam);
        $documentExam->delete();
        return ['message' => 'Data has been deleted'];
    }
}
