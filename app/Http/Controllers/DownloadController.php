<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MediaDocument;

class DownloadController extends Controller
{
  public function show(MediaDocument $media)
  {
    $headers = ['Content-Type' => $media->mime_type];
    return response()->download($media->getPath(), $media->file_name, $headers, 'inline');
  }

  public function showNonMedia($params)
  {
    $decode = json_decode(decrypt_params($params));
    // index 0 must filename
    $file_name = $decode[0];
    // index 1 must date from created_at
    $date = \Carbon\Carbon::parse($decode[1]);
    $headers = [];
    $path = file_path($date, $file_name);
    return response()->download($path, $file_name, $headers, 'inline');
  }
}
