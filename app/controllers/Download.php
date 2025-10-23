<?php namespace app\controllers;

use Latte;
use Nette\Forms\Form;
use JsonSchema\Validator;
use JsonSchema\Constraints\Constraint;
use app\models\DataManager;

class Download
   implements App
{
   // Stažení a uložení dat z JSON
   public function run(){
      $form = new Form;
      $form->addText('address', 'URL adresa:')
         ->setHtmlAttribute('placeholder', 'Zadejte URL adresu JSON souboru')
         ->setHtmlAttribute('class', 'form-control')
         ->addRule(Form::URL, 'Zadejte platnou URL adresu.')
         ->setRequired('Zadejte prosím URL adresu.');
      $form->addSubmit('send', 'Stáhnout')
         ->setHtmlAttribute('class', 'btn btn-primary');
      $form->addProtection();

      // Formulář byl úspěšně odeslán
      if ($form->isSuccess()) {
	      $address = $form->getValues()->address;

         // Stáhnutí obsahu
         $data = @file_get_contents($address);
         if ($data === false) {
            $form->addError('Nepodařilo se načíst data ze zadané URL adresy.');
         } else {
            // Je JSON validní?
            $json = json_decode($data);
            if (json_last_error() !== JSON_ERROR_NONE) {
               $form->addError('Stažený obsah není validní JSON.');
            } else {
               $schema = (object)[
                  "type" => "array",
                  "items" => (object)[
                     "type" => "object",
                     "required" => ["id", "jmeno", "prijmeni", "date"],
                     "properties" => (object)[
                        "id" => (object)[
                           "type" => "integer"
                        ],
                        "jmeno" => (object)[
                           "type" => "string"
                        ],
                        "prijmeni" => (object)[
                           "type" => "string"
                        ],
                        "date" => (object)[
                           "type" => "string",
                           "pattern" => "^\\d{4}-\\d{2}-\\d{2}$"
                        ]
                     ],
                     "additionalProperties" => false
                  ]
               ];

               $validator = new Validator();
               $validator->validate($json, $schema, Constraint::CHECK_MODE_APPLY_DEFAULTS);
            
               if (!$validator->isValid()) {
                  // JSON neodpovídá požadované struktuře
                  $form->addError('JSON neodpovídá požadované struktuře.');
               } else {
                  // Úspěšná validace
                  $dataManager = new DataManager();
                  $dataManager->insertData($json);
                  header('Location: /');
                  exit;
               }
            }
         }
      }

      $engine = Latte::getEngine();
      $engine->render(__DIR__ . '/../views/download.latte', ['form' => $form, 'active' => 'download']);
   }
}


