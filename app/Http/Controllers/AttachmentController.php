<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
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

    public function deleteByPath(Request $request)
    {
        $request->validate(['path' => 'required']);

        if (Storage::exists($request->path)) {
            Storage::delete($request->path);
            Attachment::wherePath($request->path)->delete();
            return ['message' => 'File has been deleted'];
        }

        return ['message' => 'File not found'];
    }

    public function download(Attachment $attachment)
    {
        return response()->streamDownload(function () use ($attachment) {
            echo Storage::get($attachment->path);
        }, $attachment->name);
    }
}
