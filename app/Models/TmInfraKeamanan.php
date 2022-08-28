<?php

namespace App\Models;

//use Diskominfotik\QueryFilter\Traits\HasQueryFilter;
//use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasHashSlug;

class TmInfraKeamanan extends Base
{
  use HasHashSlug;

  /**
   * Indicates if the model should be timestamped.
   *
   * @var bool
   */
  public $timestamps = false;

  /**
   * The primary key for the model.
   *
   * @var string
   */
  protected $primaryKey = 'id';

  /**
   * The attributes that aren't mass assignable.
   *
   * @var array
   */
  protected $guarded = [];

  /**
   * Create a new Eloquent model instance.
   *
   * @param  array  $attributes
   * @return void
   */

  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    $this->setTable(config('tables.master.tm_infra_keamanan'));
  }

  public function scopeActive($query)
  {
      return $query->whereNull('tm_infra_keamanan.deleted_at');
  }

  public function opd()
	{
		return $this->hasOne('App\Models\Opd', 'opd_id', 'opd_id');
	}

  public function idMetadataTerkait() {
		return $this->hasMany(TmMetadataTerkait::class ,'infra_id', 'id')->where('tm_metadata_terkait.domain_name', 'DOMAIN_INFRA_SECDEV');
  }
}
