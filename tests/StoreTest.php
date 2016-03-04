<?php

/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once "src/Store.php";


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
        $id = 1;
        $test_store = new Store($name, $id);
        $test_store->save();

        //act
        $result = Store::getAll();
var_dump($result);
        //assert
        $this->assertEquals([$test_store], $result);
    }
}
 ?>
