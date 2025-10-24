<?php namespace app\controllers;

use DbConfig;
use dibi;
use Latte;
use app\models\DataManager;
use Nette\Http\Response;
use Nette\Http\Request;
use Nette\Http\RequestFactory;

class API
   implements App
{
   // Vrací data ve formátu JSON
   public function run() :void {
      // Zjištění parametrů
      $factory = new RequestFactory;
      $httpRequest = $factory->fromGlobals();
      $params = $httpRequest->getQuery();
      // Získání dat z databáze
      $dataManager = new DataManager();
      $data = [];
      if (isset($params['limit']) && isset($params['offset'])) {
         $data = $dataManager->getData($params['limit'], $params['offset']);
      } else {
         $data = $dataManager->getData();
      }
      // Vrátíme výstup jako JSON
      $response = new Response;
      $response->setContentType('application/json', 'utf-8');
      $response->setCode(Response::S200_OK);
      $response->setHeader('Cache-Control', 'no-cache, no-store, must-revalidate');

      echo json_encode($data, JSON_PRETTY_PRINT);
      exit;
   }
}
