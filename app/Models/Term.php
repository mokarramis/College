<?php

namespace App\Models;

use App\Traits\ObjectTaxonomies;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    use HasFactory, ObjectTaxonomies;

    protected $guarded = ['id'];

    public function taxonomies ()
    {
        return $this->hasMany(Term::class);
    }

    public function contents ()
    {
        return $this->belongsToMany(Term::class);
    }

    public function taxonomiesData ()
    {
        $taxonomiesInfo = Taxonomy::where('taxonomy_parent', $this->id)->get();

        if ($taxonomiesInfo) {
            return $taxonomiesInfo;
        } else {
            return null;
        }
    }
}
