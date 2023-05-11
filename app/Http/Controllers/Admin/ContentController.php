<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContentStoreRequest;
use App\Models\Content;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function index ()
    {
        $allUploaded = Content::notDeleted()->get(); // تعداد کل محتواهای آپلود شده
        $allUploadedFiles = $allUploaded->whereNotNull('file')->count(); // تعداد فایلهای آپلود شده
        $allUploadedVideos = $allUploaded->whereNotNull('video')->count(); // تعداد ویدئوهای آپلود شده
        
    }

    public function store (ContentStoreRequest $request)
    {
        if ($file = $request->file('file')) {
            $file = $file->store(Content::FILE_PATH, 'public');
        }

        if ($video = $request->file('video')) {
            $video = $video->store(Content::VIDEO_PATH, 'public');
        }

        $content = Content::create([
            'term_id' => $request->term_id,
            'title' => $request->title,
            'video' => $video,
            'file' => $file,
            'description' => $request->description
        ]);

        if ($request->tags) {
            foreach ($request->tags as $tag) {
                $tagIDs[] = Tag::query()->firstOrCreate(['name' => $tag])->id;
            }
        }

        $content->objectTaxonomiesAssign($request->term_id);
        $content->tags()->attach($tagIDs);

        return response('created successfuly', 200);
    }

    public function delete ($id)
    {
        $content = Content::findOrFail($id);
        $time = Carbon::now();
        $content->deleted_at = $time;
        $content->save();
        return response()->json([
            'status' => 'success',
            'message' => 'پاک شد.'
        ]);

    }
}
