<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Stylist.php";

    $server = 'mysql:host=localhost;dbname=food_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StylistTest extends PHPUnit_Framework_TestCase
        {
              protected function tearDown()
              {
                    Stylist::deleteAll();
              }
        }

              function test_save()
              {
                    //arrange
                    $name = "rosie";
                    $test_Stylist = new Stylist($name);

                    //act
                    $test_stylist->save();
              }

?>