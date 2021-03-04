<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentRequest;
use App\Http\Resources\DocumentCollection;
use App\Models\Document;
use App\Models\DocumentQuiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            })->when($request->has_quizzes, function($q) use ($request) {
                $q->whereHas('quizzes');
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

    public function saveQuiz(Document $document, Request $request)
    {
        $request->validate([
            'minimum_score' => 'required|numeric',
            'quizzes.*.question' => 'required',
            'quizzes.*.choices' => ['required', 'array', 'size:4', function($attribute, $value, $fail) {
                $hasBlankAnswer = array_search("", $value);
                if ($hasBlankAnswer !== false) {
                    $fail('Choices is required');
                }
            }],
            'quizzes.*.correct_answer' => 'required',
        ], [
            'quizzes.*.question.required' => 'Question is required',
            'quizzes.*.choices.required' => 'Choices is required',
            'quizzes.*.correct_answer.required' => 'Correct Answer is required',
        ]);

        DB::transaction(function () use ($document, $request) {
            foreach ($request->quizzes as $q) {
                if (isset($q['id'])) {
                    $quiz = DocumentQuiz::find($q['id']);
                    $quiz->update($q);
                    if (isset($quiz['attachments'])) {
                        $quiz->attachments()->delete();
                        $quiz->attachments()->createMany($q['attachments']);
                    }
                } else {
                    $quiz = $document->quizzes()->create($q);
                    if (isset($q['attachments'])) {
                        $quiz->attachments()->createMany($q['attachments']);
                    }
                }
            }

            $document->update(['minimum_score' => $request->minimum_score]);
        });

        return ['message' => 'Question has been saved'];
    }

    public function getQuiz(Document $document)
    {
        return $document->quizzes;
    }

    public function deleteQuiz(DocumentQuiz $documentQuiz)
    {
        DB::transaction(function () use ($documentQuiz) {
            $documentQuiz->attachments()->delete();
            $documentQuiz->delete();
        });

        return ['message' => 'Question has been deleted'];
    }
}
