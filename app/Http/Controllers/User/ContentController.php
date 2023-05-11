<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShowUserContentResource;
use App\Models\Content;
use App\Models\View;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    private $user_id;

    public function __construct()
    {
        $this->user_id = Auth::user()->id;
    }

    public function hasAccess ()
    {
        if (!Auth::user()) {
            return 'you should login first';
        }
    }

    public function index ()
    {

    }

    public function show (Request $request, Content $content)
    {
       DB::beginTransaction();
       try {
        $content = Content::exposed()->notDeleted()->findOrFail($content->id);
        return new ShowUserContentResource($content);
        DB::commit();

       } catch (Exception $e) {

        DB::rollBack();
        return $e->getMessage();
       }
    }

    public function downloadFile (Request $request, Content $content)
    {
        $this->hasAccess();

        $content = Content::findOrFail($content->id);
        $contentPath = Content::BASE_PATH . $content->file;
        if (is_null($content->file)) return 'there is no file to download';

        $view = View::where('user_id', $this->user_id)->first();
        
        if (empty($view)) {
            View::create([
                'user_id' => $this->user_id,
                'ip' => $request->ip(),
                'viewed_videos' => 1,
                'downloades' => 1,
                'created_at' => Carbon::now()
            ]);
        } else {
            $view = View::Create([
                'user_id' => $this->user_id,
                'ip' => $request->ip(),
                'viewed_videos' => $view->viewd_videos + 1,
                'downloades' => $view->downloades + 1,
                'created_at' => Carbon::now()
            ]);
        }

        return response()->download($contentPath);
    }

    public function downloadVideo (Request $request, Content $content)
    {
        $this->hasAccess();

        $content = Content::findOrFail($content->id);
        $contentPath = Content::BASE_PATH . $content->video;
        if(is_null($content->video)) return 'there is no video to download';

        $view = View::where('user_id', $this->user_id)->first();

        if (empty($view)) {
            View::create([
                'user_id' => $this->user_id,
                'ip' => $request->ip(),
                'viewed_videos' => 1,
                'downloades' => 1,
                'created_at' => Carbon::now()
            ]);
        } else {
            View::create([
                'user_id' => $this->user_id,
                'ip' => $request->ip(),
                'viewed_videos' => $view->viewd_videos + 1,
                'downloades' => $view->downloades + 1,
                'created_at' => Carbon::now()
            ]);
        }
        
        return response()->download($contentPath);
    }

}
