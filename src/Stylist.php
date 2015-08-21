<?php

    class Stylist
    {
          private $styler;

          function __construct($styler, $id = null)
          {
                $this->styler = $stylist;
                $this->id = $id;
          }

          function setStyler($new_styler)
          {
                $this->styler = (string) $new_styler;
          }

          function getStyler()
          {
                return ($this->styler);
          }

          function getId()
          {
              return $this->id;
          }

          function save()
          {

          }

          static function getAll()
          {

          }
    }
?>