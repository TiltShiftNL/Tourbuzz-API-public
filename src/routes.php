<?php
// CORS
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});
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
 * @SWG\Post(
 *     path="/berichten",
 *     produces={"application/json"},
 *     summary="Bericht aanmaken of bijwerken",
 *     @SWG\Parameter(description="Token", in="query", name="token", required=true, type="string"),
 *     @SWG\Parameter(description="Bericht ID", in="formData", name="id", required=true, type="integer"),
 *     @SWG\Parameter(description="Sms tekst Engels", in="formData", name="sms_end", required=true, type="string"),
 *     @SWG\Parameter(description="Sms tekst Duits", in="formData", name="sms_de", required=true, type="string"),
 *     @SWG\Parameter(description="Sms tekst Nederlands", in="formData", name="sms_nl", required=true, type="string"),
 *     @SWG\Parameter(description="Titel", in="formData", name="title", required=true, type="string"),
 *     @SWG\Parameter(description="Bericht", in="formData", name="body", required=true, type="string"),
 *     @SWG\Parameter(description="Advies", in="formData", name="advice", required=true, type="string"),
 *     @SWG\Parameter(description="Titel (Engels)", in="formData", name="title_en", required=true, type="string"),
 *     @SWG\Parameter(description="Bericht (Engels)", in="formData", name="body_en", required=true, type="string"),
 *     @SWG\Parameter(description="Advies (Engels)", in="formData", name="advice_en", required=true, type="string"),
 *     @SWG\Parameter(description="Titel (Duits)", in="formData", name="title_de", required=true, type="string"),
 *     @SWG\Parameter(description="Bericht (Duits)", in="formData", name="body_de", required=true, type="string"),
 *     @SWG\Parameter(description="Advies (Duits)", in="formData", name="advice_de", required=true, type="string"),
 *     @SWG\Parameter(description="Titel (Spaans)", in="formData", name="title_es", required=true, type="string"),
 *     @SWG\Parameter(description="Bericht (Spaans)", in="formData", name="body_es", required=true, type="string"),
 *     @SWG\Parameter(description="Advies (Spaans)", in="formData", name="advice_es", required=true, type="string"),
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
 *     @SWG\Response(response=401, description="Token ontbreekt"),
 *     @SWG\Response(response=404, description="Token onbekend")
 * )
 */
$app->post('/berichten', 'App\Controller\BerichtenController:post');
/**
 * @SWG\Delete(
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

/**
 * @SWG\Get(
 *     path="/afbeeldingen/{id}",
 *     produces={"application/json"},
 *     summary="Geeft een thumbnail",
 *     @SWG\Parameter(description="ID", in="path", name="id", required=false, type="string"),
 *     @SWG\Parameter(description="Voeg greyscale=1 toe om de afbeeling in grijswaarde om te zetten", in="query", name="greyscale", required=false, type="boolean"),
 *     @SWG\Parameter(description="Opties: fit (binnen kader) | resize (tot kader) | (indien niet opgegeven geen resize)", in="query", name="method", required=false, type="string"),
 *     @SWG\Parameter(description="Verplicht indien method=fit|resize", in="query", name="width", required=false, type="integer"),
 *     @SWG\Parameter(description="Verplicht indien method=fit|resize", in="query", name="height", required=false, type="integer"),
 *     @SWG\Response(response=200, description="Succes"),
 *     @SWG\Response(response=404, description="Afbeelding onbekend")
 * )
 */
$app->get('/afbeeldingen/{id}/', 'App\Controller\AfbeeldingController:transform');
$app->get('/afbeeldingen/{id}', 'App\Controller\AfbeeldingController:transform');

/**
 * @SWG\Post(
 *     path="/afbeeldingen",
 *     produces={"application/json"},
 *     summary="Upload afbeelding",
 *     @SWG\Parameter(description="Bestand", in="formData", name="file", required=true, type="file"),
 *     @SWG\Parameter(description="Token", in="query", name="token", required=false, type="string"),
 *     @SWG\Response(response=200, description="Succes"),
 *     @SWG\Response(response=400, description="File ontbreekt"),
 *     @SWG\Response(response=401, description="Token ontbreekt"),
 *     @SWG\Response(response=404, description="Token onbekend")
 * )
 */
$app->post('/afbeeldingen', 'App\Controller\AfbeeldingController:post');

