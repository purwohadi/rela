<?php

namespace App\Models;

use App\Models\Traits\HasHashSlug;
use App\Models\MetadataTerkait;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class InfraJip extends Model
{
	use HasHashSlug;
	
    // public $incrementing = false;

	/**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

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
   * The relations to eager load on every query.
   *
   * @var array
   */
	// protected $with = ['metadataTerkait'];

	/**
	 * Create a new Eloquent model instance.
	 *
	 * @param  array  $attributes
	 * @return void
	 */
	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
		$this->setTable(config('tables.master.infra_jip'));
	}
	
	public function children() {
		return $this->belongsTo(MetadataTerkait::class);
	}

	public function metadataTerkait() {
		return $this->hasMany(MetadataTerkait::class ,'infra_id', 'id')
					->join('tm_infra_fasilitas','tm_infra_fasilitas.domain_code','tm_metadata_terkait.domain_terkait_code')
					->select([DB::raw('infra_id, domain_terkait_code AS kode, domain_terkait_code ||\' - \'||tm_infra_fasilitas.nama AS kode_nama')]);
	}
}
