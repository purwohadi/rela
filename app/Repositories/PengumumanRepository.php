<?php

namespace App\Repositories;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Http\Resources\BannerResources;
use App\Http\Resources\PengumumanResources;
use App\Repositories\Contracts\PengumumanRepositoryInterface;

class PengumumanRepository extends BaseRepository implements PengumumanRepositoryInterface
{
  protected $pengumuman;

  protected $columns = [
    'kategori' => 'ref.v_value',
    'tx_isi_pengumuman' => 'tx_isi_pengumuman',
    'v_updated_by' => 'tm_pengumuman.v_updated_by',
    'dt_updated_at' => 'tm_pengumuman.dt_updated_at',
    'e_status_aktif' => 'tm_pengumuman.e_status_aktif',
  ];


  protected $pengumuman_list_flag = 1;
  protected $pengumuman_banner_flag = 2;
  protected $pengumuman_aktif = 1;

  public function __construct(Pengumuman $pengumuman)
  {
    $this->pengumuman = $pengumuman;
  }

  /**
   * Get's pengumuman by specific condition.
   *
   * @return mixed
   */
  public function search(Request $request)
  {
    $ref = \DB::table('tr_referensi_umum')
    ->where('v_type', 'Ref Pengumuman')
    ->where('e_aktif', 1);

    $query = $this->pengumuman->query()
      ->select([
        'tm_pengumuman.*',
        'ref.v_value as kategori',
      ])
      ->leftJoinSub($ref, 'ref', function ($join) {
        $join->on('ref.v_key', '=', 'tm_pengumuman.e_kat_pengumuman');
      })
      ->orderBy($this->columns[$request->sort_by], $request->sort_desc);

    // jika ada filter kategori
    if ($request->filter_select) {
      $query = $query->where('ref.v_key', $request->filter_select);
    }

    // handling searchBy
    if ($request->has('search') && strlen(trim($request->search)) > 0) {
      $mapped = $this->columns;
      $query = $query->where(function ($sql) use ($request, $mapped) {
        $idx = 0;
        foreach ($request->column_filters as $column) {
          $clause = $idx == 0 ? 'where' : 'orWhere';
          $sql->{$clause}(\DB::raw("upper({$mapped[$column]})"), 'like', '%' . strtoupper($request->search) . '%');
          ++$idx;
        }
      });

    }
    // dd($query->toSql());
    return $query->paginate($request->limit);
  }


  /**
   * Save a pengumuman
   *
   * @param array $input
   */
  public function save(array $input)
  {
    return $this->pengumuman->create([
      'v_kode_pengumuman' => $input['v_kode_pengumuman'],
      'v_nama_pengumuman' => $input['v_nama_pengumuman'],
      'v_unit_id' => $input['v_unit_id'],
      'e_bidang' => $input['e_bidang'],
      'e_is_induk' => $input['e_is_induk'],
      'v_tahun_awal' => $input['v_tahun_awal'],
      'v_tahun_akhir' => $input['v_tahun_akhir'],
      'v_created_by' => $input['v_created_by'],
      'v_updated_by' => null
    ]);
  }

  /**
   * Updates a pengumuman.
   *
   * @param int
   * @param array
   */
  public function edit($slug, array $data)
  {
    $pengumuman = Pengumuman::findBySlug($slug);
    return $pengumuman->update($data);
  }


  public function save_image(Pengumuman $post, array $input, UploadedFile $image = null)
  {
    \DB::transaction(function () use ($post, $input, $image) {
      $currentBannerImage = $post->getMedia('banner image')->first();

      // Delete current image if replaced or delete asking
      if ($currentBannerImage && ($image || !$input['has_banner_image'])) {
        $currentBannerImage->delete();
      }

      if ($image) {
        $post->addMedia($image)
          ->toMediaCollection('banner image');
      }

      return true;
    });

    return true;
  }

  public function getListPengumuman($params) {
    $pengumuman = $this->pengumuman
    ->where('e_kat_pengumuman', 1)
    ->where('e_status_aktif', 1)
    ->orderBy('dt_created_at', 'desc');

    $banner = $this->getBanner();

    $pengumuman_all = $pengumuman->get();
    $pengumuman_new = $pengumuman->latest('dt_created_at')->first();
    $all = $pengumuman_all->reject(function ($value) use ($pengumuman_new){
      return $value->i_id == $pengumuman_new->i_id;
    });
    $banner = $banner->filter(function ($item){
      return $item->has_banner_image;
    });

    return ([
      'new' => $pengumuman_new ? new PengumumanResources($pengumuman_new) : null,
      'all' => $all->isNotEmpty() ? PengumumanResources::collection($all) : null,
      'banners' => $all->isNotEmpty() ? BannerResources::collection($banner) : null
    ]);
  }

  public function getBanner() {
    $banner = $this->pengumuman
    ->where('e_kat_pengumuman', 2)
    ->where('e_status_aktif', 1)
    ->orderBy('dt_created_at', 'desc')->get();

    return $banner;
  }
}
