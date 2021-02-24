<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['file' => 'required|mimes:png,jpg,jpeg,bmp,svg,pdf,doc,docx,xls,xlsx,ppt,pptx|max:2048']);
        $path = $request->file('file')->store('uploads/' . date('Y/m/d/H'));

        return [
            'message' => 'File has been uploaded',
            'user_id' => $request->user()->id,
            'name' => $request->file('file')->getClientOriginalName(),
            'path' => $path,
            'url' => Storage::url($path),
            'data' => $request->data
        ];
    }
}
