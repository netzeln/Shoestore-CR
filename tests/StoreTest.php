<?php

/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once "src/Store.php";
require_once "src/Brand.php";


$server = 'mysql:host=localhost;dbname=shoes_test';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);



class  StoreTest  extends PHPUnit_Framework_TestCase
{

    protected function tearDown()
    {
        Store::deleteAll();
    }
    function testGetName()
    {
        //arrange
        $name = "Basie's Boots";
        $id = NULL;
        $test_store = new Store($name, $id);

        //act
        $result = $test_store->getName();

        //assert
        $this->assertEquals("Basie's Boots", $result);

    }
    function testGetId()
    {
        //arrange
        $name = "Basie's Boots";
        $id = 1;
        $test_store = new Store($name, $id);

        //act
        $result = $test_store->getId();

        //assert
        $this->assertEquals(1, $result);

    }
    function testSetName()
    {
        //arrange
        $name = "Basies Boots";
        $id = NULL;
        $test_store = new Store($name, $id);

        $new_name ="Boots by Basie";

        //act
        $test_store->setName($new_name);
        $result = $test_store->getName();

        //assert
        $this->assertEquals($new_name, $result);

    }

    function testSave()
    {
        //arrange
        $name = "Basies Boots";
        $id = 1;
        $test_store = new Store($name, $id);

        //act
        $test_store->save();
        $result = Store::getAll();

        //assert
        $this->assertEquals([$test_store], $result);

    }

    function testGetAll()
    {
        //arrange
        $name = "Basies Boots";
        $id = NULL;
        $test_store = new Store($name, $id);
        $test_store->save();

        $name2 = "Ellingtons Elegant Footwear";
        $id = NULL;
        $test_store2 = new Store($name2, $id);
        $test_store2->save();

        //act
        $result = Store::getAll();

        //assert
        $this->assertEquals([$test_store, $test_store2], $result);
    }


    function testDeleteAll()
    {
        //arrange
        $name = "Basies Boots";
        $id = NULL;
        $test_store = new Store($name, $id);
        $test_store->save();

        $name2 = "Ellingtons Elegant Footwear";
        $id = NULL;
        $test_store2 = new Store($name2, $id);
        $test_store2->save();

        //act
        Store::deleteAll();
        $result = Store::getAll();

        //assert
        $this->assertEquals([], $result);
    }

    function testFind()
    {
        //arrange
        $name = "Basies Boots";
        $id = NULL;
        $test_store = new Store($name, $id);
        $test_store->save();

        $name2 = "Ellingtons Elegant Footwear";
        $id = NULL;
        $test_store2 = new Store($name2, $id);
        $test_store2->save();

        //act
        $result = Store::Find($test_store2->getId());

        //assert
        $this->assertEquals($test_store2, $result);
    }

    function testUpdateStore()
    {

        //arrange
        $name = "Basies Boots";
        $id = NULL;
        $test_store = new Store($name, $id);
        $test_store->save();

        $new_name = "Boots by Basie";
        //act
        $test_store->update($new_name);
        $result = Store::find($test_store->getId());
        //assert
        $this->assertEquals($new_name, $result->getName());

    }
    function testDeleteStore()
    {
        //arrange
        $name = "Basies Boots";
        $id = NULL;
        $test_store = new Store($name, $id);
        $test_store->save();

        $name2 = "Ellingtons Elegant Footwear";
        $id = NULL;
        $test_store2 = new Store($name2, $id);
        $test_store2->save();

        //act
        $test_store->delete();
        $result = Store::getAll();

        //assert
        $this->assertEquals([$test_store2], $result);
    }

    function testAddBrand()
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
        $test_store->addBrand($test_brand->getId());
        $result = $test_store->brands();

        //assert
        $this->assertEquals([$test_brand], $result);
    }
    function testBrands()
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

        $test_store->addBrand($test_brand->getId());

        $brand_name2 = "Straight Ahead Shoes";
        $id3 = NULL;
        $test_brand2 = new Brand($brand_name2, $id3);
        $test_brand2->save();

        $test_store->addBrand($test_brand2->getId());

        //act
        $result = $test_store->brands();


        //assert
        $this->assertEquals([$test_brand, $test_brand2], $result);
    }
}
 ?>
