<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\TermResource;
use App\Models\Taxonomy;
use App\Models\Term;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TermController extends Controller
{
    public function index()
    {
        $term_info = Term::all();
        $term_info = TermResource::collection($term_info);
        return response([
            'status' => 'success',
            'data'   => $term_info
        ]);
    }
  
    public function create()
    {
       
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try 
        {
            $term = Term::create([
                'name'        => $request->name,
                'slug'        => $request->slug,
            ]);
    
            $taxonomy = Taxonomy::create([
                'term_id'           => $term->id,
                'taxonomy_parent'   => (!empty($request->parent_id)) ? $request->parent_id : null,
                'taxonomy_name'     => 'category',
                'description'       => $request->description
            ]);
            DB::commit();
        }
        catch (Exception $e) 
        {
            DB::rollBack();
            return false;
        }
        return response([
            'status' => 'success',
        ]);

    }

    public function show($id)
    {
        $term_info = Term::findOrFail($id);
        $term_info = new TermResource($term_info);

        return response([
            'status' => 'success',
            'data'   => $term_info
        ]);
    }

    public function edit($id)
    {
        $term_info = Term::findOrFail($id);
        $term_info = new TermResource($term_info);

        return response([
            'status' => 'success',
            'data'   => $term_info
        ]);
    }

    public function update(Request $request, $id)
    {
        $term = Term::where('id' , $id)->get();

        $term->name = $request->name;
        $term->slug = $request->slug;
        
        $taxonomy = Taxonomy::where('term_id' , $term->id)->update([
            'term_id'           => $term->id,
            'taxonomy_parent'   => (isset($request->parent_id)) ? $request->parent_id : null,
            'taxonomy_name'     => 'category',
            'description'       => $request->description
        ]);
       
        return response([
            'status' => 'success',
        ]);
    }

    public function destroy($id)
    {
        $term = Term::findOrFail($id);
        $term->delete();
        return response([
            'status' => 'success',
        ]);
    } 
}
