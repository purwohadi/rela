<?php

namespace App\Models;

use App\Models\Traits\HasHashSlug;

class DomainInfraJip extends Base
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
	protected $primaryKey = 'id';
	
	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [];

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'nama_jip',
    //     'rai_level_1',
    //     'rai_level_2',
    //     'rai_level_3',
    //     'rai_level_4',
    //     'instansi_1',
    //     'instansi_2',
    //     'deskripsi',
    //     'jenis',
    //     'ownership',
    //     'owner_name',
    //     'unit_oper',
    //     'bandwidth',
    //     'media_type',
    //     'other_media',
    //     'primary_backup',
    //     'id_metadata_terkait'
    // ];

	/**
	 * Create a new Eloquent model instance.
	 *
	 * @param  array  $attributes
	 * @return void
	 */
	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
		$this->setTable(config('tables.master.domain_infra_jip'));
	}
}
