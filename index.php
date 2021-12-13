<?php
    include 'classes/interact.class.php';
?>

<!DOCTYPE html>

<html lang = "en">
    <head>

        <link rel = "stylesheet" type = "text/css" href = "style.css">
        
        <title>Product List</title>


    </head>
    
    <body>

    <form method="post" action="index.php" id="products">
        <header>
                <div class = "logo">
                    <a href = "index.php">Product List</a>
                </div>
                <div>
                    <ul class = "actions" >
                        <li><a href = "add_product.php">ADD</a></li>
                        <input type="submit" name="delete" id="delete" value="MASS DELETE"> 
                    </ul>
                </div>
        </header>
            
        <section class="table">

        <script>
        $('document').ready(function(){
            $('#products').submit(function(){
                <?php
                $boxValidation =  new Interact();
                if(isset($_POST['delete'])){
                    $checkbox = $_POST['checkbox'];
                    $boxValidation->deleteProductsStmt($checkbox);
                }
                ?>
            });
        });
        </script>

            <div class="cards">
                    <?php
                        $retrieve =  new Interact();
                        $products = $retrieve->getAllProducts();
                        
                        foreach($products as $product){
                            echo "<div class='card'>";
                            echo "<div class='checkBox'>";
                            echo "<input type='checkbox' name='checkbox[]' value='".$product->sku."'>";
                            echo "</div>";
                            echo "<div class='textInCard'>";
                            if($product->typeId == 1){
                                echo '<img src="images/cd.png" style="width:50px;height:50px;" alt="icon" /><br>';
                            }
                            if($product->typeId == 2){
                                echo '<img src="images/furniture.png" style="width:50px;height:50px;" alt="icon" /><br>';                                
                            }
                            if($product->typeId == 3){
                                echo '<img src="images/book.png" style="width:50px;height:50px;" alt="icon" /><br>';
                            }
                            echo $product->sku."<br>".$product->name."<br>".$product->price." $<br>";
                            if($product->typeId == 1){
                                echo "Size: ".$product->size."MB";
                            }
                            if($product->typeId == 2){
                                echo "Dimensions: ".$product->height."x".$product->width."x".$product->length;
                            }
                            if($product->typeId == 3){
                                echo "Weight: ".$product->weight."KG";
                            }
                            echo "</div>";
                            echo "</div>";
                        }
                    ?>
            </div> 

                 
        </section>
       </form>

        <div class="footer">
            <p>Scandiweb Test assignment</p>
        </div>     

    </body>
    
</html>










