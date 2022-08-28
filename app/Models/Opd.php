<?php

namespace App\Models;

use Diskominfotik\QueryFilter\Traits\HasQueryFilter;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasHashSlug;

class Opd extends Model
{
	use HasHashSlug;
	
	/**
	 * The primary key for the model.
	 *
	 * @var string
	 */
	protected $primaryKey = "opd_id";
	
	/**
	 * Indicates if the IDs are auto-incrementing.
	 *
	 * @var bool
	 */
	public $incrementing = false;

	/**
	 * The "type" of the primary key ID.
	 *
	 * @var string
	 */
	protected $keyType = 'string';
	
	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [];
	
	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
		$this->setTable(config('tables.reference.opd'));
	}

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [];

	public function scopeIsOpd($query)
    {
        return $query->where('jenis_instansi', '=', 'OPD');
    }
		
	public function scopeIsInfraJip($query)
    {
        return $query->whereIn('jenis_instansi', ['OPD','Cluster','Pusat']);
    }
}
