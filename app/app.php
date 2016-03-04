<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Store.php";
    require_once __DIR__."/../src/Brand.php";



    $app = new Silex\Application();

    $server = 'mysql:host=localhost;dbname=shoes';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    // $all_stores = Store::getAll();
    // $all_brands = Brand::getAll();

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path'=>__DIR__."/../views"
    ));

    $app->get("/", function() use ($app){
        $all_stores = Store::getAll();
        $all_brands = Brand::getAll();
      return $app['twig']->render("index.html.twig", array('all_stores'=> $all_stores, 'all_brands'=>$all_brands));
    });

    $app->post("/new_store", function() use ($app){
        $new_store = new Store ($_POST['store_name']);

        $new_store->save();

        $all_stores = Store::getAll();
        $all_brands = Brand::getAll();
        return $app['twig']->render("index.html.twig", array('all_stores'=> $all_stores, 'all_brands'=>$all_brands));

    });

    $app->post("/new_brand", function() use ($app){
        $new_brand = new Brand ($_POST['brand_name']);
        $new_brand->save();
        
        $all_stores = Store::getAll();
        $all_brands = Brand::getAll();
        return $app['twig']->render("index.html.twig", array('all_stores'=> $all_stores, 'all_brands'=>$all_brands));

    });


    return $app;
 ?>
