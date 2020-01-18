<?php
session_start();
/*connecting to MySql*/
require_once "pdo.php";


?>
<!DOCTYPE html>
<html>
    <head>
        <title>search page </title>
        <!----------------the needed links------------>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" >
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" >
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" ></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" ></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" ></script>
    </head>
    <body>
    <form action="search.php" method="post">
        <input type="text" name="search" placeholder="Search for product... "/ >
        <input type="submit" value="Find Product"/ >
    </form>

    <h3 align="center">Tires Shop</h3>
            <?php 
                if(isset($_POST['search']))
                {
                    $search = $_POST['search'];
                    //$search = preg_replace("#[^0-9a-z]#i","",$search);
                    $stmt = $pdo->query("SELECT * FROM  product WHERE name LIKE '%$search%' OR manufacturer LIKE  '%$search%' ") or die("couldnot nearch ");
                    $count = $stmt->rowCount();
                    if ($count == 0 ) 
                    {
                        echo "there was no results!!";
                    }
                    else
                    {
                        echo "<p>we found $count results </p>";
                        while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) )
                        {
                            ?>
                                <div class="col-md-4" style="float:left; padding:20px;  max-height:400px">
                                    <form method="post" action="search.php?action=add&id=<?php echo $row["id"]; ?>">
                                        <div style="border: 1px solid #333; background-color:#f1f1f1; border-radius:5px; ">
                                            <img src="<?php echo $row["product_image"]?>" class="img-fluid" /><br/>
                                            <p class="text-info"> product name : <?php echo $row["name"]?> </p>
                                            <p class="text-info">product manufacturer :<?php echo $row["manufacturer"]?></p>
                                            <p class="text-info">additional info :<?php echo $row["additional"]?></p>
                                            <p class="text-info">product amount : <?php echo $row["availability"]?></p>
                                            <p class="text-danger">Price : €<?php echo $row["price"]?> </p>
                                            <input type="text" name="quantity" class="form-control" value="1" />
                                            <input type="hidden" name="hidden_name" value="<?php echo $row["name"]?>" / >
                                            <input type="hidden" name="hidden_price" value="<?php echo $row["price"]?>" / >
                                            <input type="submit" name="add_to_chart" style="margin-top:5px " class="btn btn-success" value="Add to Cart" />
                                        </div>
                                    </form>
                                </div>
                            <?php
                        }
                    }
                
                }
            ?>
    </body>
</html>
