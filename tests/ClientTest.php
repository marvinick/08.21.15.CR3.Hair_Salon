<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Client.php";

    $server = 'mysql:host=localhost;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


    class ClientTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Client::deleteAll();
            Stylist::deleteAll();
        }

        function test_getId()
        {
            //Arrange
            $name = "Donald";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $patron = "Rosie";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($patron, $id, $stylist_id);
            $test_client->save();

            //Act
            $result = $test_client->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_getStylistId()
        {
            //Arrange
            $name = "Donald";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $patron = "Rosie";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($patron, $id, $stylist_id);
            $test_client->save();


            //Act
            $result = $test_client->getStylistId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
        {
            //Arrange
            $name = "Donald";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $patron = "Rosie";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($patron, $id, $stylist_id);

            //Act
            $test_client->save();

            //Assert
            $result = Client::getAll();
            $this->assertEquals($test_client, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Donald";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $patron = "Rosie";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($patron, $id, $stylist_id);
            $test_client->save();

            $patron2 = "Donald";
            $test_client2 = new Client($patron2, $id, $stylist_id);
            $test_client2->save();

            //Act
            $result = Client::getAll();

            //Assert
            $this->assertEquals([$test_client, $test_client2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "Donald";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $patron = "Rosie";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($patron, $id, $stylist_id);
            $test_client->save();

            $patron2 = "Donald";
            $test_client2 = new Client($patron2, $id, $stylist_id );
            $test_client2->save();

            //Act
            Stylist::deleteAll();

            //Assert
            $result = Stylist::getAll();
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $name = "Donald";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $patron = "Rosie";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($patron, $id, $stylist_id);
            $test_client->save();

            $patron2 = "Donald";
            $test_client2 = new Client($patron2, $id, $stylist_id);
            $test_client2->save();

            //Act
            $result = Client::find($test_client->getId());

            //Assert
            $this->assertEquals($test_client, $result);
        }
    }
?>
