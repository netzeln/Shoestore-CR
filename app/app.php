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
      use Symfony\Component\HttpFoundation\Request;
      Request::enableHttpMethodParameterOverride();

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

    $app->patch("/update_store/{id}", function($id) use ($app){
        $store = Store::find($id);
        $store->update($_POST['store_name']);

        $brands = $store->brands();
        $all_stores = Store::getAll();
        $all_brands = Brand::getAll();
        return $app['twig']->render("store.html.twig", array('all_stores'=> $all_stores, 'all_brands'=>$all_brands, "store"=>$store, 'brands'=>$brands));

    });
    $app->post("/new_brand", function() use ($app){
        $new_brand = new Brand ($_POST['brand_name']);
        $new_brand->save();

        $all_stores = Store::getAll();
        $all_brands = Brand::getAll();
        return $app['twig']->render("index.html.twig", array('all_stores'=> $all_stores, 'all_brands'=>$all_brands));

    });

    $app->get("/store/{id}", function($id) use ($app){

        $store = Store::find($id);
        $brands = $store->brands();

        $all_stores = Store::getAll();
        $all_brands = Brand::getAll();
        return $app['twig']->render("store.html.twig", array('all_stores'=> $all_stores, 'all_brands'=>$all_brands, "store"=>$store, 'brands'=>$brands));

    });

    $app->get("/brand/{id}", function($id) use ($app){

        $brand = Brand::find($id);
        $stores = $brand->stores();

        $all_stores = Store::getAll();
        $all_brands = Brand::getAll();
        return $app['twig']->render("brand.html.twig", array('all_stores'=> $all_stores, 'all_brands'=>$all_brands, "stores"=>$stores, 'brand'=>$brand));

    });

    $app->post("/store_carry_brand/{id}", function($id) use ($app){
        $store = Store::find($id);
        $brand_id = $_POST['exist_brand'];
        $store->addBrand($brand_id);

        $brands = $store->brands();

        $all_stores = Store::getAll();
        $all_brands = Brand::getAll();
        return $app['twig']->render("store.html.twig", array('all_stores'=> $all_stores, 'all_brands'=>$all_brands, "store"=>$store, 'brands'=>$brands));
    });

    $app->post("/brand_in_store/{id}", function($id) use ($app){
        $brand = Brand::find($id);
        $store_id = $_POST['exist_store'];
        $brand->addStore($store_id);

        $stores = $brand->stores();

        $all_stores = Store::getAll();
        $all_brands = Brand::getAll();
        return $app['twig']->render("brand.html.twig", array('all_stores'=> $all_stores, 'all_brands'=>$all_brands, "stores"=>$stores, 'brand'=>$brand));
    });

    $app->patch("/update_brand/{id}", function($id) use ($app){
        $brand = Brand::find($id);
        $brand->update($_POST['brand_name']);

        $stores = $brand->stores();
        $all_stores = Store::getAll();
        $all_brands = Brand::getAll();
        return $app['twig']->render("brand.html.twig", array('all_stores'=> $all_stores, 'all_brands'=>$all_brands, "stores"=>$stores, 'brand'=>$brand));
    });



    return $app;
 ?>
