<?php namespace app\models;

use DbConfig;
use dibi;
use Latte;

class DataManager
{
   public function getData(int $limit=0, int $offset=0) :array {
      DbConfig::getDbConnection();
      $query = 'SELECT * FROM `zaznamy` ORDER BY datum';
      if ($limit > 0 && $offset >= 0) {
         $query .= ' LIMIT ' . $limit . ' OFFSET ' . $offset;
      }
      return dibi::query($query)->fetchAll();
   }

   public function insertData(array $data) :void {
      DbConfig::getDbConnection();
      foreach ($data as $item) {
         dibi::query('INSERT INTO `zaznamy`', [
            'jmeno' => $item->jmeno,
            'prijmeni' => $item->prijmeni,
            'datum' => $item->date
         ]);
      }
   }
}
