<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Traits\{HasHashSlug, HasUserAttribute, HasUserMediaAttribute};
use Lab404\Impersonate\Models\Impersonate;

class User extends Authenticatable implements HasMedia
{
	use Notifiable
		, HasHashSlug
		, HasMediaTrait
		, HasUserAttribute
		, HasUserMediaAttribute
		, Impersonate
		;

	/**
	 * The name of the "created at" column.
	 *
	 * @var string
	 */
	const CREATED_AT = 'dt_created_at';

	/**
	 * The name of the "updated at" column.
	 *
	 * @var string
	 */
	const UPDATED_AT = 'dt_updated_at';

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
	 * The primary key for the model.
	 *
	 * @var string
	 */
	protected $primaryKey = 'v_userid';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [ 'v_userid'
							, 'v_username'
							, 'v_userpass'
							, 'e_user_enable'
							, 'd_last_update_pass'
							, 'v_created_by'
							, 'v_updated_by'
							];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [ 'v_userpass'
						];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts =  [ 'has_avatar_image' => 'boolean'
						];

	/**
	 * The relations to eager load on every query.
	 *
	 * @var array
	 */
	protected $with = ['media'];

	/**
	 * Create a new User model instance.
	 *
	 * @param  array  $attributes
	 * @return void
	 */
	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
		$this->setTable(config('tables.master.users'));
	}

	public function canBeImpersonated()
	{
		// For example
		return $this->can_be_impersonated == 1;
	}



	/**
	 * Get the user_group for the user.
	 */
	public function userGroup()
	{
		return $this->hasMany(UserGroup::class, 'v_userid', 'v_userid');
	}

	/**
	 * Get all of the group for the user.
	 */
	public function groups()
	{
		$pivot = config('tables.master.user_group');
		return $this->belongsToMany(
		Group::class,
		$pivot,
		'v_userid',
		'v_group_id',
		'v_userid',
		'i_id'
		);
	}

	/**
	 * Get the data pegawai associated with the user.
	 */
	public function pegawai()
	{
		return $this->hasMany(ViewPegawai::class, 'v_nrk', 'v_userid');
	}

	/**
	 * Get the skpd associated with the user.
	 */
	public function skpd()
	{
		// return $this->hasOne(Skpd::class, 'v_unit_id', 'v_userid');
	}

	/**
	 * Get the latest data pegawai based on v_thbl.
	 */
	protected function latestPegawai()
	{
		return $this->pegawai()->latest('v_thbl')->first();
	}

	/**
	 * Get the user's kode unit.
	 *
	 * @return mixed
	 */
	public function getKodeUnitAttribute()
	{
		// return $this->skpd()->first()->v_unit_id ?? null;
		return null;
	}

	/**
	 * Get the user's kolok.
	 *
	 * @return mixed
	 */
	public function getKolokAttribute()
	{
		return null;
	}

	/**
	 * Get the user's spmu.
	 *
	 * @return mixed
	 */
	public function getSpmuAttribute()
	{
		return $this->latestPegawai()->v_spmu ?? null;
	}

	/**
	 * Get the user's group name.
	 *
	 * @return mixed
	 */
	public function getGroupNamesAttribute()
	{
		$userGroup = $this->userGroup()->get();
		$res = !$userGroup->isEmpty() ? $userGroup->map(function($item) {
		return $item->group()->first();
		}) : [];
		// $res = $this->userGroup()->with('group');
		return $res ? $res->map(function($item){
		return [
			'group_name' => $item['v_group_name'],
			'slug_path' => $item['slug_path']
		];
		}) : collect([]);
	}

	/**
	 * Get the user's feature access.
	 *
	 * @return mixed
	 */
	public function getFeatureAccessAttribute()
	{
		$userGroup = $this->userGroup()->get();
		$res = !$userGroup->isEmpty() ? $userGroup->map(function($data) {
		$group = $data->group()->get();
		return !$group->isEmpty() ? $group->map(function ($item) {
			$featureGroup = $item->featureGroup()->get();
			return !$featureGroup->isEmpty() ? $featureGroup->map(function ($q) {
			return $q->featureAccess()->first();
			}) : [];
		}) : [];
		}) : collect([]);
		// return $this->userGroup()->with('group.featureGroup.featureAccess')->get();
		return $res ? $res->flatten(0)->pluck('v_name') : [];
	}

	public function getMenuAttribute()
	{
		$userGroup = $this->userGroup()->get();
		$res = !$userGroup->isEmpty() ? $userGroup->map(function($data) {
		$group = $data->group()->get();
		return !$group->isEmpty() ? $group->map(function ($item) {
			$featureGroup = $item->featureGroup()->get();
			return !$featureGroup->isEmpty() ? $featureGroup->map(function ($q) {
			return $q->featureAccess()->where('e_type', 'menu')->first();
			}) : [];
		}) : [];
		}) : collect([]);

		return $res ? $res->flatten(0)->filter() : [];
	}

	public function getLoginPegawaiAttribute()
	{
		if ($this->latestPegawai()) {
		return true;
		}
		return false;
	}
}
