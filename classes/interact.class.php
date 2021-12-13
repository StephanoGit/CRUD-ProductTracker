<?php

    include_once 'classes/dbh.class.php';

    ini_set('display_errors', 1); ini_set('log_errors',1); error_reporting(E_ALL); mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    //abstract class that describes a product
    abstract class Product extends DataBase{

        public $sku;
        public $name;
        public $price;
        public $typeId;

        public function setProductGeneralAttributes($sku, $name, $price, $typeId){
            $this->sku = $sku;
            $this->name = $name;
            $this->price = $price;
            $this->typeId = $typeId;
        }

        //this insert method is used for every product - children of this class
        //in returns an array that contains the id of each product special detail - size, dimenions, weight 
        public function insertProductData(){
            $conn = $this->connect();
            $sql = "INSERT INTO Product_table(SKU, Name, Price, TypeID) VALUES ('$this->sku', '$this->name', '$this->price', '$this->typeId')";
            mysqli_query($conn, $sql) or die(mysqli_error($conn));

            $sql = "SELECT ID FROM Attribute_table WHERE TypeID = '$this->typeId'";
            $stmt = $this->connect()->query($sql);
            $idArray = Array();
            //get the specific ids asscoiated with the type of products and save in array
            while($row = $stmt->fetch_assoc()) {
                $idArray[] =  $row['ID'];
            }
            return $idArray;
        }

        //this method checks if the values introduced by the user are valid
        //this method is inferitable and could differ from product to product
        //checks just for the attributes that products have in commun - sku, name, price, typeId
        public function productValidation(){
            $error = "Validation passed";

            //transform to float
            if(is_numeric($this->price)){
                $this->price = $this->price + 0;
            }

            //check for duplicated id
            $conn = $this->connect();
            $dupId = "SELECT SKU FROM Product_table WHERE SKU = '$this->sku'";
            $dupId = mysqli_query($conn, $dupId);
            $numberOfDups = mysqli_num_rows($dupId);
            if($numberOfDups > 0){
                $error = "Please, provide a unique SKU";
                return $error;
            }

            if(empty($this->sku) || empty($this->name) || empty($this->price) || empty($this->typeId)){
                $error = "Please, submit required data";
                return $error;
            }
            if(!is_float(floatval($this->price)) || !is_numeric($this->price)){
                $error = "Please, provide the data of indicated type";
                return $error;
            }
            return $error;
        }

        // public function getSku(){
        //     return $this->sku;
        // }

        // public function getName(){
        //     return $this->name;
        // }

        // public function getPrice(){
        //     return $this->price;
        // }

        // public function getTypeId(){
        //     return $this->typeId;
        // }
    }

    //child of Product
    //has one additional specific attribute - size
    class Dvd extends Product{
        public $size;

        public function setDvdAttributes($sku, $name, $price, $typeId, $size){
            parent::setProductGeneralAttributes($sku, $name, $price, $typeId);
            $this->size = $size;
        }

        public function insertProductData(){
            $idArray = parent::insertProductData(); //set sku, name, price, type
            foreach($idArray as $idNo){
                $conn = $this->connect();
                $sql = "INSERT INTO ProductDetails_table(SKU, Attribute_id, Attribute_value) VALUES ('$this->sku', '$idNo','$this->size')"; //set size
                mysqli_query($conn, $sql) or die(mysqli_error($conn));
            }
        }

        public function productValidation(){
            $error = parent::productValidation();
            if(empty($this->size)){
                $error = "Please, submit required data";
                return $error;
            }
            if(!is_numeric($this->size)){
                $error = "Please, provide the data of indicated type";
                return $error;
            }
            return $error;
        }

        // public function getSize(){
        //     return $this->size;
        // }

        // public function setSize($size){
        //     $this->size = $size;
        // }

    }

    //child of Product
    //has 3 additional specific attributes - height, width, length
    class Furniture extends Product{
        public $height;
        public $width;
        public $length;

        public function setFurnitureAttributes($sku, $name, $price, $typeId, $height, $width, $length){
            parent::setProductGeneralAttributes($sku, $name, $price, $typeId);
            $this->height = $height;
            $this->width = $width;
            $this->length = $length;
        }

        public function insertProductData(){
            $valueArray = Array();
            array_push($valueArray, $this->height);
            array_push($valueArray, $this->width);
            array_push($valueArray, $this->length);
            $idArray = parent::insertProductData(); //set sku, name, price, type and return id of details

            for($i = 0; $i < sizeof($idArray); $i+=1){
                $conn = $this->connect();
                $currentId = $idArray[$i];
                $currentValue = $valueArray[$i];
                $sql = "INSERT INTO ProductDetails_table(SKU, Attribute_id, Attribute_value) VALUES ('$this->sku', '$currentId','$currentValue')";
                mysqli_query($conn, $sql) or die(mysqli_error($conn));
            }
        }

        public function productValidation(){
            $error = parent::productValidation();
            if(empty($this->height) || empty($this->width) || empty($this->length)){
                $error = "Please, submit required data";
                return $error;
            }
            if(!is_numeric($this->height) || !is_numeric($this->width) || !is_numeric($this->length)){
                $error = "Please, provide the data of indicated type";
                return $error;
            }
            return $error;
        }

        // public function getHeight(){
        //     return $this->height;
        // }

        // public function getWidth(){
        //     return $this->width;
        // }

        // public function getLength(){
        //     return $this->length;
        // }

        // public function setHeight($height){
        //     $this->height = $height;
        // }

        // public function setWidth($width){
        //     $this->width = $width;
        // }

        // public function setLength($length){
        //     $this->length = $length;
        // }
    }

    //child of Product
    //has one additional specific attribute - weight
    class Book extends Product{
        public $weight;

        public function setBookAttributes($sku, $name, $price, $typeId, $weight){
            parent::setProductGeneralAttributes($sku, $name, $price, $typeId);
            $this->weight = $weight;
        }

        public function insertProductData(){
            $idArray = parent::insertProductData(); //set sku, name, price, type
            foreach($idArray as $idNo){
                $conn = $this->connect();
                $sql = "INSERT INTO ProductDetails_table(SKU, Attribute_id, Attribute_value) VALUES ('$this->sku', '$idNo','$this->weight')"; //set size
                mysqli_query($conn, $sql) or die(mysqli_error($conn));
            }
        }

        public function productValidation(){
            $error = parent::productValidation();
            if(empty($this->weight)){
                $error = "Please, submit required data";
                return $error;
            }
            if(!is_numeric($this->weight)){
                $error = "Please, provide the data of indicated type";
                return $error;
            }
            return $error;
        }

        // public function getWeight(){
        //     return $this->weight;
        // }

        // public function setWeight($weight){
        //     $this->weight = $weight;
        // }
    }

