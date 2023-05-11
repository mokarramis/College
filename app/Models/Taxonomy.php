<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taxonomy extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function term ()
    {
        return $this->belongsTo(Term::class, 'term_id');
    }
}
