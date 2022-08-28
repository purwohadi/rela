<?php

namespace App\Image\Templates;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class Slide implements FilterInterface
{
  public function applyFilter(Image $image)
  {
    return $image->fit(1440, 600);
  }
}
