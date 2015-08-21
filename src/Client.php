<?php

    class Client
    {
          private $patron;
          private $id;

          function __construct($patron, $id = null)
          {
                $this->patron = $patron;
                $this->id = $id;
          }

          function setPatron($new_patron)
          {
                $this->patron = (string) $new_patron;
          }

          function getPatron()
          {
                return ($this->patron);
          }

          function getId()
          {
              return $this->id;
          }

          function save()
          {
              $GLOBALS['DB']->exec("INSERT INTO clients (patron) VALUES ('{$this->getPatron()}');");
              $this->id = $GLOBALS['DB']->lastInsertId();
          }

          static function getAll()
          {
            $returned_clients = $GLOBALS['DB']->query("SELECT * FROM clients;");
            $clients = array();
            foreach($returned_clients as $client) {
                $patron = $client['patron'];
                $id = $client['id'];
                $new_client = new Client($patron, $id);
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
    }
?>