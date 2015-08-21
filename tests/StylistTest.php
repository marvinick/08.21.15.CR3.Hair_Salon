<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Stylist.php";

    $server = 'mysql:host=localhost;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


    class StylistTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Stylist::deleteAll();
            Client::deleteAll();
        }

        function test_save()
        {
            //Arrange
            $name = "Rosie";
            $test_stylist = new Stylist($name, $id);

            //Act
            $test_stylist->save();

            //Assert
            $result = Stylist::getAll();
            $this->assertEquals($test_stylist, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Rosie";
            $name2 = "Donald";
            $test_stylist = new Stylist($name);
            $test_stylist->save();
            $test_stylist2 = new Stylist($name2);
            $test_stylist2->save();

            //Act
            $result = Stylist::getAll();

            //Assert
            $this->assertEquals([$test_stylist, $test_stylist2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "Rosie";
            $name2 = "Donald";
            $test_stylist = new Stylist($name);
            $test_stylist->save();
            $test_stylist2 = new Stylist($name2);
            $test_stylist2->save();

            //Act
            Stylist::deleteAll();

            //Assert
            $result = Stylist::getAll();
            $this->assertEquals([], $result);
        }

        function test_getId()
        {
            //Arrange
            $name = "Rosie";
            $id = 1;
            $test_stylist = new Stylist($name, $id);

            //Act
            $result = $test_stylist->getId();

            //Assert
            $this->assertEquals(1, $result);
        }

        function test_find()
        {
            //Arrange
            $name = "Rosie";
            $name2 = "Donald";
            $test_stylist = new Stylist($name);
            $test_stylist->save();
            $test_stylist2 = new Stylist($name2);
            $test_stylist2->save();

            //Act
            $id = $test_stylist->getId();
            $result = Stylist::find($id);

            //Assert
            $this->assertEquals($test_stylist, $result);
        }

        function testGetClients()
          {
              //Arrange
              $name = "Rosie";
              $id = null;
              $test_stylist = new Stylist($name, $id);
              $test_stylist->save();

              $test_stylist_id = $test_stylist->getId();

              $patron = "Donald";
              $test_client = new Client($patron, $id, $test_stylist_id);
              $test_client->save();

              $patron2 = "MissUSA";
              $test_client2 = new Client($patron2, $id, $test_stylist_id);
              $test_client2->save();

              //Act
              $result = $test_stylist->getClients();

              //Assert
              $this->assertEquals([$test_client, $test_client2], $result);
          }

          function testUpdate()
          {
              //Arrange
              $name = "Rosie";
              $id = null;
              $test_stylist = new Stylist($name, $id);
              $test_stylist->save();

              $new_name = "Donald";

              //Act
              $test_stylist->update($new_name);

              //Assert
              $this->assertEquals("Donald", $test_stylist->getName());
          }

          function testDelete()
          {
              //Arrange
              $name = "Donald";
              $id = null;
              $test_stylist = new Stylist($name, $id);
              $test_stylist->save();

              $name2 = "Rosie";
              $test_stylist2 = new Stylist($name2, $id);
              $test_stylist2->save();


              //Act
              $test_stylist->delete();

              //Assert
              $this->assertEquals([$test_stylist2], Stylist::getAll());
          }
    }
?>