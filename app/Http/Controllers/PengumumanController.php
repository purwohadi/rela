<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use App\Repositories\Contracts\PengumumanRepositoryInterface;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
  protected $pengumuman;

  /**
   * PengumumanController constructor.
   *
   * @param PengumumanRepositoryInterface $role
   */
  public function __construct(PengumumanRepositoryInterface $pengumuman)
  {
    $this->pengumuman = $pengumuman;
  }

  /**
   * Display a listing of the pengumuman
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function search(Request $request)
  {
    return $this->pengumuman->search($request);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $pengumuman = Pengumuman::create([
        'e_kat_pengumuman' => $request->kategori,
        // 'e_highlight' => $request->highlight,
        'tx_isi_pengumuman' => $request->file('image') ? $request->file('image')->getClientOriginalName() : $request->pengumuman,
        'e_status_aktif' => 1,
        'v_created_by' => $request->username
    ]);

    $this->pengumuman->save_image($pengumuman, $request->input(), $request->file('image'));

    return $this->redirectResponse($request, 'Banner berhasil disimpan.');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function drop(Request $request)
  {
    $data = Pengumuman::findBySlug($request->slug);
    $deleted = $data->delete();
    $type = !$deleted ? 'error' : 'success';

    return $this->redirectResponse($request, trans("actions.delete.{$type}"), $type, $deleted);
  }

  /**
   * Show
   *
   * @param  \Illuminate\Http\Request  $request
   * @return String
   */
  public function show($id)
  {
    $show = Pengumuman::findBySlug($id);
    return $show;
  }

  /**
   * Edit pengumuman
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request)
  {
    $request->merge([
      'v_updated_by' => $request->username,
      'e_kat_pengumuman' => $request->kategori,
      'tx_isi_pengumuman' => $request->file('image') ? $request->file('image')->getClientOriginalName() : $request->pengumuman,
      // 'e_highlight' => $request->kategori == 1 ? $request->highlight : null,
    ]);

    $pengumuman = $this->pengumuman->edit(
      $request->slug_path,
      $request->only([
        'e_kat_pengumuman',
        'tx_isi_pengumuman',
        // 'e_highlight',
        'v_updated_by'
      ])
    );

    $data = Pengumuman::findBySlug($request->slug_path);
    $this->pengumuman->save_image($data, $request->input(), $request->file('image'));

    $type = $pengumuman ? 'success' : 'error';
    return $this->redirectResponse($request, trans("actions.update.{$type}"), $type, $pengumuman);
  }

  public function activeToggle(Request $request)
  {
    $user = auth()->user()->v_userid;
    $pengumuman = Pengumuman::findBySlug($request->slug);
    $toggle = $pengumuman->e_status_aktif == 1;

    if ($toggle) {
      $pengumuman->update([
        'e_status_aktif' => 0,
        'v_updated_by' => $user
      ]);
    } else {
      $pengumuman->update([
        'e_status_aktif' => 1,
        'v_updated_by' => $user
      ]);
    }

    $type = $pengumuman ? 'success' : 'error';
    return $this->redirectResponse($request, trans("actions.update.{$type}"), $type, $pengumuman);
  }

  // public function highlightToggle(Request $request)
  // {
  //   $user = auth()->user()->v_userid;
  //   $pengumuman = Pengumuman::findBySlug($request->slug);
  //   $toggle = $pengumuman->e_highlight == 1;

  //   if ($toggle) {
  //     $pengumuman->update([
  //       'e_highlight' => 0,
  //       'v_updated_by' => $user
  //     ]);
  //   } else {
  //     $pengumuman->update([
  //       'e_highlight' => 1,
  //       'v_updated_by' => $user
  //     ]);
  //   }

  //   $type = $pengumuman ? 'success' : 'error';
  //   return $this->redirectResponse($request, trans("actions.update.{$type}"), $type, $pengumuman);
  // }

  public function getListPengumuman(Request $request)
  {
    return $this->pengumuman->getListPengumuman($request->all());
  }
}
