<?php

namespace App\Http\Controllers;

use App\Models\DocumentVersion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\DocumentVersionRequest;

class DocumentVersionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', DocumentVersion::class);

        return DocumentVersion::when($request->keyword, function($q) use ($request) {
            $q->where(function($q) use ($request) {
                $q->where('field1', 'ILIKE', "%{$request->keyword}%")
                    ->orWhere('field2', 'ILIKE', "%{$request->keyword}%");
            });
        }) ->orderBy(
            $request->sort_field ?: 'name',
            $request->sort_direction == 'descending' ? 'desc' : 'asc'
        )->paginate($request->per_page);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentVersionRequest $request)
    {
        // $this->authorize('create', DocumentVersion::class);
        $documentVersion = DocumentVersion::create($request->all());
        return ['message' => 'Data has been saved', 'data' => $documentVersion];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DocumentVersion  $documentVersion
     * @return \Illuminate\Http\Response
     */
    public function show(DocumentVersion $documentVersion)
    {
        // $this->authorize('view', $documentVersion);
        return $documentVersion;
    }

    /**
     * Update the specifphp artisan stub:publishied resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DocumentVersion  $documentVersion
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentVersionRequest $request, DocumentVersion $documentVersion)
    {
        // $this->authorize('update', $documentVersion);
        $documentVersion->update($request->all());
        return ['message' => 'Data has been updated', 'data' => $documentVersion];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DocumentVersion  $documentVersion
     * @return \Illuminate\Http\Response
     */
    public function destroy(DocumentVersion $documentVersion)
    {
        $this->authorize('delete', $documentVersion);
        $documentVersion->delete();
        return ['message' => 'Data has been deleted'];
    }
}
