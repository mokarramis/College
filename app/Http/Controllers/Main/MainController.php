<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Http\Resources\NewContentsResource;
use App\Models\Content;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index ()
    {
        $newContents = Content::orderByDesc('created_at')->take(7)->get();
        //$popularContents = ;
        $courses = Content::query()->exposed()->get()->groupBy('title');

        return [
            'new_contents' => NewContentsResource::collection($newContents),
            'courses'      => CourseResource::collection($courses), 
        ];
    }

    public function search (Request $request)
    {
        
    }

}
