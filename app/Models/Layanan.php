<?php

namespace App\Models;

use App\Models\Traits\HasHashSlug;

use Illuminate\Support\Facades\DB;

class Layanan extends Base
{
	use HasHashSlug;

	public $incrementing = false;

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
	protected $primaryKey = 'layanan_id';
	// protected $primaryKey = false;
	protected $keyType = 'string';
	
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
	// protected $with = ['layanan_proses'];

	/**
	 * Create a new Eloquent model instance.
	 *
	 * @param  array  $attributes
	 * @return void
	 */
	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
		$this->setTable(config('tables.master.layanan'));
	}

	public function children() {
		return $this->belongsTo(LayananProses::class);
	}
	public function scopeActive($query)
    {
        return $query->whereNull('tm_layanan.deleted_at');
    }

	/**
	 * Get layanan proses associated with layanan detail.
	 *
	 * @return mixed
	 */
	public function layanan_proses() {
		return $this->hasMany(LayananProses::class ,'layanan_id', 'layanan_id');
	}

	public function opd()
	{
		return $this->hasOne('App\Models\Opd', 'opd_id', 'opd_id');
	}
}
