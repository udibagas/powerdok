<?php

namespace App\Http\Controllers;

use App\Http\Requests\LanguageRequest;
use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Language::when($request->keyword, function ($q) use ($request) {
            $q->where(function ($q) use ($request) {
                $q->where('locale', 'ILIKE', "%{$request->keyword}%")
                    ->orWhere('key', 'ILIKE', "%{$request->keyword}%")
                    ->orWhere('text', 'ILIKE', "%{$request->keyword}%");
            });
        })->paginate($request->per_page);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LanguageRequest $request)
    {
        $language = Language::create($request->all());
        return response(['message' => 'Data has been saved', 'data' => $language], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Language $language)
    {
        return $language;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LanguageRequest $request, Language $language)
    {
        $language->update($request->all());
        return response(['message' => 'Data has been updated', 'data' => $language], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Language $language)
    {
        $language->delete();
        return response(['message' => 'Data has been deleted', 'data' => $language], 201);
    }

    public function lang(Request $request)
    {
        return Language::where('locale', $request->locale)->pluck('text', 'key')->toArray();
    }
}
