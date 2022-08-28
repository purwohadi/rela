<?php

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

Str::macro('getCurrentDate', function ($format = null) {
  return is_null($format)
  ? Carbon::now()
  : Carbon::now()->translatedFormat($format);
});

Str::macro('setPageTitle', function ($currentPage = null) {
  return is_null($currentPage)
  ? config('app.name')
  : $currentPage . " | " . config('app.name');
});

Str::macro('compressBase64', function ($str, $gztype = ZLIB_ENCODING_RAW) {
  return base64_encode(zlib_encode($str, $gztype, 9));
});

Str::macro('decompressBase64', function ($str, $gztype = 'deflate') {
  return @zlib_decode(base64_decode($str));
});

EloquentBuilder::macro('searchingBy', function ($mappedColumns, $columns, $search) {
  return $this->where(function ($sql) use ($mappedColumns, $columns, $search) {
    $idx = 0;
    foreach ($columns as $column) {
      if (mb_strpos($mappedColumns[$column], '.') !== false) {
        $clause = $idx == 0 ? 'whereHas' : 'orWhereHas';
        [$relation, $field] = explode('.', $mappedColumns[$column]);
        $sql->$clause($relation, function ($q) use ($field, $search) {
          $q->where(\DB::raw("upper({$field})"), 'like', '%' . strtoupper($search) . '%');
        });
      } else {
        $clause = $idx == 0 ? 'where' : 'orWhere';
        $sql->{$clause}(\DB::raw("upper({$mappedColumns[$column]})"), 'like', '%' . strtoupper($search) . '%');
      }
      ++$idx;
    }
  });
});
