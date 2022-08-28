<?php

namespace App\Models;

use App\Models\Traits\HasHashSlug;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use App\Http\Resources\ManualBookParentResources;

class ManualBook extends Base implements HasMedia
{
  use HasHashSlug, HasMediaTrait;

  /**
   * The primary key for the model.
   *
   * @var string
   */
  protected $primaryKey = 'i_id';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'e_type',
    'v_nama_judul',
    'i_parent_id',
    'v_nama_file',
    'i_order',
    'v_video',
    'v_created_by',
    'v_updated_by'
  ];

  protected $appends = ['parent_folder'];

  protected $with = ['parent'];
  
  /**
   * Create a new Eloquent model instance.
   *
   * @param  array  $attributes
   * @return void
   */
  public function __construct(array $attributes = []) {
    parent::__construct($attributes);
    $this->setTable(config('tables.master.buku_manual'));
  }

  public function parent() {
    return $this->belongsTo(ManualBook::class , 'i_parent_id');
  }

  public function children() {
    return $this->hasMany(ManualBook::class ,'i_parent_id');
  }

  public function getFileBookAttribute() {
    $media = $this->getMedia('manualbook')->first();
    $url = $media ? route('download.show', ['media' => $media->id]) : null;
    return $url;
  }

  public function getParentFolderAttribute() {
    return $this->parent ? new ManualBookParentResources($this->parent) : null;
  }
}
