<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Tags\Tag as SpatieTag;

class Tag extends SpatieTag
{
    public function cases(): MorphToMany {
        return $this->morphedByMany(LegalCase::class , 'taggable');
    }

}