/**
 * @SWG\Get(
 *     path="/poi",
 *     produces={"application/x-download"},
 *     summary="Geeft CSV met halte en parkeerplaatsen info",
 *     @SWG\Response(response=200, description="Succes"),
 * )
 */
$app->get('/poi', 'App\Controller\PoiController:index');

/**
 * @SWG\Get(
 *     path="/distance",
 *     produces={"application/json"},
 *     summary="Geeft CSV met halte en parkeerplaatsen info",
 *     @SWG\Parameter(description="Punt 1, lat", in="query", name="lat1", required=false, type="number"),
 *     @SWG\Parameter(description="Punt 1, lng", in="query", name="lng1", required=false, type="number"),
 *     @SWG\Parameter(description="Punt 2, lat", in="query", name="lat2", required=false, type="number"),
 *     @SWG\Parameter(description="Punt 2, lng", in="query", name="lng2", required=false, type="number"),
 *     @SWG\Response(response=200, description="Succes"),
 * )
 */
$app->get('/distance', 'App\Controller\DistanceController:distance');

/**
 * @SWG\Get(
 *     path="/auth",
 *     produces={"application/json"},
 *     summary="Geeft info over token",
 *     @SWG\Parameter(description="Token", in="query", name="token", required=false, type="string"),
 *     @SWG\Response(response=200, description="Succes"),
 *     @SWG\Response(response=401, description="Token ontbreekt"),
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
/**
 * @SWG\Get(
 *     path="/accounts",
 *     produces={"application/json"},
 *     summary="Geeft lijst met accounts",
 *     @SWG\Parameter(description="Token", in="query", name="token", required=false, type="string"),
 *     @SWG\Response(response=200, description="Succes"),
 *     @SWG\Response(response=401, description="Token ontbreekt"),
 *     @SWG\Response(response=404, description="Token onbekend")
 * )
 */
$app->get('/accounts', 'App\Controller\AccountController:index');
/**
 * @SWG\Get(
 *     path="/accounts/{username}",
 *     produces={"application/json"},
 *     summary="Geeft gebruikers informatie",
 *     @SWG\Parameter(description="Token", in="query", name="token", required=false, type="string"),
 *     @SWG\Parameter(description="Gebruikersnaam", in="path", name="username", required=false, type="string"),
 *     @SWG\Response(response=200, description="Succes"),
 *     @SWG\Response(response=401, description="Token ontbreekt"),
 *     @SWG\Response(response=404, description="Token onbekend of gebruiker onbekend"),
 * )
 */
$app->get('/accounts/{username}', 'App\Controller\AccountController:single');
/**
 * @SWG\Put(
 *      path="/accounts",
 *      produces={"application/json"},
 *      summary="Bijwerken account (email, wachtwoord of notificaties)",
 *      @SWG\Parameter(description="Gebruikersnaam", in="formData", name="username", required=true, type="string"),
 *      @SWG\Parameter(description="Wachtwoord", in="formData", name="password", required=false, type="string"),
 *      @SWG\Parameter(description="E-mailadres", in="formData", name="mail", required=true, type="string"),
 *      @SWG\Parameter(description="Notificaties, mogelijke waardes: create_notifications", in="formData", name="create_notifications", required=false, type="string"),
 *      @SWG\Parameter(description="Token", in="query", name="token", required=false, type="string"),
 *      @SWG\Response(response=200, description="Succes"),
 *      @SWG\Response(response=401, description="Token ontbreekt"),
 *      @SWG\Response(response=406, description="Aanvraag niet volledig"),
 *      @SWG\Response(response=407, description="Wachtwoord ongeldig"),
 *      @SWG\Response(response=409, description="Gebruikersnaam onbekend")
 * )
 */
$app->put('/accounts', 'App\Controller\AccountController:update');
/**
 * @SWG\Delete(
 *      path="/accounts/{username}",
 *      produces={"application/json"},
 *      summary="Account verwijderen",
 *      @SWG\Parameter(description="Gebruikersnaam", in="path", name="username", required=true, type="string"),
 *      @SWG\Parameter(description="Token", in="query", name="token", required=false, type="string"),
 *      @SWG\Response(response=200, description="Succes"),
 *      @SWG\Response(response=401, description="Token ontbreekt"),
 *      @SWG\Response(response=409, description="Gebruikersnaam onbekend")
 * )
 */
$app->delete('/accounts/{username}', 'App\Controller\AccountController:delete');

