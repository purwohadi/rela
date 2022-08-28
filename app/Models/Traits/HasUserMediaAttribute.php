<?php

namespace App\Models\Traits;

trait HasUserMediaAttribute
{
  /**
   * Appends the accessors model.
   *
   * @return void
   */
  public function initializeHasUserMediaAttribute()
  {
    $this->append(
      [ 'has_avatar_image'
      , 'avatar_image_path'
      , 'thumbnail_avatar_path'
      , 'avatar'
      ]
    );
  }

  /**
   * Get the user's avatar image.
   *
   * @return string
   */
  public function getHasAvatarImageAttribute()
  {
    return (bool) $this->getMedia('avatar image')->first();
  }

  /**
   * Get the user's avatar path.
   *
   * @return string
   */
  public function getAvatarImagePathAttribute()
  {
    if ($media = $this->getMedia('avatar image')->first()) {
      // return $media->getUrl();
      // return str_replace(config('app.url'), '', $media->getUrl());
      return str_replace(storage_path() . '\app', '', $media->getPath());
    }

    return null;
  }

  /**
   * Get the user's avatar thumbnail.
   *
   * @return string
   */
  public function getThumbnailAvatarPathAttribute()
  {
    return image_template_url('small', $this->avatar_image_path);
  }

  /**
   * Get the user's avatar medium size.
   *
   * @return string
   */
  public function getAvatarAttribute()
  {
    if ($this->has_avatar_image) {
      return image_template_url('medium', $this->avatar_image_path);
    }

    return null;
  }
}
