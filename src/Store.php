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

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO stores (name) VALUES ('{$this->getName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
    {
        $found_stores = $GLOBALS['DB']->query("SELECT * FROM stores;");
        $stores = array();
        foreach($found_stores as $store)
        {
            $name = $store['name'];
            $id = $store['id'];
            $new_store = new Store($name, $id);
            array_push($stores, $new_store);
        }
        return $stores;
    }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores;");
        }


} ?>
