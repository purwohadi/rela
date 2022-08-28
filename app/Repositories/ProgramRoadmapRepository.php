<?php

namespace App\Repositories;

use App\Models\TmProgramRoadmap;
use App\Repositories\Contracts\ProgramRoadmapRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgramRoadmapRepository implements ProgramRoadmapRepositoryInterface
{
  protected $program_roadmap;

  public function __construct(TmProgramRoadmap $program_roadmap)
  {
    $this->program_roadmap = $program_roadmap;
  }

  public function save($request)
  {
    $input 		= $request->all();
    $is_edit = !empty($input['id']);
		$user_id 	= auth()->user()->v_userid;
    DB::beginTransaction();

		try
		{			
			if ($is_edit) {
        $data = ['tujuan_rpd_id' => $input['tujuan_id'], 
					'sasaran_rpd_id' => $input['sasaran_id'], 
					'program' => $input['program'], 
					'bidur_kode' => $input['bidur_kode'],
					'opd_id' => $input['opd_id'],
					'updated_by' => $user_id,
					'updated_at' => date('Y-m-d H:i:s')
					];
        $before = $this->program_roadmap->find($input['id']);

        $updateData = $this->program_roadmap->find($input['id']);
        $updateData->update($data);
  
        $save = $updateData;
        createLog(config('tables.master.tm_program_roadmap'), 'UPD', [
          'before' => collect($before)->sortKeys(),
          'after' => collect($updateData)->sortKeys()
        ]);
  
        $type 				= 'success';
        $errorMsg			= '';
        $message			= 'Data Inisiatif Strategis Peta Rencana Berhasil Diubah.';
        DB::commit();

      } else {
        $data = ['tujuan_rpd_id' => $input['tujuan_id'], 
					'sasaran_rpd_id' => $input['sasaran_id'], 
					'program' => $input['program'], 
					'bidur_kode' => $input['bidur_kode'],
					'opd_id' => $input['opd_id'],
					'created_by' => $user_id,
					'created_at' => date('Y-m-d H:i:s')
					];
        $save = $this->program_roadmap->create($data);
        createLog(config('tables.master.tm_program_roadmap'), 'INS', collect($save)->sortKeys());
  
        $type 				= 'success';
        $message			= 'Data Inisiatif Strategis Peta Rencana Berhasil Disimpan';
        DB::commit();
      }
			

		}catch(\Throwable $t){
			$type 				= 'error';
			$save 				= $t->getMessage();
			$message			= 'Data Inisiatif Strategis Peta Rencana Gagal Disimpan';
		}
    DB::rollBack();

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'save' => $save
				 ];
		return json_encode($hasil);
	}

  // public function update(Request $request){
	// 	$input 		= $request->all();
	// 	$user_id 	= auth()->user()->v_userid;
	// 	$before = $this->program_roadmap->find($input['id']);
	// 	DB::beginTransaction();
	// 	try
	// 	{
	// 		$data = ['tujuan_rpd_id' => $input['tujuan_id'], 
	// 				'sasaran_rpd_id' => $input['sasaran_id'], 
	// 				'program' => $input['program'], 
	// 				'bidur_kode' => $input['bidur_kode'],
	// 				'opd_id' => $input['opd_id'],
	// 				'updated_by' => $user_id,
	// 				'updated_at' => date('Y-m-d H:i:s')
	// 				];

	// 		$updateData = $this->program_roadmap->find($input['id']);
	// 		$updateData->update($data);

	// 		$save = $updateData;
	// 		createLog(config('tables.master.tm_program_roadmap'), 'UPD', [
	// 			'before' => collect($before)->sortKeys(),
	// 			'after' => collect($updateData)->sortKeys()
	// 		]);

	// 		$type 				= 'success';
	// 		$errorMsg			= '';
	// 		$message			= 'Data Inisiatif Strategis Peta Rencana Berhasil Diubah.';
	// 		DB::commit();
	// 	}catch(\Throwable $t){
	// 		$type 				= 'error';
	// 		$save 			= $t->getMessage();
	// 		$message			= 'Data Inisiatif Strategis Peta Rencana Gagal Diubah.';
	// 		DB::rollBack();
	// 	}

	// 	$hasil = ['type'=>$type,
	// 			  'message' => $message,
	// 			  'save' => $save
	// 			 ];
	// 	return json_encode($hasil);
	// }

  public function getProgramRoadmapByBidur(Request $request)
  {
    $input 		= $request->all();

    $query = $this->program_roadmap
      ->where('bidur_kode', $input['bidur_kode'])
      ->where('opd_id', $input['opd_id']);
    return $query->first();
  }
}
