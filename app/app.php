<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Stylist.php";
    require_once __DIR__."/../src/Client.php";

    $app = new Silex\Application();

    $server = 'mysql:host=localhost;dbname=hair_salon';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
      'twig.path' => array (
           __DIR__.'/../views'
      )
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

    $app->post("/stylists", function() use ($app) {
        $stylist = new Stylist($_POST['name']);
        $stylist->save();
        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

    $app->get("/stylists/{id}", function($id) use ($app) {
        $stylist = Stylist::find($id);
        return $app['twig']->render('stylist.html.twig', array('stylist' => $stylist, 'clients' => $stylist->getClients()));
    });

    $app->post("/clients", function() use ($app) {
        $patron = $_POST['patron'];
        $stylist_id = $_POST['stylist_id'];
        $client = new Client($patron, $id = null, $stylist_id);
        $client->save();
        $stylist = Stylist::find($stylist_id);
        return $app['twig']->render('stylist.html.twig', array('stylist' => $stylist, 'clients' => $stylist->getClients()));
    });

    $app->get("/clients", function() use ($app) {
        return $app['twig']->render('stylist.html.twig', array('clients' => Client::getAll()));
    });

    $app->post("/stylists", function() use ($app) {
        $stylist = new Stylist($_POST['name']);
        $stylist>save();
        return $app['twig']->render('index.html.twig', array('tasks' => Stylist::getAll()));
    });

    $app->post("/delete_stylist", function() use ($app) {
        Stylist::deleteAll();
        return $app['twig']->render('index.html.twig');
    });

    $app->post("/clients", function() use ($app) {
        $category = new Category($_POST['name']);
        $category->save();
        return $app['twig']->render('stylist.html.twig', array('clients' => Clients::getAll()));
    });

    $app->post("/delete_clients", function() use ($app) {
        Client::deleteAll();
        return $app['twig']->render('stylist.html.twig');
    });



    return $app;

?>



