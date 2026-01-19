<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Task extends Model
{
    protected $fillable = ['title', 'description', 'completed'];

    public function scopeCompleted(Builder $query){
        return $query->where('completed', true);
    }

    public function  scopePending(Builder $query) {
        return $query->where('completed', false);
    }

    public function scopeSearch(Builder $query, ?string $term){
        if(!$term){
            return $query;
        }

        return $query->where('title', 'like', '%{$term}%');
    }

}


