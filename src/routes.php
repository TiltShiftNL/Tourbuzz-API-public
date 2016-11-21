<?php

/**
 * @SWG\Info(title="Tourbuzz API", version="1.0")
 */

/**
 * @SWG\Get(
 *     path="/berichten",
 *     produces={"application/json"},
 *     summary="Geeft een lijst terug met berichten",
 *     @SWG\Response(
 *         response=200,
 *         description="Geeft een lijst terug met berichten"
 *     ),
 * )
 */
$app->get('/berichten', 'App\Controller\BerichtenController:index');

/**
 * @SWG\Get(
 *     path="/berichten/{jaar}/{maand}/{dag}",
 *     produces={"application/json"},
 *     summary="Geeft een lijst terug met berichten voor een dag",
 *     @SWG\Response(
 *         response=200,
 *         description="Geeft een lijst terug met berichten voor een dag",
 *     ),
 *     @SWG\Parameter(
 *         description="Jaar",
 *         in="path",
 *         name="jaar",
 *         required=true,
 *         type="integer"
 *     ),
 *     @SWG\Parameter(
 *         description="Maand",
 *         in="path",
 *         name="maand",
 *         required=true,
 *         type="integer"
 *     ),
 *     @SWG\Parameter(
 *         description="Dag",
 *         in="path",
 *         name="dag",
 *         required=true,
 *         type="integer"
 *     ),
 * )
 */
$app->get('/berichten/{jaar}/{maand}/{dag}', 'App\Controller\BerichtenController:index');

/**
 * @SWG\Get(
 *     path="/berichten/{id}",
 *     produces={"application/json"},
 *     summary="Geeft een bericht terug",
 *     @SWG\Response(
 *         response=200,
 *         description="Geeft een bericht terug",
 *     ),
 *     @SWG\Parameter(
 *         description="ID",
 *         in="path",
 *         name="id",
 *         required=true,
 *         type="integer"
 *     )
 * )
 */
$app->get('/berichten/{id}', 'App\Controller\BerichtenController:get');
$app->post('/berichten', 'App\Controller\BerichtenController:post');
$app->delete('/berichten', 'App\Controller\BerichtenController:delete');

/**
 * @SWG\Get(
 *     path="/haltes",
 *     produces={"application/json"},
 *     summary="Geeft de haltes terug",
 *     @SWG\Response(
 *         response=200,
 *         description="Geeft een lijst met haltes terug",
 *     )
 * )
 */
$app->get('/haltes', 'App\Controller\HaltesController:index');
/**
 * @SWG\Get(
 *     path="/haltes/{id}",
 *     produces={"application/json"},
 *     summary="Geeft een halte terug",
 *     @SWG\Response(
 *         response=200,
 *         description="Geeft een halte terug",
 *     ),
 *     @SWG\Parameter(
 *         description="ID",
 *         in="path",
 *         name="id",
 *         required=true,
 *         type="integer"
 *     )
 * )
 */
$app->get('/haltes/{id}', 'App\Controller\HaltesController:index');

/**
 * @SWG\Get(
 *     path="/parkeerplaatsen",
 *     produces={"application/json"},
 *     summary="Geeft de parkeerplaatsen terug",
 *     @SWG\Response(
 *         response=200,
 *         description="Geeft een lijst met parkeerplaatsen terug",
 *     )
 * )
 */
$app->get('/parkeerplaatsen', 'App\Controller\ParkeerController:index');

/**
 * @SWG\Get(
 *     path="/parkeerplaatsen/{id}",
 *     produces={"application/json"},
 *     summary="Geeft een parkeerplaats terug",
 *     @SWG\Response(
 *         response=200,
 *         description="Geeft een parkeerplaats terug",
 *     ),
 *     @SWG\Parameter(
 *         description="ID",
 *         in="path",
 *         name="id",
 *         required=true,
 *         type="integer"
 *     )
 * )
 */
$app->get('/parkeerplaatsen/{id}', 'App\Controller\ParkeerController:index');

$app->get('/afbeeldingen/{id}/', 'App\Controller\AfbeeldingController:transform');
$app->get('/afbeeldingen/{id}', 'App\Controller\AfbeeldingController:transform');
$app->options('/afbeeldingen', 'App\Controller\AfbeeldingController:options');
$app->post('/afbeeldingen', 'App\Controller\AfbeeldingController:post');

$app->get('/poi', 'App\Controller\PoiController:index');

$app->get('/distance', 'App\Controller\DistanceController:distance');

$app->get('/auth', 'App\Controller\AuthController:token');
$app->post('/auth', 'App\Controller\AuthController:login');
$app->delete('/auth', 'App\Controller\AuthController:logout');

$app->post('/accounts', 'App\Controller\AccountController:create');
$app->get('/accounts', 'App\Controller\AccountController:index');
$app->get('/accounts/{username}', 'App\Controller\AccountController:single');
$app->put('/accounts', 'App\Controller\AccountController:update');
$app->delete('/accounts/{username}', 'App\Controller\AccountController:delete');

$app->post('/vergeten', 'App\Controller\VergetenController:vergeten');
$app->get('/vergeten/{token}', 'App\Controller\VergetenController:checkToken');
$app->put('/vergeten', 'App\Controller\VergetenController:changePasswordByToken');

$app->post('/mail', 'App\Controller\MailController:register');
$app->get('/mail/{token}', 'App\Controller\MailController:confirm');
$app->post('/mail/unsubscribe', 'App\Controller\MailController:unsubscribe');
$app->get('/mail/unsubscribe/{token}', 'App\Controller\MailController:unsubscribeConfirm');
$app->get('/mail', 'App\Controller\MailController:index');

$app->post('/telefoon', 'App\Controller\TelefoonController:register');
$app->delete('/telefoon', 'App\Controller\TelefoonController:unsubscribe');
$app->get('/telefoon', 'App\Controller\TelefoonController:index');

$app->post('/translate', 'App\Controller\TranslateController:translate');

$app->get('/vialis', 'App\Controller\VialisController:index');