/**
 * @SWG\Post(
 *      path="/vergeten",
 *      produces={"application/json"},
 *      summary="Wachtwoord vergeten mail sturen",
 *      @SWG\Parameter(description="Gebruikersnaam", in="formData", name="username", required=true, type="string"),
 *      @SWG\Response(response=200, description="Succes"),
 * )
 */
$app->post('/vergeten', 'App\Controller\VergetenController:vergeten');
/**
 * @SWG\Get(
 *      path="/vergeten/{token}",
 *      produces={"application/json"},
 *      summary="Wachtwoord vergeten mail sturen",
 *      @SWG\Parameter(description="Wachtwoord vergeten token", in="path", name="token", required=true, type="string"),
 *      @SWG\Response(response=200, description="Succes"),
 *      @SWG\Response(response=404, description="Wachtwoord vergeten token onbekend"),
 * )
 */
$app->get('/vergeten/{token}', 'App\Controller\VergetenController:checkToken');
/**
 * @SWG\Put(
 *      path="/vergeten",
 *      produces={"application/json"},
 *      summary="Wachtwoord vergeten mail sturen",
 *      @SWG\Parameter(description="Wachtwoord vergeten token", in="path", name="token", required=true, type="string"),
 *      @SWG\Parameter(description="Nieuw wachtwoord", in="formData", name="password", required=true, type="string"),
 *      @SWG\Response(response=200, description="Succes"),
 *      @SWG\Response(response=403, description="Wachtwoord vergeten token klopt niet"),
 *      @SWG\Response(response=405, description="Wachtwoord voldoet niet aan minimale lengte"),
 * )
 */
$app->put('/vergeten', 'App\Controller\VergetenController:changePasswordByToken');

/**
 * @SWG\Post(
 *      path="/mail",
 *      produces={"application/json"},
 *      summary="Aanmelden nieuwsbrief",
 *      @SWG\Parameter(description="E-mailadres", in="formData", name="mail", required=true, type="string"),
 *      @SWG\Parameter(description="Taal", in="formData", name="language", required=true, type="string"),
 *      @SWG\Parameter(description="Naam", in="formData", name="name", required=false, type="string"),
 *      @SWG\Parameter(description="Organisatie", in="formData", name="organization", required=false, type="string"),
 *      @SWG\Response(response=200, description="Succes"),
 *      @SWG\Response(response=405, description="E-mailadres of taal niet opgegeven"),
 *      @SWG\Response(response=406, description="E-mailadres bestaat al"),
 * )
 */
$app->post('/mail', 'App\Controller\MailController:register');
/**
 * @SWG\Get(
 *      path="/mail/{token}",
 *      produces={"application/json"},
 *      summary="Controleren aanmeld token",
 *      @SWG\Parameter(description="Aanmeld token", in="path", name="token", required=true, type="string"),
 *      @SWG\Response(response=200, description="Succes"),
 *      @SWG\Response(response=404, description="Aanmeld token onbekend"),
 * )
 */
$app->get('/mail/{token}', 'App\Controller\MailController:confirm');
/**
 * @SWG\Post(
 *      path="/mail/unsubscribe",
 *      produces={"application/json"},
 *      summary="Afmelden nieuwsbrief",
 *      @SWG\Parameter(description="E-mailadres", in="formData", name="mail", required=true, type="string"),
 *      @SWG\Response(response=200, description="Succes"),
 *      @SWG\Response(response=405, description="E-mailadres niet opgegeven"),
 *      @SWG\Response(response=406, description="E-mailadres bestaat niet"),
 * )
 */
$app->post('/mail/unsubscribe', 'App\Controller\MailController:unsubscribe');
/**
 * @SWG\Get(
 *      path="/mail/unsubscribe/{token}",
 *      produces={"application/json"},
 *      summary="Controleren afmeld token",
 *      @SWG\Parameter(description="Afmeld token", in="path", name="token", required=true, type="string"),
 *      @SWG\Response(response=200, description="Succes"),
 *      @SWG\Response(response=404, description="Afmeld token onbekend"),
 * )
 */
$app->get('/mail/unsubscribe/{token}', 'App\Controller\MailController:unsubscribeConfirm');
/**
 * @SWG\Get(
 *     path="/mail",
 *     produces={"application/json"},
 *     summary="Geeft lijst met adressen",
 *     @SWG\Parameter(description="Token", in="query", name="token", required=false, type="string"),
 *     @SWG\Response(response=200, description="Succes"),
 *     @SWG\Response(response=401, description="Token ontbreekt"),
 *     @SWG\Response(response=404, description="Token onbekend")
 * )
 */
