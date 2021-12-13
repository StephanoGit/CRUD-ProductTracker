<?php
    include 'classes/interact.class.php';

    if(isset($_POST['save'])){
        if (isset($_POST['sku']) && isset($_POST['name']) && isset($_POST['price']) && isset($_POST['types'])) {

            if($_POST['types'] == 0){
                header("Location:index.php");
            }
            if($_POST['types'] == 1){
                $dvd = new Dvd();
                $dvd->setDvdAttributes($_POST['sku'], $_POST['name'], $_POST['price'], $_POST['types'], $_POST['size']);
                $validationPass = $dvd->productValidation();
                if($validationPass == "Validation passed"){
                    $dvd->insertProductData();
                }else{
                    unset($dvd);
                    echo $validationPass;
                }
            }
            if($_POST['types'] == 2){
                $furniture = new Furniture();
                $furniture->setFurnitureAttributes($_POST['sku'], $_POST['name'], $_POST['price'], $_POST['types'], $_POST['height'], $_POST['width'], $_POST['length']);
                $validationPass = $furniture->productValidation();
                if($validationPass == "Validation passed"){
                    $furniture->insertProductData();
                }else{
                    unset($furniture);
                    echo $validationPass;
                }
            }
            if($_POST['types'] == 3){
                $book = new Book();
                $book->setBookAttributes($_POST['sku'], $_POST['name'], $_POST['price'], $_POST['types'], $_POST['weight']);
                $validationPass = $book->productValidation();
                if($validationPass == "Validation passed"){
                    $book->insertProductData();
                }else{
                    unset($book);
                    echo $validationPass;
                }
            }

        }else{
            header("Location:index.php");
        }
    }
?>
<!DOCTYPE html>

<html lang = "en">
    <head>

        <link rel = "stylesheet" type = "text/css" href = "style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

        
        <title>Product Add</title>
    
    </head>
    
    <body>
    <form action=" " method="post" class= "addForm" id="product_form">

    <script>
            $('document').ready(function(){
                $('#productType').change(function(){
                    var value = $('#productType').val();
                    console.log(value);
                    var div = $("#details");
                    
                    if (value == "0") {

                        $('#DVD').css("display","none");
                        $('#Furniture').css("display","none");
                        $('#Book').css("display","none");

                    }
                    if (value == "1") {
                        $('#Furniture').css("display","none");
                        $('#Book').css("display","none");
                        $('#DVD').css("display","block");

                    }
                    if (value == "2") {
                        $('#DVD').css("display","none");
                        $('#Book').css("display","none");
                        $('#Furniture').css("display","block");

                    }
                    if (value == "3") {
                        $('#DVD').css("display","none");
                        $('#Furniture').css("display","none");
                        $('#Book').css("display","block");
                      
                    }
                });
            });
        </script>

        <header>
                <div class = "logo">
                    <a href = "#">Product Add</a>
                </div>
                <div>
                    <ul class = "actions">
                        <input type="submit" name="save" id="save" value="Save Product">
                        <li><a href = "index.php">Cancel</a></li>

                    </ul>
                </div>
        </header>
            
        <section class="table">
            <div class="formBox">
                    SKU<input type="text" name="sku" id="sku"> <br><br>
                    Name <input type="text" name="name" id="name"> <br><br>
                    Price <input type="text" name="price" id="price"> <br><br>
                    Type <select name="types" id="productType">
                        <option value="0">Choose Type</option>
                        <option value="1">DVD</option>
                        <option value="2">Furniture</option>
                        <option value="3">Book</option>
                    </select>
                    

            </div>
            <div class="formBox" id="details">

                <div id="DVD" style="display:none">
                     Size (MB)<input type="text" name="size" id="size"> <br> <p>Please, provide size</p>
                </div>

                <div id="Furniture" style="display:none">
                    Height (CM)<input type="text" name="height" id="height"> <br><br> Width (CM)<input type="text" name="width" id="width"> <br><br> Length (CM) <input type="text" name="length" id="length"> <br> <p>Please, provide dimensions</p>
                </div>

                <div id="Book" style="display:none">
                    Weight (KG)<input type="text" name="weight" id="weight"> <br> <p>Please, provide weight</p>
                </div>
           
            </div>
        </section>
    </form>      
    </body>
    
</html>