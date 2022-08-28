<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use App\Models\Traits\{HasHashSlug, HasUserAttribute, HasUserMediaAttribute};
use App\Traits\HasCompositePrimaryKey;
use Diskominfotik\QueryFilter\Traits\HasQueryFilter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\HtmlString;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Pengumuman extends Base implements HasMedia
{
  use HasCompositePrimaryKey, HasQueryFilter, HasHashSlug, HasMediaTrait;

  /**
   * The primary key for the model.
   *
   * @var string
   */
  protected $primaryKey = 'i_id';

  protected $guarded = [];

  protected $appends = [
    // 'e_kategori',
    'has_banner_image',
    'banner_image_path',
    'thumbnail_image_path',
    'banner',
    'has_banner_image',
    // 'pengumuman_text'
  ];

  protected $casts = [
    'e_status_aktif' => 'boolean',
    // 'e_highlight' => 'boolean',
  ];

  /**
   * Create a new Eloquent model instance.
   *
   * @param  array  $attributes
   * @return void
   */
  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    $this->setTable(config('tables.master.pengumuman'));
  }

  /**
   * Get the kategori reference.
   *
   * @return mixed
   */
  public function refKategori()
  {
    return $this->hasOne(ReferensiUmum::class, 'v_key', 'e_kat_pengumuman');
  }

  // /**
  //  * Get the e_kategori skpd.
  //  *
  //  * @return mixed
  //  */
  // public function getEKategoriAttribute()
  // {
  //   return $this->refKategori()->first()->v_value ?? null;
  // }

  // public function getHasBannerImageAttribute()
  // {
  //   return (bool) $this->getMedia('banner image')->first();
  // }

  public function getBannerImagePathAttribute()
  {
    if ($media = $this->getMedia('banner image')->first()) {
      // return $media->getUrl();
      return str_replace(config('app.url'), '', $media->getUrl());
      // return str_replace(storage_path() . '\app', '', $media->getPath());
    }
    return null;
  }

  public function getHasBannerImageAttribute()
  {
    if ($media = $this->getMedia('banner image')->first()) {
      $exist = Storage::exists($this->banner_image_path);
      return $exist;
    }
    return null;
  }

  public function getThumbnailImagePathAttribute()
  {
    return image_template_url('small', $this->banner_image_path);
  }

  public function getBannerAttribute()
  {
    if ($this->has_banner_image) {
      return image_template_url('large', $this->banner_image_path);
    }

    return null;
  }

  // public function getPengumumanTextAttribute()
  // {
  //   return new HtmlString($this->tx_isi_pengumuman);
  // }

}
