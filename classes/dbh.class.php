<?php

//this class assures the connection to the database
//the connect function could intake variables to make it more oop like, I manually introduced the values here for easier use
class DataBase{
    public function connect(){
        // Create connection
        $conn = mysqli_connect("localhost", "id16956764_admin", "Test1234567?", "id16956764_product_list");

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        //echo "Connected successfully";
        return $conn;
    }
}
?>