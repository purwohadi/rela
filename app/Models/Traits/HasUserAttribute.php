<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\DB;
use App\Models\UserGroup;

trait HasUserAttribute
{
	/**
	 * Appends the accessors model.
	 *
	 * @return void
	 */
	public function initializeHasUserAttribute()
	{
		$this->append(
			[ 'is_active'
			, 'is_admin'
			, 'is_common_user'
			, 'is_user_monitoring'
			, 'is_user_helpdesk'
			, 'is_user_pegawai_jpt'
			, 'is_user_pegawai_non_jpt'
			, 'current_eselon'
			// , 'email'
			, 'another_user'
			, 'is_main_user'
			, 'is_impersonating'
			, 'opd_id'
			]
		);
	}

	/**
	 * Get the user's is_active
	 *
	 * @return boolean
	 */
	public function getIsActiveAttribute()
	{
		return null === $this->deleted_at;
	}

	/**
	 * Flagging user as super admin
	 *
	 * @return boolean
	 */
	public function getIsAdminAttribute()
	{
		return $this->groups()
		->pluck('v_group_name')
		->map(function ($group) {
			return strtolower($group);
		})
		->filter(function ($group) {
			return stristr($group, 'admin');
		})
		->count() > 0
		&& (
			stristr(strtolower($this->v_userid), 'admin') ||
			stristr(strtolower($this->v_userid), 'su-')
		);
	}

	/**
	 * Flagging user as common user
	 *
	 * @return boolean
	 */
	public function getIsCommonUserAttribute()
	{
		return (bool)$this->latestPegawai();
	}

	// public function getEmailAttribute()
	// {
	// 	if(!$this->is_common_user) return;
	// 	$pegawai = DB::table('vw_pers_pegawai')->where('nrk', $this->v_userid)->first();
	// 	return $pegawai ? $pegawai->email : null;
	// }

	public function getIsUserMonitoringAttribute()
	{
		return $this->groups()
		->pluck('v_group_name')
		->map(function ($group) {
			return strtolower($group);
		})
		->filter(function ($group) {
			return stristr($group, 'Monitoring');
		})
		->count() > 0;
		// && stristr(strtolower($this->v_userid), 'admin');
	}

	public function getIsUserHelpdeskAttribute()
	{
		return $this->groups()
		->pluck('v_group_name')
		->map(function ($group) {
			return strtolower($group);
		})
		->filter(function ($group) {
			return stristr($group, 'Helpdesk');
		})
		->count() > 0;
	}

	public function getIsUserPegawaiJptAttribute()
	{
		return $this->groups()
		->pluck('v_group_name')
		->map(function ($group) {
			return strtolower($group);
		})
		->filter(function ($group) {
			return stristr($group, 'Pegawai JPT');
		})
		->count() > 0;
	}

	public function getIsUserPegawaiNonJptAttribute()
	{
		return $this->groups()
		->pluck('v_group_name')
		->map(function ($group) {
			return strtolower($group);
		})
		->filter(function ($group) {
			return stristr($group, 'Pegawai Non JPT');
		})
		->count() > 0;
	}

	public function getCurrentEselonAttribute()
	{
		return $this->is_common_user ? $this->latestPegawai()->v_eselon : null;
	}

	/*
		Get user that will be impersonated (plt, plh, pjs)
	*/
	public function getAnotherUserAttribute()
	{
		// if ($this->is_common_user) {
		$nrk = explode('-', $this->v_userid)[0];
		$another_user = UserGroup::whereIn('v_userid', [$nrk, $nrk.'-plt', $nrk.'-plh', $nrk.'-pjs'])
		->get()
		->pluck('v_userid')
		->filter(function ($user_id) {
			return $user_id != $this->v_userid;
		});
		return array_values(array_unique($another_user->toArray()));
		// }
		// return [];
	}

	/*
		Get user that will be impersonated (plt, plh, pjs)
	*/
	public function getIsMainUserAttribute()
	{
		if ($this->is_common_user) {
			$is_main_user = count(explode('-', $this->v_userid)) == 1;
			return $is_main_user;
		}
		return false;
	}

	public function getIsImpersonatingAttribute()
	{
		return app()->impersonate->isImpersonating();
	}
	
	public function getOpdIdAttribute()
	{
		return $this->groups()->pluck('v_opd_id')->first();
	}
}
