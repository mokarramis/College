<?php

namespace App\Models;

use App\Traits\ObjectTaxonomies;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory, ObjectTaxonomies;

    protected $fillable = ['term_id', 'title', 'show_on_site', 'file', 'video'];

    const FILE_PATH = 'content_files';
    const VIDEO_PATH = 'content_videos';
    const BASE_PATH = 'C:/xampp/htdocs/college/storage/app/public/';
 
    public function terms ()
    {
        return $this->belongsTo(Taxonomy::class, 'term_id', 'taxonimy_id');
    }

    public function tags ()
    {
        return $this->morphToMany(Tag::class, 'model', 'taggables');
    }

    public function scopeNotDeleted ($query)
    {
        return $query->where('deleted_at', null);
    }

    public function scopeExposed ($query)
    {
        $query->where('show_on_site', true);
    }
}
