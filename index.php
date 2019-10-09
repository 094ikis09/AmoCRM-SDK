<?php

require 'vendor/autoload.php';

use AmoCRM\Account\AccountController;
use AmoCRM\AmoCRM;
use AmoCRM\CustomField\CustomFieldsController;
use AmoCRM\Pipelines\PipelineController;

enableWhoops();

$faker = Faker\Factory::create();
$faker->addProvider(new Faker\Provider\Base($faker));

$amo = new AmoCRM('har9fox', 'har9fox@yahoo.com', '7d22ec38e3be7cc5dac408c01f86e589bff1d048');

// $cus = new CustomFieldsController($amo, '123');

// $a = $cus->getCustomFields($cus::CF_ET_LEADS);

// foreach ($a as $key => $value) {
//    $cus->addDeleteCusstomField($value);
// }

// $cus->deleteCustomField();



$pc = new PipelineController($amo);

// debug($pc->getPipelines());

$a = $pc->createablePipeline();
$a->setName('Name');
$b = $pc->createablePipeline();
$b = clone $a;
debug($pc);

// $pc->editPipelines();

// $pc->addDeletePipeline($pc->getPipelines()[0]);

// debug($pc->deletePipeline());

// debug($pc->getPipelines());

// $a = $pc->createablePipeline();
// $a->setName('TEST');
// $s = $a->addStatuses();
// $s->setName('TEST');
// // $s->setSort(1);
// // $s->setColor('#f2f3f4');


// debug($pc->createPipeline());

// $cp = $pc->createablePipeline();





// $a = $pc->getPipelines();

// $b = $a[0]->statuses;

// $b[0]->

// $ep = $pc->editablePipeline($pc->getPipelines()[0]);

// debug($ep);

// $estatus = $ep->getStatuses();

// $count = count($estatus);

// foreach ($estatus as $key => $value) {
//    $ep->deleteStatus($value);
//    goto Next;
// }
// Next:
// // $estatus[array_keys($estatus)[0]]->setName('Rename Status');
// // $estatus[array_keys($estatus)[0]]->setColor('#ff8f92');

// debug($ep->generateQuery());

// // $ep->setName('Rename1 Pipeline');

// debug($pc->editPipelines());
