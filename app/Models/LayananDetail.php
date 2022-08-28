<?php

namespace App\Models;

use App\Models\Traits\HasHashSlug;
use Illuminate\Support\Facades\DB;

class LayananDetail extends Base
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
	protected $keyType = 'string';
	// protected $primaryKey = false;
	
	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [];

	protected $appends = ['pelaksana1', 'pelaksana2', 'delegasi'];

	/**
	 * Create a new Eloquent model instance.
	 *
	 * @param  array  $attributes
	 * @return void
	 */
	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
		$this->setTable(config('tables.master.layanan_detail'));
	}

	public function getPelaksana1Attribute()
	{
		$viewjabatanTropd= new ViewJabatanTropd;
		return  $viewjabatanTropd->join('tm_layanan','tm_layanan.layanan_id', DB::raw('\''.$this->layanan_id.'\''))
								->where('vw_jabatan_tropd.opd_id',DB::raw('tm_layanan.opd_id'))
								->where('kojab', $this->pelaksana_level1)
								->get();
	}

	public function getPelaksana2Attribute()
  	{
		$viewjabatanTropd= new ViewJabatanTropd;
		return  $viewjabatanTropd->join('tm_layanan','tm_layanan.layanan_id', DB::raw('\''.$this->layanan_id.'\''))
								 ->where('vw_jabatan_tropd.opd_id',DB::raw('tm_layanan.opd_id'))
								 ->whereIn('kojab', explode(';',$this->pelaksana_level2))
					    	     ->get();
	}

	public function getDelegasiAttribute()
  	{
		$opd= new Opd();
		return  $opd->whereIn('opd_id', explode(';',$this->unit_delegasi)) ->get();
	}
}