$app->get('/mail', 'App\Controller\MailController:index');

/**
 * @SWG\Post(
 *      path="/telefoon",
 *      produces={"application/json"},
 *      summary="Aanmelden SMS updates",
 *      @SWG\Parameter(description="Telefoonnummer", in="formData", name="number", required=true, type="string"),
 *      @SWG\Parameter(description="Taal", in="formData", name="language", required=true, type="string"),
 *      @SWG\Response(response=200, description="Succes"),
 *      @SWG\Response(response=405, description="Telefoonnummer of taal niet opgegeven"),
 *      @SWG\Response(response=406, description="Telefoonnummer bestaat al"),
 * )
 */
$app->post('/telefoon', 'App\Controller\TelefoonController:register');
/**
 * @SWG\Delete(
 *      path="/telefoon",
 *      produces={"application/json"},
 *      summary="Afmelden SMS updates",
 *      @SWG\Parameter(description="Telefoonnummer", in="formData", name="number", required=true, type="string"),
 *      @SWG\Parameter(description="Taal", in="formData", name="language", required=true, type="string"),
 *      @SWG\Response(response=200, description="Succes"),
 *      @SWG\Response(response=405, description="Telefoonnummer of taal niet opgegeven"),
 *      @SWG\Response(response=406, description="Telefoonnummer bestaat al"),
 * )
 */
$app->delete('/telefoon', 'App\Controller\TelefoonController:unsubscribe');
/**
 * @SWG\Get(
 *     path="/telefoon",
 *     produces={"application/json"},
 *     summary="Geeft lijst met telefoonnummers",
 *     @SWG\Parameter(description="Token", in="query", name="token", required=false, type="string"),
 *     @SWG\Response(response=200, description="Succes"),
 *     @SWG\Response(response=401, description="Token ontbreekt"),
 *     @SWG\Response(response=404, description="Token onbekend")
 * )
 */
$app->get('/telefoon', 'App\Controller\TelefoonController:index');

/**
 * @SWG\Post(
 *     path="/telefoon",
 *     produces={"application/json"},
 *     summary="Vertaald een tekst in het Nederlands met Google Translate naar een andere taal",
 *     @SWG\Parameter(description="Token", in="query", name="token", required=true, type="string"),
 *     @SWG\Parameter(description="Doel taal (en|es|de|fr)", in="formData", name="lang", required=true, type="string"),
 *     @SWG\Parameter(description="Tekst", in="formData", name="string", required=true, type="string"),
 *     @SWG\Response(response=200, description="Succes"),
 *     @SWG\Response(response=401, description="Token ontbreekt"),
 *     @SWG\Response(response=404, description="Token onbekend")
 * )
 */
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

/**
 * @SWG\Get(
 *     path="/routes/{type}",
 *     produces={"application/json"},
 *     summary="Maak een lijst van alle beschikbare routes voor het opgegeven type",
 *     @SWG\Parameter(description="Type route: recommended|mandatory|roadwork", in="path", name="type", required=true, type="string"),
 *     @SWG\Response(response=200, description="Succes"),
 *     @SWG\Response(response=404, description="Type onbekend")
 * )
 */
$app->get('/routes/{type}', 'App\Controller\RouteController:index');
/**
 * @SWG\Get(
 *     path="/routes/{type}/geojson",
 *     produces={"application/json"},
 *     summary="Maak een lijst van alle beschikbare routes in een GeoJSON feature collection",
 *     @SWG\Parameter(description="Type route: recommended|mandatory|roadwork", in="path", name="type", required=true, type="string"),
 *     @SWG\Response(response=200, description="Succes"),
 *     @SWG\Response(response=404, description="Type onbekend")
 * )
 */
$app->get('/routes/{type}/geojson', 'App\Controller\RouteController:indexGeoJson');
/**
 * @SWG\Get(
 *     path="/routes/{type}/{key}",
 *     produces={"application/json"},
 *     summary="Geeft de route als GeoJSON",
 *     @SWG\Parameter(description="Type route: recommended|mandatory|roadwork", in="path", name="type", required=true, type="string"),
 *     @SWG\Parameter(description="Key van de route zoals verkregen met /routes/{type}", in="path", name="key", required=true, type="string"),
 *     @SWG\Response(response=200, description="Succes"),
 *     @SWG\Response(response=404, description="Type of key onbekend")
 * )
 */
$app->get('/routes/{type}/{key}', 'App\Controller\RouteController:detail');