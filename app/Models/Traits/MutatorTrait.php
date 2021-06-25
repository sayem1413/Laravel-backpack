<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait MutatorTrait
{
    public function setSlugAttribute()
    {
        $slug = Str::slug($this->name);
        $this->attributes['slug'] = Str::slug($slug);
    }
}
