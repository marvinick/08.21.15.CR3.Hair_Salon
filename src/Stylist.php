<?php

    class Stylist
    {
          private $name;
          private $id;

          function __construct($name, $id = null)
          {
                $this->name = $name;
                $this->id = $id;
          }

          function setName($new_name)
          {
                $this->name = (string) $new_name;
          }

          function getName()
          {
                return ($this->name);
          }

          function getId()
          {
              return $this->id;
          }

          function save()
          {
              $GLOBALS['DB']->exec("INSERT INTO stylists (name) VALUES ('{$this->getName()}');");
              $this->id = $GLOBALS['DB']->lastInsertId();
          }

          static function getAll()
          {
            $returned_stylists = $GLOBALS['DB']->query("SELECT * FROM stylists;");
            $stylists = array();
            foreach($returned_stylists as $stylist) {
                $name = $stylist['name'];
                $id = $stylist['id'];
                $new_stylist = new Stylist($name, $id);
                array_push($stylists, $new_stylist);
            }
            return $stylists;
          }

          static function deleteAll()
          {
              $GLOBALS['DB']->exec("DELETE FROM stylists;");
          }

          static function find($search_id)
          {
              $found_stylist = null;
              $stylists = Stylist::getAll();
              foreach($stylists as $stylist) {
                  $stylist_id = $stylist->getId();
                  if ($stylist_id == $search_id) {
                      $found_stylist = $stylist;
                  }
              }
              return $found_stylist;
          }

          function getClients()
          {
              $clients = Array();
              $returned_clients = $GLOBALS['DB']->query("SELECT * FROM clients WHERE stylist_id = {$this->getId()};");
              foreach($returned_clients as $client) {
                  $patron = $client['patron'];
                  $id = $client['id'];
                  $stylist_id = $client['stylist_id'];
                  $new_client = new Client($patron, $id, $stylist_id);
                  array_push($clients, $new_client);
              }
              return $clients;
          }

          function update($new_name)
          {
              $GLOBALS['DB']->exec("UPDATE stylists SET name = '{$new_name}' WHERE id = {$this->getId()};");
              $this->setName($new_name);
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
              $this->assertEquals([$test_stylist2], Category::getAll());
          }

          function delete()
          {
              $GLOBALS['DB']->exec("DELETE FROM stylists WHERE id = {$this->getId()};");
              $GLOBALS['DB']->exec("DELETE FROM clients WHERE stylist_id = {$this->getId()};");
          }

    }
?>