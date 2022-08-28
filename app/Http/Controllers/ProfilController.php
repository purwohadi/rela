<?php

namespace App\Http\Controllers;

use App\Models\ViewJenhukdis;
use App\Models\ViewRiwayatJabatan;
use App\Models\PresPddknFormal;
use App\Models\PresPddknNonFormal;
use App\Models\PengalamanNarsum;
use App\Models\PresKegiatanStrategis;
use App\Models\PresJabatan;
use App\Models\ViewJenisPendidikan;
use App\Models\DbLinkVwAkunSkpd;

use Illuminate\Http\Request;
use App\Repositories\Contracts\PegawaiRepositoryInterface;

use App\Repositories\Contracts\ViewJenhukdisRepositoryInterface;
use App\Repositories\Contracts\ViewRiwayatJabatanRepositoryInterface;
use App\Repositories\Contracts\ViewAtasanRepositoryInterface;

use Illuminate\Support\Facades\{DB, Log};

class ProfilController extends Controller
{
	protected $pegawaiRepo;
	protected $viewAtasanRepo;
	protected $viewJenhukdis;
	protected $viewRiwayatJabatan;
	protected $presPddknFormal;
	protected $presPddknNonFormal;
	protected $pengalamanNarsum;
	protected $presKegiatanStrategis;
	protected $presJabatan;

	/**
	 * ProfilController constructor.
	 *
	 * @param ProfilRepositoryInterface $permission
	 */
	public function __construct (
		PegawaiRepositoryInterface $pegawaiRepo,
		ViewAtasanRepositoryInterface $viewAtasanRepo,
		ViewJenhukdisRepositoryInterface $viewJenhukdis,
		ViewRiwayatJabatanRepositoryInterface $viewRiwayatJabatan,
		PresPddknFormal $presPddknFormal,
		PresPddknNonFormal $presPddknNonFormal,
		PengalamanNarsum $pengalamanNarsum,
		PresKegiatanStrategis $presKegiatanStrategis,
		PresJabatan $presJabatan
	) {
		$this->pegawaiRepo 				= $pegawaiRepo;
		$this->viewAtasanRepo 			= $viewAtasanRepo;
		$this->viewJenhukdis 			= $viewJenhukdis;
		$this->viewRiwayatJabatan 		= $viewRiwayatJabatan;
		$this->presPddknFormal 			= $presPddknFormal;
		$this->presPddknNonFormal 		= $presPddknNonFormal;
		$this->pengalamanNarsum 		= $pengalamanNarsum;
		$this->presKegiatanStrategis 	= $presKegiatanStrategis;
		$this->presJabatan 				= $presJabatan;
	}

	/** Pegawai*/
	public function dataBulananSearch(Request $request)
	{
		$data = $this->pegawaiRepo->dataBulananSearch($request);
		return $data[$request->thbl];
	}

	public function dataBulananPrevNext(Request $request, $nrk, $thbl)
	{
		$data = $this->pegawaiRepo->dataBulananSearch($request);
		return $data;
	}

	/** Atasan*/
	public function dataAtasanSearch(Request $request, $nrk, $thbl)
	{
		return $this->viewAtasanRepo->dataAtasanSearch($request);
	}

	public function search(Request $request)
	{
		$persDisiplinHist = new ViewJenhukdis();
		$getJenHukdis = $persDisiplinHist->searchHukdis($request);

		$result = $request->limit
			? $persDisiplinHist->getPagingData($getJenHukdis)
			: $persDisiplinHist->getAllData($getJenHukdis);

			return $result;
	}

	public function searchRiwayatJabatan(Request $request)
	{
    return $this->viewRiwayatJabatan->searchRiwayatJabatan($request);
	}

	public function dataPegawaiProfile(Request $request)
	{
		return $this->pegawaiRepo->dataPegawaiProfile($request);
	}

	public function dataPegawaiProfileSimpeg(Request $request, $nrk)
	{
		return $this->pegawaiRepo->dataPegawaiProfileSimpeg($request, $nrk);
	}

	public function searchPendidikanFormal(Request $request)
	{
		$presPddknFormal = new PresPddknFormal();
		$getPresPddknFormal = $presPddknFormal->searchPendidikanFormal($request);
		$result = $getPresPddknFormal->paginate($request->limit);
		return $result;
	}

