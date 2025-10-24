<?php namespace app\controllers;

use DbConfig;
use dibi;
use Latte;
use app\models\DataManager;
use Nette\Http\Session;
use Nette\Http\RequestFactory;
use Nette\Http\Response;

class Tabulka
   implements App
{

   public function run() :void {
      // Získání dat z databáze
      $dataManager = new DataManager();
      $res = $dataManager->getData(20, 0);

      // Zpracování rychlé zprávy
      $factory = new RequestFactory;
      $request = $factory->fromGlobals();
      $response = new Response;
      $session = new Session($request, $response);
      $session->start();

      $flash = $session->getSection('flash');
      $values = ['res' => $res, 'active' => 'home'];
      if (isset($flash->message)) {
         $values['message'] = $flash->message;
         unset($flash->message);
      }
      $engine = Latte::getEngine();
      $engine->render(__DIR__ . '/../views/tabulka.latte', $values);
   }
}
