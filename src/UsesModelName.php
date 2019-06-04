<?php

namespace Pine\Policy;

use Illuminate\Support\Str;

trait UsesModelName
{
    /**
     * Get the model name.
     *
     * @return string
     */
    public function getModelNameAttribute()
    {
        // $this->append('model_name');

        return Str::lower(class_basename(static::class));
    }
}
