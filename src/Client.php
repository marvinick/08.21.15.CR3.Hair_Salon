<?php

    class Client
    {
          private $patron;
          private $stylist_id;
          private $id;


          function __construct($patron, $id = null, $stylist_id)
          {
                $this->patron = $patron;
                $this->id = $id;
                $this->stylist_id = $stylist_id;
          }

          function setPatron($new_patron)
          {
                $this->patron = (string) $new_patron;
          }

          function getPatron()
          {
                return ($this->patron);
          }

          function setId($new_id)
          {
              $this->id = $new_id;
          }


          function getId()
          {
              return $this->id;
          }

          function setStylistId($new_stylist_id)
          {
              $this->stylist_id = $new_stylist_id;
          }

          function getStylistId()
          {
              return $this->stylist_id;
          }

          function save()
          {
              $GLOBALS['DB']->exec("INSERT INTO clients (patron, stylist_id) VALUES ('{$this->getPatron()}', {$this->getStylistId()})");
              $result_id = $GLOBALS['DB']->lastInsertId();
              $this->setId($result_id);

          }

          static function getAll()
          {
            $returned_clients = $GLOBALS['DB']->query("SELECT * FROM clients;");
            $clients = array();
            foreach($returned_clients as $client) {
                $patron = $client['patron'];
                $id = $client['id'];
                $stylist_id = $client['stylist_id'];
                $new_client = new Client($patron, $id, $stylist_id);
                array_push($clients, $new_client);
            }
            return $clients;
          }

          static function deleteAll()
          {
              $GLOBALS['DB']->exec("DELETE FROM clients;");
          }

          static function find($search_id)
          {
              $found_client = null;
              $clients = Client::getAll();
              foreach($clients as $client) {
                  $client_id = $client->getId();
                  if ($client_id == $search_id) {
                      $found_client = $client;
                  }
              }
              return $found_client;
          }

          function update($new_patron)
          {
              $GLOBALS['DB']->exec("UPDATE clients SET patron = '{$new_patron}' WHERE id = {$this->getId()};");
              $this->setPatron($new_patron);
          }

          function delete()
          {
              $GLOBALS['DB']->exec("DELETE FROM clients WHERE id = {$this->getId()};");
              $GLOBALS['DB']->exec("DELETE FROM clients WHERE stylist_id = {$this->getId()};");
          }


    }
?>