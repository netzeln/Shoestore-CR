<?php
    class Store {
        private $name;
        private $id;

        function __construct ($name, $id = NULL)
        {
            $this->name = $name;
            $this->id = $id;
        }

        function getName()
        {
            return $this->name;
        }
        function getId()
        {
            return $this->id;
        }
        function setName($new_name)
        {
            $this->name = $new_name;
        }
        


} ?>
