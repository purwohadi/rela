<?php

namespace App\Models;

use App\Models\Traits\HasHashSlug;

class TmAplikasi extends Base
{
	use HasHashSlug;

	public $incrementing = false;

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
	protected $primaryKey = 'apl_id';
	
	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [];
	protected $keyType = 'string';

	/**
	 * Create a new Eloquent model instance.
	 *
	 * @param  array  $attributes
	 * @return void
	 */
	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
		$this->setTable(config('tables.master.tm_aplikasi'));
	}

	public function scopeActive($query)
    {
        return $query->whereNull('tm_aplikasi.deleted_at');
    }

	public function layanan()
    {
		return $this->belongsToMany('App\Models\Layanan', 'TM_APLIKASI_LAYANAN', 'apl_id', 'layanan_id')->active();
    }

	public function data()
    {
		return $this->belongsToMany('App\Models\TmInformasi', 'TM_APLIKASI_DATA', 'apl_id', 'data_id')->active();
    }

	public function luaran()
    {
		return $this->belongsToMany('App\Models\TmInformasi', 'TM_APLIKASI_LUARAN', 'apl_id', 'data_id')->active();
    }

	public function detail()
	{
		return $this->hasOne('App\Models\AplikasiDetail', 'apl_id', 'apl_id');
	}

	public function unit_oper_opd()
	{
		return $this->hasOne('App\Models\Opd', 'opd_id', 'unit_oper');
	}

	public function unit_dev_opd()
	{
		return $this->hasOne('App\Models\Opd', 'opd_id', 'unit_dev');
	}

	public function aplikasi_basis()
	{
		return $this->hasMany('App\Models\AplikasiBasis', 'apl_id', 'apl_id');
	}
}
