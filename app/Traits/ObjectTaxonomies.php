<?php

namespace App\Traits;

use App\Http\Resources\TermResource;
use App\Models\Taxonomy;
use App\Models\Term;
use App\Models\TermRelationship;

trait ObjectTaxonomies
{
    protected $taxonomiesInfo = [];

    public function objectTaxonomiesAssign ($term_id)
    {
        foreach (json_decode($term_id) as $item) {
            $relation = [
                'model_id' => $this->id,
                'term_id' => $item,
                'type' => $this::class
            ];
            $data[] = $relation;
        }

        return TermRelationship::insert($data);
    }

    public function objectTaxonomiesInfo ()
    {
        $relation = TermRelationship::where('type', $this::class)->where('model_id', $this->id)->get();
        if ($relation->isNotEmpty()) {
            foreach ($relation as $item => $value) {
                $taxonomy = Taxonomy::where('id', $value->taxonomy_id)->first();
                $term_info = Term::where('id', $taxonomy->term_id)->first();

                $this->taxonomiesInfo[] = new TermResource($term_info);
            }
        }

        return $this->taxonomiesInfo;
    }

    public function objectTaxonomiesDelete ()
    {
        $relation = TermRelationship::where('type', $this::class)->where('model_id', $this->id)->get();
        return TermRelationship::destroy($relation);
    }
}