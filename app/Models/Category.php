<?php

namespace App\Models;

use App\Traits\Trash;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Trash;

    protected $guarded = [];

    public function parent()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeMain($query) 
    {
        return $query->where('parent_id', 0);
    }

    public function maxRank()
    {
        return $this->noTrash()->max('rank');
    }
}
