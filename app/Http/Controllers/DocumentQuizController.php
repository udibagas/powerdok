<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentQuizRequest;
use App\Http\Resources\DocumentQuizCollection;
use App\Models\DocumentQuiz;
use Illuminate\Http\Request;

class DocumentQuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', DocumentQuiz::class);

        return new DocumentQuizCollection(
            DocumentQuiz::when($request->keyword, function ($q) use ($request) {
                $q->where(function ($q) use ($request) {
                    $q->where('field1', 'ILIKE', "%{$request->keyword}%")
                        ->orWhere('field2', 'ILIKE', "%{$request->keyword}%");
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
    public function store(DocumentQuizRequest $request)
    {
        // $this->authorize('create', DocumentQuiz::class);
        $documentQuiz = DocumentQuiz::create($request->all());
        return ['message' => 'Data has been saved', 'data' => $documentQuiz];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DocumentQuiz  $documentQuiz
     * @return \Illuminate\Http\Response
     */
    public function show(DocumentQuiz $documentQuiz)
    {
        $this->authorize('view', $documentQuiz);
        return $documentQuiz;
    }

    /**
     * Update the specifphp artisan stub:publishied resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DocumentQuiz  $documentQuiz
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentQuizRequest $request, DocumentQuiz $documentQuiz)
    {
        $this->authorize('update', $documentQuiz);
        $documentQuiz->update($request->all());
        return ['message' => 'Data has been updated', 'data' => $documentQuiz];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DocumentQuiz  $documentQuiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(DocumentQuiz $documentQuiz)
    {
        $this->authorize('delete', $documentQuiz);
        $documentQuiz->delete();
        return ['message' => 'Data has been deleted'];
    }
}
