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

        static function find($search_id)
        {
            $found_store = NULL;
            $stores = Store::getAll();
            foreach($stores as $store)
            {
                if ($store->getId() == $search_id)
                {
                $found_store = $store;
                }
            }
            return $found_store;
        }

        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE stores SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        function delete(){
            $GLOBALS['DB']->exec("DELETE FROM stores WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM brand_store WHERE store.id = {$this->getId()};");
        }

        function addBrand($brand_id){
            $GLOBALS['DB']->exec("INSERT INTO brand_store (brand_id, store_id) VALUES ({$brand_id}, {$this->getId()});");
        }

        function brands()
        {
            $found_brands = $GLOBALS['DB']->query("SELECT brands.* FROM stores
                                            JOIN brand_store ON (stores.id = brand_store.store_id)
                                            JOIN brands ON (brand_store.brand_id = brands.id)
                                            WHERE stores.id = {$this->getid()};");

            $brands= array();
            foreach($found_brands as $brand){
                $name = $brand['name'];
                $id = $brand['id'];
                $new_brand = new Brand($name, $id);
                array_push($brands, $new_brand);
            }
            return $brands;
        }

} ?>
