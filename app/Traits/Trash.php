<?php

namespace App\Traits;

trait Trash
{
    public function scopeNoTrash($query)
    {
        return $query->where('trash', 0);
    }

    public function scopeTrashed($query)
    {
        return $query->where('trash', 1);
    }

    public function scopeAnyTrash($query, $trash)
    {
        return $query->where('trash', $trash);
    }

    public function trash()
    {
        return $this->update([
            'trash' => 1
        ]);
    }

    public function restore()
    {
        return $this->update([
            'trash' => 0
        ]);
    }
}