//class that helps interact with the database in order to extract different attributes
class Interact extends DataBase{

    //get the details of a product (size, WxHxL, weight)
    public function getDetailProducts($sku) {
        $sql = "SELECT Attribute_value FROM ProductDetails_table WHERE SKU='$sku'";
        $stmt = $this->connect()->query($sql);
        $array = Array();
        //get data from db
        while($row = $stmt->fetch_assoc()) {
            $array[] =  $row['Attribute_value'];
        }
        return $array;
    }

    //this functions fetches all the products from the single table of products and returns an array of objects
    public function getAllProducts(){
        $sql = "SELECT * FROM Product_table";
        $stmt = $this->connect()->query($sql);
        $productArray = Array();
        
        while($row = $stmt->fetch_assoc()) {
            if($row['TypeID'] == "1"){
                $product = new Dvd();
                $product->setDvdAttributes($row['SKU'], $row['Name'], $row['Price'], $row['TypeID'], implode($this->getDetailProducts($row['SKU'])));
                array_push($productArray, $product);
            }
            if($row['TypeID'] == "2"){
                $attribute = $this->getDetailProducts($row['SKU']);
                $product = new Furniture();
                $product->setFurnitureAttributes($row['SKU'], $row['Name'], $row['Price'], $row['TypeID'], $attribute[0], $attribute[1], $attribute[2]);
                array_push($productArray, $product);
            }
            if($row['TypeID'] == "3"){
                $product = new Book();
                $product->setBookAttributes($row['SKU'], $row['Name'], $row['Price'], $row['TypeID'], implode($this->getDetailProducts($row['SKU'])));
                array_push($productArray, $product);
            }
        }
        return $productArray;
    }

    //delete a product from the table
    //this method checks the product table (where are my products are saved) for the product/s that have the same sku as the one/s passed in the checkBoxArray
    //this is the optimal way to delete a product, works for any new product or class introduced
    public function deleteProductsStmt($checkBoxArray) {
        $conn = $this->connect();
            foreach($checkBoxArray as $sku){
                $sql = "DELETE FROM Product_table WHERE SKU = '$sku'";
                mysqli_query($conn, $sql) or die(mysqli_error($conn));
                $sql = "DELETE FROM ProductDetails_table WHERE SKU = '$sku'";
                mysqli_query($conn, $sql) or die(mysqli_error($conn));
            }

    }

}