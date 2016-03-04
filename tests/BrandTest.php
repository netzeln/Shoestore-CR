<?php

/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once "src/Brand.php";


$server = 'mysql:host=localhost;dbname=shoes_test';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);



class  BrandTest  extends PHPUnit_Framework_TestCase
{

    protected function tearDown()
    {
        Brand::deleteAll();
    }
    function testGetName()
    {
        //arrange
        $name = "Straight Ahead Shoes";
        $id = NULL;
        $test_brand = new Brand($name, $id);

        //act
        $result = $test_brand->getName();

        //assert
        $this->assertEquals("Straight Ahead Shoes", $result);

    }
    function testGetId()
    {
        //arrange
        $name = "Straight Ahead Shoes";
        $id = 1;
        $test_brand = new Brand($name, $id);

        //act
        $result = $test_brand->getId();

        //assert
        $this->assertEquals(1, $result);

    }
    function testSetName()
    {
        //arrange
        $name = "Straight Ahead Shoes";
        $id = NULL;
        $test_brand = new Brand($name, $id);

        $new_name ="Boots by Basie";

        //act
        $test_brand->setName($new_name);
        $result = $test_brand->getName();

        //assert
        $this->assertEquals($new_name, $result);

    }

    function testSave()
    {
        //arrange
        $name = "Straight Ahead Shoes";
        $id = 1;
        $test_brand = new Brand($name, $id);

        //act
        $test_brand->save();
        $result = Brand::getAll();

        //assert
        $this->assertEquals([$test_brand], $result);

    }

    function testGetAll()
    {
        //arrange
        $name = "Straight Ahead Shoes";
        $id = NULL;
        $test_brand = new Brand($name, $id);
        $test_brand->save();

        $name2 = "Caravan Shoes";
        $id = NULL;
        $test_brand2 = new Brand($name2, $id);
        $test_brand2->save();

        //act
        $result = Brand::getAll();

        //assert
        $this->assertEquals([$test_brand, $test_brand2], $result);
    }


    function testDeleteAll()
    {
        //arrange
        $name = "Straight Ahead Shoes";
        $id = NULL;
        $test_brand = new Brand($name, $id);
        $test_brand->save();

        $name2 = "Caravan Shoes";
        $id = NULL;
        $test_brand2 = new Brand($name2, $id);
        $test_brand2->save();

        //act
        Brand::deleteAll();
        $result = Brand::getAll();

        //assert
        $this->assertEquals([], $result);
    }

    function testFind()
    {
        //arrange
        $name = "Straight Ahead Shoes";
        $id = NULL;
        $test_brand = new Brand($name, $id);
        $test_brand->save();

        $name2 = "Caravan Shoes";
        $id = NULL;
        $test_brand2 = new Brand($name2, $id);
        $test_brand2->save();

        //act
        $result = Brand::Find($test_brand2->getId());

        //assert
        $this->assertEquals($test_brand2, $result);
    }

    function testUpdateBrand()
    {

        //arrange
        $name = "Straight Ahead Shoes";
        $id = NULL;
        $test_brand = new Brand($name, $id);
        $test_brand->save();

        $new_name = "Boots by Basie";
        //act
        $test_brand->update($new_name);
        $result = Brand::find($test_brand->getId());
        //assert
        $this->assertEquals($new_name, $result->getName());

    }
    function testDeleteBrand()
    {
        //arrange
        $name = "Straight Ahead Shoes";
        $id = NULL;
        $test_brand = new Brand($name, $id);
        $test_brand->save();

        $name2 = "Caravan Shoes";
        $id = NULL;
        $test_brand2 = new Brand($name2, $id);
        $test_brand2->save();

        //act
        $test_brand->delete();
        $result = Brand::getAll();
        //assert
        $this->assertEquals([$test_brand2], $result);
    }
    function testAddStore()
    {
        //arrange
        $name = "Basies Boots";
        $id = NULL;
        $test_store = new Store($name, $id);
        $test_store->save();

        $brand_name = "Straight Ahead Shoes";
        $id2 = NULL;
        $test_brand = new Brand($brand_name, $id2);
        $test_brand->save();

        //act
        $test_brand->addStore($test_store->getId());
        $result = $test_brand->stores();

        //assert
        $this->assertEquals([$test_store], $result);
    }
    function testStores()
    {
        //arrange
        $brand_name = "Straight Ahead Shoes";
        $id2 = NULL;
        $test_brand = new Brand($brand_name, $id2);
        $test_brand->save();

        $store_name = "Basies Boots";
        $id = NULL;
        $test_store = new Store($store_name, $id);
        $test_store->save();

        $test_brand->addStore($test_store->getId());

        $store_name2 = "Ellington Elegant Shoe Store";
        $id3 = NULL;
        $test_store2 = new Store($store_name2, $id3);
        $test_store2->save();

        $test_brand->addStore($test_store2->getId());

        //act
        $result = $test_brand->stores();


        //assert
        $this->assertEquals([$test_store, $test_store2], $result);
    }
}
 ?>