	public function searchJenisPendidikanFormal(Request $request)
	{
		$viewPddknFormal = new ViewJenisPendidikan();
		$getPresPddknFormal = $viewPddknFormal->searchPendidikanFormal($request);
		$result = $request->limit
			? $viewPddknFormal->getPagingData($getPresPddknFormal)
			: $viewPddknFormal->getAllData($getPresPddknFormal);
		return $result;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function storePendidikanFormal(Request $request)
	{
		$input = $request->all();
		$jenjang_pendidikan = explode('=',$input['jenjang_pendidikan']);
		$jendik = $jenjang_pendidikan[0];
		$kodik = $jenjang_pendidikan[1];
		$nadik = $jenjang_pendidikan[2];
		$nasek = $jenjang_pendidikan[3];
		$user_id = auth()->user()->v_userid;
		$find = $this->presPddknFormal
			->where('v_nrk',  $input['nrk'])
			->where('i_jendik', $jendik)
			->where('v_kodik', $kodik)
			->where('v_nadik', $nadik)
			->where('v_nasek', $nasek)
			->first();

		if ($find) {
			return $this->redirectResponse($request, 'Data Jenjang Pendidikan Formal Sudah Ada!', 'error', 'duplicate');
		}

		try
		{
			$this->presPddknFormal->create([
				'v_nrk' => $input['nrk'],
				'i_jendik' => $jendik,
				'v_kodik' => $kodik,
				'v_nadik' => $nadik,
				'v_nasek' => $nasek,
				'tx_prestasi' => $input['prestasi_diperoleh'],
				'v_created_by' => $user_id,
			]);

			$type = 'success';
			$message = 'Data Pendidikan Formal Berhasil Disimpan';
		}
		catch(\Throwable $t)
		{
			$type = 'error';
			$message = 'Data Pendidikan Formal Gagal Disimpan';
		}

		return $this->redirectResponse($request, trans("{$message}"), $type, $find);
  }

	/**
	 * Delete the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\PresPddknFormal
	 * @return \Illuminate\Http\Response
	 */
	public function deletePendidikanFormal(Request $request)
	{
		$deleted 	= PresPddknFormal::where(['i_id' => $request->id])->delete();
		$type 		= !$deleted ? 'error' : 'success';
		$message	= !$deleted ? 'Data Pendidikan Formal Gagal Dihapus' : 'Data Pendidikan Formal Berhasil Dihapus';
		return $this->redirectResponse($request, trans("{$message}"), $type, $deleted);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\PresPddknFormal  $presPddknFormal
	 * @return \Illuminate\Http\Response
	 */
	public function updatePendidikanFormal(Request $request)
	{
		$input = $request->all();
		$jenjang_pendidikan = explode('=',$input['jenjang_pendidikan']);
		$jendik = $jenjang_pendidikan[0];
		$kodik = $jenjang_pendidikan[1];
		$nadik = $jenjang_pendidikan[2];
		$nasek = $jenjang_pendidikan[3];
		$user_id = auth()->user()->v_userid;
	  $query = $this->presPddknFormal
			->where('v_nrk',  $input['nrk'])
			->where('i_jendik', $jendik)
			->where('v_kodik', $kodik)
			->where('v_nadik', $nadik)
			->where('v_nasek', $nasek)
			->first();

		try
		{
			PresPddknFormal::where('i_id', $input['i_id'])
				->update(['i_jendik' 	=> $jendik,
					'v_kodik' => $kodik,
					'v_nadik' => $nadik,
					'v_nasek' => $nasek,
					'tx_prestasi' => $input['prestasi_diperoleh'],
					'v_updated_by' => $user_id,
				]);

			$type = 'success';
			$message = 'Data Pendidikan Formal Berhasil Diubah';
		}
		catch(\Throwable $t)
		{
			$type = 'error';
			$message = 'Data Pendidikan Formal Gagal Diubah';
		}
		return $this->redirectResponse($request, trans("{$message}"), $type, $query);
	}

	public function searchPendidikanNonFormal(Request $request)
	{
		$presPddknNonFormal 	= new PresPddknNonFormal();
		$getPresPddknNonFormal 	= $presPddknNonFormal->searchPendidikanNonFormal($request);
		$result 				= $getPresPddknNonFormal->paginate($request->limit);
		return $result;
	}

	public function searchJenisPendidikanNonFormal(Request $request)
	{
		$viewPddknNonFormal 	= new ViewJenisPendidikan();
		$getPresPddknNonFormal 	= $viewPddknNonFormal->searchPendidikanNonFormal($request);
		$result 				= $request->limit
										? $viewPddknNonFormal->getPagingData($getPresPddknNonFormal)
										: $viewPddknNonFormal->getAllData($getPresPddknNonFormal);
		return $result;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function storePendidikanNonFormal(Request $request)
	{

		$input 	= $request->all();
		$jendik = 0;
		$kodik  = '';
		$nadik  = $input['jenjang_pendidikan_lainnya'];
		$nasek  = '';
		if($input['jenjang_pendidikan'] != 'lainnya')
		{
			$jenjang_pendidikan = explode('=',$input['jenjang_pendidikan']);
			$jendik 			= $jenjang_pendidikan[0];
			$kodik 				= $jenjang_pendidikan[1];
			$nadik 				= $jenjang_pendidikan[2];
			$nasek 				= $jenjang_pendidikan[3];
		}

		$user_id 			= auth()->user()->v_userid;
		$find 				= $this->presPddknNonFormal::where('v_nrk',  $input['nrk'])
														->where('i_jendik', $jendik)
														->where('v_kodik', $kodik)
														->where('v_nadik', $nadik)
														->where('v_nasek', $nasek)
														->first();
		// if($find)
		// {
		// 	return $this->redirectResponse($request, 'Data Jenjang Pendidikan Non Formal Sudah Ada!', 'error', 'duplicate');
		// 	exit;
		// }
		try
		{
			$this->presPddknNonFormal->create(['v_nrk' 			=> $input['nrk'],
											   'i_jendik' 		=> $jendik,
											   'v_kodik' 		=> $kodik,
											   'v_nadik' 		=> $nadik,
											   'v_nasek' 		=> $nasek,
											   'tx_prestasi' 	=> $input['prestasi_diperoleh'],
											   'v_created_by' 	=> $user_id,
											]);
			$type 				= 'success';
			$message			= 'Data Pendidikan Non Formal Berhasil Disimpan';
		}
		catch(\Throwable $t)
		{
			$type 				= 'error';
			$message			= 'Data Pendidikan Non Formal Gagal Disimpan';
		}
		return $this->redirectResponse($request, trans("{$message}"), $type, $find);
	}

	/**
	 * Delete the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\PresPddknNonFormal
	 * @return \Illuminate\Http\Response
	 */
	public function deletePendidikanNonFormal(Request $request)
	{
		$deleted 	= PresPddknNonFormal::where(['i_id' => $request->id])->delete();
		$type 		= !$deleted ? 'error' : 'success';
		$message	= !$deleted ? 'Data Pendidikan Non Formal Gagal Dihapus' : 'Data Pendidikan Non Formal Berhasil Dihapus';
		return $this->redirectResponse($request, trans("{$message}"), $type, $deleted);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\PresPddknNonFormal  $presPddknNonFormal
	 * @return \Illuminate\Http\Response
	 */
	public function updatePendidikanNonFormal(Request $request)
	{
		$input 				= $request->all();
		$jendik = 0;
		$kodik  = '';
		$nadik  = $input['jenjang_pendidikan_lainnya'];
		$nasek  = '';
		if($input['jenjang_pendidikan'] != 'lainnya')
		{
			$jenjang_pendidikan = explode('=',$input['jenjang_pendidikan']);
			$jendik 			= $jenjang_pendidikan[0];
			$kodik 				= $jenjang_pendidikan[1];
			$nadik 				= $jenjang_pendidikan[2];
			$nasek 				= $jenjang_pendidikan[3];
		}
		$user_id 			= auth()->user()->v_userid;
	  	$query 				= $this->presPddknNonFormal::where('v_nrk',  $input['nrk'])
														->where('i_jendik', $jendik)
														->where('v_kodik', $kodik)
														->where('v_nadik', $nadik)
														->where('v_nasek', $nasek)
														->first();
	  	$pddknNonFormal	= PresPddknNonFormal::where('i_id', $input['i_id'])
											->update(['i_jendik' 		=> $jendik,
													  'v_kodik' 		=> $kodik,
													  'v_nadik' 		=> $nadik,
													  'v_nasek' 		=> $nasek,
													  'tx_prestasi' 	=> $input['prestasi_diperoleh'],
													  'v_updated_by' 	=> $user_id,
													]);
		$type 				= $pddknNonFormal ? 'success' : 'error';
		$message			= $pddknNonFormal ? 'Data Pendidikan Non Formal Berhasil Diubah' : 'Data Pendidikan Non Formal Gagal Diubah';
		return $this->redirectResponse($request, trans("{$message}"), $type, $query);
	}

	public function searchNarsum(Request $request)
	{
		$pengalamanNarsum 		= new PengalamanNarsum();
		$getPengalamanNarsum 	= $pengalamanNarsum->searchPengalamanNarsum($request);
		$result 				= $getPengalamanNarsum->paginate($request->limit);
		return $result;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function storeNarsum(Request $request)
	{
		$input 		= $request->all();
		//dd($input);
		$user_id 	= auth()->user()->v_userid;
		$find 		= $this->pengalamanNarsum::where('v_nrk',  $input['nrk'])
											   ->toSql();
		//dd($find);
		try
		{
			//DB::enableQueryLog();
			$this->pengalamanNarsum->create(['v_nrk' 		=> $input['nrk'],
											 'v_kegiatan' 	=> $input['kegiatan'],
											 'v_judul' 		=> $input['judul'],
											 'v_lembaga' 	=> $input['lembaga'],
											 'v_tahun' 		=> $input['selectedYear'],
											 'v_created_by' => $user_id,
											]);
			//dd(DB::getQueryLog());
			$type 				= 'success';
			$message			= 'Data Narasumber Berhasil Disimpan';
		}
		catch(\Throwable $t)
		{
			$type 				= 'error';
			$message			= 'Data Narasumber Gagal Disimpan';
		}
		return $this->redirectResponse($request, trans("{$message}"), $type, $find);
	}

	/**
	 * Delete the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\PengalamanNarsum
	 * @return \Illuminate\Http\Response
	 */
	public function deleteNarsum(Request $request)
	{
		$deleted 	= PengalamanNarsum::where(['id' => $request->id])->delete();
		$type 		= !$deleted ? 'error' : 'success';
		$message	= !$deleted ? 'Data Narasumber Gagal Dihapus' : 'Data Narasumber Berhasil Dihapus';
		return $this->redirectResponse($request, trans("{$message}"), $type, $deleted);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\PengalamanNarsum  $pengalamanNarsum
	 * @return \Illuminate\Http\Response
	 */
	public function updateNarsum(Request $request)
	{
		$input 		= $request->all();
		$user_id 	= auth()->user()->v_userid;
	  	$query 		= $this->pengalamanNarsum::where('v_nrk',  $input['nrk'])
											->first();
		//dd($input);
	  	$narsum		= PengalamanNarsum::where('id', $input['id'])
									  ->update(['v_kegiatan' 	=> $input['kegiatan'],
												'v_judul' 		=> $input['judul'],
												'v_lembaga' 	=> $input['lembaga'],
												'v_tahun' 		=> $input['selectedYear'],
												'v_updated_by' 	=> $user_id,
											]);
		$type 				= $narsum ? 'success' : 'error';
		$message			= $narsum ? 'Data Narsum Berhasil Diubah' : 'Data Narsum Gagal Diubah';
		return $this->redirectResponse($request, trans("{$message}"), $type, $query);
	}

	public function searchKegiatanStrategis(Request $request)
	{
		$kegiatanStrategis 		= new PresKegiatanStrategis();
		$getKegiatanStrategis 	= $kegiatanStrategis->searchKegiatanStrategis($request);
		$result 				= $getKegiatanStrategis->paginate($request->limit);
		return $result;
	}

	public function searchJenisKegiatan(Request $request)
	{
		//dd($request);
		$viewAkunSkpd 	= new DbLinkVwAkunSkpd();
		$getAkunSkpd 	= $viewAkunSkpd->searchJenisKegiatan($request);
		$result 		= $request->limit
							? $viewAkunSkpd->getPagingData($getAkunSkpd)
							: $viewAkunSkpd->getAllData($getAkunSkpd);
		return $result;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function storeKegiatanStrategis(Request $request)
	{

		$input 				= $request->all();
		// $kegiatan 		= explode('=',$input['kegiatan']);
		// $kode_kegiatan 	= $kegiatan[0];
		// $nama_kegiatan 	= $kegiatan[1];
		//dd($kode_kegiatan);
		$user_id 		= auth()->user()->v_userid;
		// $find 			= $this->presKegiatanStrategis::where('v_nrk',  $input['nrk'])
		// 											  ->where('v_tahun_angg', $input['selectedYear'])
		// 											  ->first();
		// if($find)
		// {
		// 	return $this->redirectResponse($request, 'Data Kegiatan Strategis Sudah Ada!', 'error', 'duplicate');
		// 	exit;
		// }
		try
		{
			//dd($input);
			//DB::enableQueryLog();
			$this->presKegiatanStrategis->create(['V_NRK' 			=> $input['nrk'],
											   'V_TAHUN_ANGG' 		=> $input['selectedYear'],
											   'V_NAMA_KEGIATAN' 	=> $input['kegiatan'],
											   'V_JUMLAH_ANGG' 		=> $input['anggaran'],
											   'V_PERAN' 			=> $input['peran'],
											   'v_created_by' 		=> $user_id,
											]);
			//dd(DB::getQueryLog());
			$type 				= 'success';
			$message			= 'Data Kegiatan Strategis Berhasil Disimpan';
		}
		catch(\Throwable $t)
		{
			$type 				= 'error';
			$message			= 'Data Kegiatan Strategis Gagal Disimpan';
		}
		return $this->redirectResponse($request, trans("{$message}"), $type);
	}

	/**
	 * Delete the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\PresKegiatanStrategis
	 * @return \Illuminate\Http\Response
	 */
	public function deleteKegiatanStrategis(Request $request)
	{
		$deleted 	= PresKegiatanStrategis::where(['id' => $request->id])->delete();
		$type 		= !$deleted ? 'error' : 'success';
		$message	= !$deleted ? 'Data Kegiatan Strategis Gagal Dihapus' : 'Data Kegiatan Strategis Berhasil Dihapus';
		return $this->redirectResponse($request, trans("{$message}"), $type, $deleted);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\PresKegiatanStrategis  $presKegiatanStrategis
	 * @return \Illuminate\Http\Response
	 */
	public function updateKegiatanStrategis(Request $request)
	{
		$input 	= $request->all();
		// $kegiatan 		= explode('=',$input['kegiatan']);
		// $kode_kegiatan 	= $kegiatan[0];
		// $nama_kegiatan 	= $kegiatan[1];

		$user_id 			= auth()->user()->v_userid;
	  	$query 				= $this->presKegiatanStrategis->where('v_nrk',  $input['nrk'])
														  ->where('v_tahun_angg', $input['selectedYear'])
														  ->first();
	  	$presKegiatanStrategis	= PresKegiatanStrategis::where('id', $input['id'])
												->update(['v_nrk' 			=> $input['nrk'],
														  'v_tahun_angg' 	=> $input['selectedYear'],
														  'v_nama_kegiatan' => $input['kegiatan'],
														  'v_jumlah_angg' 	=> $input['anggaran'],
														  'v_peran' 		=> $input['peran'],
													      'v_updated_by' 	=> $user_id,
													]);
		$type 		= $presKegiatanStrategis ? 'success' : 'error';
		$message	= $presKegiatanStrategis ? 'Data Prestasi Mengelola Kegiatan Strategis Berhasil Diubah' : 'Data Prestasi Mengelola Kegiatan Strategis Gagal Diubah';
		return $this->redirectResponse($request, trans("{$message}"), $type, $query);
	}







	public function searchPrestasiJabatan(Request $request)
	{
		$prestasiJabatan 	= new PresJabatan();
		$getPrestasiJabatan = $prestasiJabatan->searchPrestasiJabatan($request);
		$result 			= $getPrestasiJabatan->paginate($request->limit);
		return $result;
	}

	public function searchJenisJabatan(Request $request)
	{
		$jenisJabatan 	= new PresJabatan();
		$result 	= $jenisJabatan->searchJenisJabatan($request);
		return $result;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function storePrestasiJabatan(Request $request)
	{
		$input 		= $request->all();
		$user_id 	= auth()->user()->v_userid;
		$jabatan 	= explode('=',$input['jabatan']['value']);
		$kolok		= $jabatan[0];
		$kojab		= $jabatan[1];
		$nalok		= $jabatan[2];
		$najabs		= $jabatan[3];
		$find 		= $this->presJabatan->where('V_NRK', $input['nrk'])
		  										  ->where('V_KOLOK', $kolok)
		  										  ->where('V_KOJAB', $kojab)
		  										  ->where('V_NALOK', $nalok)
		  										  ->where('V_NAJABS', $najabs)
												  ->where('V_TAHUN', $input['selectedYear'])
												  ->first();
		if($find)
		{
			return $this->redirectResponse($request, 'Data Prestasi dalam Jabatan Sudah Ada!', 'error', 'duplicate');
			exit;
		}

		try
		{
			$this->presJabatan->create(['V_NRK' 			=> $input['nrk'],
										'V_KOLOK' 			=> $kolok,
										'V_KOJAB' 			=> $kojab,
										'V_NALOK' 			=> $nalok,
										'V_NAJABS' 			=> $najabs,
										'V_TAHUN' 			=> $input['selectedYear'],
										'TX_KEBERHASILAN' 	=> $input['keberhasilan'],
										'TX_KENDALA' 		=> $input['kendala'],
										'TX_SOLUSI' 		=> $input['solusi'],
										'v_created_by' 		=> $user_id,
										]);
			$type 				= 'success';
			$message			= 'Data Prestasi dalam Jabatan Berhasil Disimpan';
		}
		catch(\Throwable $t)
		{
			$type 				= 'error';
			$message			= 'Data Prestasi dalam Jabatan Gagal Disimpan';
		}
		return $this->redirectResponse($request, trans("{$message}"), $type,$find);
	}

	/**
	 * Delete the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\PresKegiatanStrategis
	 * @return \Illuminate\Http\Response
	 */
	public function deletePrestasiJabatan(Request $request)
	{
		$deleted 	= PresJabatan::where(['id' => $request->id])->delete();
		$type 		= !$deleted ? 'error' : 'success';
		$message	= !$deleted ? 'Data Prestasi dalam Jabatan Gagal Dihapus' : 'Data Prestasi dalam Jabatan Berhasil Dihapus';
		return $this->redirectResponse($request, trans("{$message}"), $type, $deleted);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\PresKegiatanStrategis  $presKegiatanStrategis
	 * @return \Illuminate\Http\Response
	 */
	public function updatePrestasiJabatan(Request $request)
	{
		$input 		= $request->all();
		$user_id 	= auth()->user()->v_userid;
		$jabatan 	= explode('=', $input['jabatan']['value']);
		$kolok		= $jabatan[0];
		$kojab		= $jabatan[1];
		$nalok		= $jabatan[2];
		$najabs		= $jabatan[3];

	  	$query 		= $this->presJabatan->where('V_NRK', $input['nrk'])
		  										  ->where('V_KOLOK', $kolok)
		  										  ->where('V_KOJAB', $kojab)
		  										  ->where('V_NALOK', $nalok)
		  										  ->where('V_NAJABS', $najabs)
												  ->where('V_TAHUN', $input['selectedYear'])
												  ->first();

	  	$presPrestasiJabatan	= PresJabatan::where('id', $input['id'])
											 ->update(['V_NRK' 			=> $input['nrk'],
														'V_KOLOK' 		=> $kolok,
														'V_KOJAB' 		=> $kojab,
														'V_NALOK' 		=> $nalok,
														'V_NAJABS' 		=> $najabs,
														'V_TAHUN' 		=> $input['selectedYear'],
														'TX_KEBERHASILAN' => $input['keberhasilan'],
														'TX_KENDALA' 		=> $input['kendala'],
														'TX_SOLUSI' 		=> $input['solusi'],
														'v_updated_by' 	=> $user_id,
													]);
		$type 		= $presPrestasiJabatan ? 'success' : 'error';
		$message	= $presPrestasiJabatan ? 'Data Prestasi dalam Jabatan Berhasil Diubah' : 'Data Prestasi dalam Jabatan Gagal Diubah';
		return $this->redirectResponse($request, trans("{$message}"), $type, $query);
	}

	public function getAtasanForAllTW($nrk)
	{
		$blnTw = [
			'1' => '03',
			'2' => '06',
			'3' => '09',
			'4' => '12',
		];

		$currentYear = now()->format('Y');
		$tws = [];
		foreach ($blnTw as $key => $value) {
			array_push($tws, "{$currentYear}{$value}");
		}

		$atasan = $this->viewAtasanRepo->getAtasanForAllTW($nrk, $tws);

		$data = [];
		foreach ($tws as $tw) {
			$find = collect($atasan)->where('v_thbl', $tw)->first();
			$dataAtasan = $find->atasan ?? null;
			$data[] = [
				'thbl' => $tw,
				'atasan' => [
					'nama' => $dataAtasan->v_nama ?? null,
					'nrk' => $dataAtasan->v_nrk ?? null,
					'nalok' => $dataAtasan->nalok ?? null,
					'najab' => $dataAtasan->najabl ?? null,
				],
			];
		}

		return $data;
	}
}
