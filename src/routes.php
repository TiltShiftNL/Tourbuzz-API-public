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
/**
 * @SWG\Get(
 *     path="/berichten",
 *     produces={"application/json"},
 *     summary="Bericht aanmaken of bijwerken",
 *     @SWG\Parameter(description="Token", in="query", name="token", required=true, type="string"),
 *     @SWG\Parameter(description="Bericht ID", in="formData", name="id", required=true, type="integer"),
 *     @SWG\Parameter(description="Sms tekst Engels", in="formData", name="sms_end", required=true, type="string"),
 *     @SWG\Parameter(description="Sms tekst Duits", in="formData", name="sms_de", required=true, type="string"),
 *     @SWG\Parameter(description="Sms tekst Nederlands", in="formData", name="sms_nl", required=true, type="string"),
 *     @SWG\Parameter(description="Titel", in="formData", name="title", required=true, type="string"),
 *     @SWG\Parameter(description="Bericht", in="formData", name="body", required=true, type="text"),
 *     @SWG\Parameter(description="Advies", in="formData", name="advice", required=true, type="text"),
 *     @SWG\Parameter(description="Titel (Engels)", in="formData", name="title_en", required=true, type="text"),
 *     @SWG\Parameter(description="Bericht (Engels)", in="formData", name="body_en", required=true, type="text"),
 *     @SWG\Parameter(description="Advies (Engels)", in="formData", name="advice_en", required=true, type="text"),
 *     @SWG\Parameter(description="Titel (Duits)", in="formData", name="title_de", required=true, type="text"),
 *     @SWG\Parameter(description="Bericht (Duits)", in="formData", name="body_de", required=true, type="text"),
 *     @SWG\Parameter(description="Advies (Duits)", in="formData", name="advice_de", required=true, type="text"),
 *     @SWG\Parameter(description="Titel (Spaans)", in="formData", name="title_es", required=true, type="text"),
 *     @SWG\Parameter(description="Bericht (Spaans)", in="formData", name="body_es", required=true, type="text"),
 *     @SWG\Parameter(description="Advies (Spaans)", in="formData", name="advice_es", required=true, type="text"),
 *     @SWG\Parameter(description="Afbeelding ID", in="formData", name="image_id", required=true, type="integer"),
 *     @SWG\Parameter(description="Startdatum (yyyy-mm-dd hh:ii:ss)", in="formData", name="startdate", required=false, type="string"),
 *     @SWG\Parameter(description="Einddatum (yyyy-mm-dd hh:ii:ss)", in="formData", name="startdate", required=false, type="string"),
 *     @SWG\Parameter(description="Link", in="formData", name="link", required=false, type="string"),
 *     @SWG\Parameter(description="Kaart opnemen (1=ja, 0=nee)", in="formData", name="include_map", required=false, type="integer"),
 *     @SWG\Parameter(description="Categorie", in="formData", name="category", required=false, type="string"),
 *     @SWG\Parameter(description="Afbeelings URL", in="formData", name="image_url", required=false, type="string"),
 *     @SWG\Parameter(description="Belangrijk", in="formData", name="important", required=false, type="string"),
 *     @SWG\Parameter(description="Is live", in="formData", name="is_live", required=false, type="string"),
 *     @SWG\Parameter(description="Geo punt lat", in="formData", name="location_lat", required=false, type="string"),
 *     @SWG\Parameter(description="Geo punt lng", in="formData", name="location_lng", required=false, type="string"),
 *     @SWG\Response(response=200, description="Succes"),
 *     @SWG\Response(response=400, description="Token ontbreekt"),
 *     @SWG\Response(response=404, description="Token onbekend")
 * )
 */
$app->post('/berichten', 'App\Controller\BerichtenController:post');
/**
 * @SWG\Get(
 *      path="/berichten/{id}",
 *      produces={"application/json"},
 *      summary="Geeft een bericht terug",
 *      @SWG\Response(response=200, description="Verwijderd een bericht"),
 *      @SWG\Parameter(description="Lijst van bericht ID's", in="query", name="id[]", required=true, type="integer")
 * )
 */
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

/**
 * @SWG\Get(
 *     path="/auth",
 *     produces={"application/json"},
 *     summary="Geeft info over token",
 *     @SWG\Parameter(description="Token", in="query", name="token", required=false, type="string"),
 *     @SWG\Response(response=200, description="Succes"),
 *     @SWG\Response(response=400, description="Token ontbreekt"),
 *     @SWG\Response(response=404, description="Token onbekend")
 * )
 */
$app->get('/auth', 'App\Controller\AuthController:token');
/**
 * @SWG\Post(
 *     path="/auth",
 *     produces={"application/json"},
 *     summary="Login",
 *     @SWG\Parameter(description="Gebruikersnaam", in="formData", name="username", required=true, type="string"),
 *     @SWG\Parameter(description="Wachtwoord", in="formData", name="password", required=true, type="string"),
 *     @SWG\Response(response=200, description="Succes"),
 *     @SWG\Response(response=401, description="Gebruikersnaam/wachtwoord ongeldig")
 * )
 */
$app->post('/auth', 'App\Controller\AuthController:login');
/**
 * @SWG\Delete(
 *      path="/auth",
 *      produces={"application/json"},
 *      summary="Logout",
 *      @SWG\Parameter(description="Token", in="query", name="token", required=true, type="string"),
 *      @SWG\Response(response=200, description="Succes")
 * )
 */
$app->delete('/auth', 'App\Controller\AuthController:logout');

/**
 * @SWG\Post(
 *      path="/accounts",
 *      produces={"application/json"},
 *      summary="Aanmaken account",
 *      @SWG\Parameter(description="Gebruikersnaam", in="formData", name="username", required=true, type="string"),
 *      @SWG\Parameter(description="Wachtwoord", in="formData", name="password", required=true, type="string"),
 *      @SWG\Parameter(description="E-mailadres", in="formData", name="mail", required=true, type="string"),
 *      @SWG\Parameter(description="Notificaties, mogelijke waardes: create_notifications", in="formData", name="create_notifications", required=false, type="string"),
 *      @SWG\Response(response=200, description="Succes"),
 *      @SWG\Response(response=401, description="Token ontbreekt"),
 *      @SWG\Response(response=406, description="Aanvraag niet volledig"),
 *      @SWG\Response(response=407, description="Wachtwoord ongeldig"),
 *      @SWG\Response(response=409, description="Gebruikersnaam al in gebruik")
 * )
 */
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

/**
 * @SWG\Get(
 *     path="/vialis",
 *     produces={"application/json"},
 *     summary="Geeft Vialis info terug",
 *     @SWG\Parameter(description="Token", in="query", name="token", required=true, type="string"),
 *     @SWG\Response(response=200, description="Succes")
 * )
 */
$app->get('/vialis', 'App\Controller\VialisController:index');
/**
 * @SWG\Post(
 *     path="/vialis",
 *     produces={"application/json"},
 *     summary="Koppel id aan parkeerplaats",
 *     @SWG\Parameter(description="Token", in="query", name="token", required=true, type="string"),
 *     @SWG\Parameter(description="Parkeerplaats code", in="formData", name="parkeerplaats", required=true, type="string"),
 *     @SWG\Parameter(description="Vialis Dynamic id", in="formData", name="id", required=true, type="string"),
 *     @SWG\Response(response=200, description="Succes"),
 *     @SWG\Response(response=401, description="id of parkeerplaats niet opgegeven"),
 *     @SWG\Response(response=406, description="Vialis id onbekend")
 * )
 */
$app->post('/vialis', 'App\Controller\VialisController:map');