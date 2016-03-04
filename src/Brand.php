<?php
    class Brand {
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
            $GLOBALS['DB']->exec("INSERT INTO brands (name) VALUES ('{$this->getName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
    {
        $found_brands = $GLOBALS['DB']->query("SELECT * FROM brands;");
        $brands = array();
        foreach($found_brands as $brand)
        {
            $name = $brand['name'];
            $id = $brand['id'];
            $new_brand = new Brand($name, $id);
            array_push($brands, $new_brand);
        }
        return $brands;
    }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM brands;");
        }

        static function find($search_id)
        {
            $found_brand = NULL;
            $brands = Brand::getAll();
            foreach($brands as $brand)
            {
                if ($brand->getId() == $search_id)
                {
                $found_brand = $brand;
                }
            }
            return $found_brand;
        }

        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE brands SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM brands WHERE id = {$this->getId()};");
        }

        function addStore($store_id){
            $GLOBALS['DB']->exec("INSERT INTO brand_store (brand_id, store_id) VALUES ({$this->getId()}, {$store_id});");
        }

        function stores()
        {
            $found_stores = $GLOBALS['DB']->query("SELECT stores.* FROM brands
                                            JOIN brand_store ON (brands.id = brand_store.brand_id)
                                            JOIN stores ON (brand_store.store_id = stores.id)
                                            WHERE brands.id = {$this->getid()};");

            $stores= array();
            foreach($found_stores as $store){
                $name = $store['name'];
                $id = $store['id'];
                $new_store = new Store($name, $id);
                array_push($stores, $new_store);
            }
            return $stores;
        }

} ?>
