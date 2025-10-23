<?php namespace app\controllers;

use DbConfig;
use dibi;
use Latte;
use app\models\DataManager;

class Tabulka
   implements App
{

   public function run() :void {
      $dataManager = new DataManager();
      $res = $dataManager->getData();

      $engine = Latte::getEngine();
      $engine->render(__DIR__ . '/../views/tabulka.latte', ['res' => $res, 'active' => 'home']);
   }
}
