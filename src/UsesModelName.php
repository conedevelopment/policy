<?php

namespace Pine\Policy;

trait UsesModelName
{
    /**
     * Get the model name.
     *
     * @return string
     */
    public function getModelNameAttribute()
    {
        return strtolower(class_basename(static::class));
    }
}
