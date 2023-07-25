<?php

namespace App\Models;

use Str;

trait Sluggable
{
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        self::addSlugOnCreated();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Propriété utilisée pour la génération du slug
     */
    public static function getKeyNameProperty()
    {
        return 'name';
    }

    public function scopeSearchSlug(string $slug)
    {
        return $this->where('slug', $slug);
    }

    public function scopeFindBySlug($query, string $slug)
    {
        return $query->where('slug', $slug)->first();
    }

    /**
     * Could be used inside Model classes to add slug on created event.
     */
    private static function addSlugOnCreated()
    {
        static::created(function ($model) {
            $model->slug = Str::uniqueSlug($model->getTable(), $model[self::getKeyNameProperty()]);
            $model->save();
        });
    }
}
