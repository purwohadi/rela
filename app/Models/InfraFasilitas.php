<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Traits\HasHashSlug;

class InfraFasilitas extends Model
{
	use HasHashSlug;
	
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
	protected $primaryKey = "id";
		
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
	protected $fillable = [];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [];
	
	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
		$this->setTable(config('tables.master.infra_fasilitas'));
	}

	public function children() {
		return $this->belongsTo(MetadataTerkait::class);
	}

	public function metadataTerkait() {
		return $this->hasMany(MetadataTerkait::class ,'infra_id', 'id')
					->select([DB::raw('infra_id, domain_terkait_code AS kode, domain_terkait_code AS kode_nama')])
					->where('DOMAIN_NAME','DOMAIN_INFRA_FASILITAS');
	}

}
