<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentRequest;
use App\Http\Resources\DocumentCollection;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $this->authorize('viewAny', Document::class);

        return new DocumentCollection(
            Document::when($request->keyword, function ($q) use ($request) {
                $q->where(function ($q) use ($request) {
                    $q->where('title', 'ILIKE', "%{$request->keyword}%")
                        ->orWhere('number', 'ILIKE', "%{$request->keyword}%");
                });
            })->orderBy(
                $request->sort_field ?: 'title',
                $request->sort_direction ?: 'asc'
            )->paginate($request->per_page)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentRequest $request)
    {
        $this->authorize('create', Document::class);
        $document = Document::create($request->all());
        return ['message' => 'Data has been saved', 'data' => $document];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        $this->authorize('view', $document);
        return $document;
    }

    /**
     * Update the specifphp artisan stub:publishied resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentRequest $request, Document $document)
    {
        $this->authorize('update', $document);
        $document->update($request->all());
        return ['message' => 'Data has been updated', 'data' => $document];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        $this->authorize('delete', $document);
        $document->delete();
        return ['message' => 'Data has been deleted'];
    }

    public function favourite(Document $document)
    {
        if (in_array(auth()->user()->id, $document->favourite)) {
            $index = array_search(auth()->user()->id, $document->favourite);
            array_splice($document->favourite, $index, 1);
        } else {
            array_push($document->favourite);
        }

        $document->update(['favorite' => $document->favourite]);
        return response('', 204);
    }

    public function slug($slug)
    {
        return Document::where('slug', $slug)->first();
    }
}
