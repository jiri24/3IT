<?php namespace app\models;

use DbConfig;
use dibi;
use Latte;

class DataManager
{
   public function getData() :array {
      DbConfig::getDbConnection();
      return dibi::query('SELECT * FROM `zaznamy` ORDER BY datum')->fetchAll();
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
