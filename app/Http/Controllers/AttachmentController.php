<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttachmentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['file' => 'required|mimes:png,jpg,jpeg,bmp,svg,pdf,doc,docx,xls,xlsx,ppt,pptx']);
        $path = $request->file('file')->store('uploads/' . date('Y/m/d/H'));

        return [
            'path' => $path,
            'name' => $request->file('file')->getClientOriginalName(),
            'user_id' => $request->user()->id
        ];
    }
}
