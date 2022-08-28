<?php

namespace App\Traits;

use Webpatser\Uuid\Uuid as Master;

/**
 *
 */
trait Uuids
{
  protected static function boot()
  {
    parent::boot();
    static::creating(function ($model) {
      $model->{$model->getKeyName()} = Master::generate()->string;
    });
  }
}
