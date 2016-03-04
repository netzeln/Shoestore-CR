<?php


/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once "src/Store.php";

//if using database
$server = 'mysql:host=localhost;dbname=shoes';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);



class  StoreTest  extends PHPUnit_Framework_TestCase{

    function testGetName()
    {
        //arrange
        $name = "Basie's Boots";
        $id = 0;
        $test_store = new Store ($name, $id);

        //act
        $result = $test_store->getName();

        //assert
        $this->assertEquals($name, $result);
    }
    function testGetId()
    {
        //arrange
        $name = "Basie's Boots";
        $id = 1;
        $test_store = new Store ($name, $id);

        //act
        $result = $test_store->getId();

        //assert
        $this->assertEquals($id, $result);
    }


}
 ?>
