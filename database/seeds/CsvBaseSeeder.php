<?php
ini_set('auto_detect_line_endings', TRUE);

use Illuminate\Database\Seeder;

class CsvBaseSeeder extends Seeder
{

  /**
   * Run DB seed
   */
  public function run()
  {
    Eloquent::unguard();
  }

  /**
   * Collect data from a given CSV file and return as array
   *
   * @param $filename
   * @param string $deliminator
   * @return array|bool
   */
  public function seedFromCSV($filename, $deliminator = ";", $parse_header = true)
  {
    if (!file_exists($filename) || !is_readable($filename)) {
      return FALSE;
    }

    $header = null;
    $data = array();
    if (($handle = fopen($filename, 'r')) !== FALSE) {
      if ($parse_header) {
        $header = fgetcsv($handle, 5120, $deliminator);
      }
      while (($row = fgetcsv($handle, 5120, $deliminator)) !== FALSE) {
        // if(!$header) {
        //   $header = $row;
        // } else {
        //   $data[] = array_combine($header, $row);
        // }
        if ($parse_header)
          $data[] = array_combine($header, $row);
        else
          $data[] = $row;
      }
      fclose($handle);
    }

    return $data;
  }
}
