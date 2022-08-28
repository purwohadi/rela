<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  protected function redirectResponse(Request $request, $message, $type = 'success', $data=null)
  {
    if ($request->wantsJson()) {
      return response()->json([
        'status'  => $type,
        'message' => $message,
        'data' => $data,
      ]);
    }

    return redirect()->back()->with("flash_{$type}", $message);
  }
}
