<?php
session_start();
/*connecting to MySql*/
require_once "pdo.php";

if(isset($_POST["add_to_chart"]))
{
    if(isset($_SESSION["shopping_cart"]))
    {
        $item_array_id = array_column($_SESSION["shopping_cart"],"item_id");
        if(!in_array($_GET["id"], $item_array_id))
        {
            $count=count($_SESSION["shopping_cart"]);
            $item_array = array(
            'item_id' => $_GET["id"],
            'item_name' => $_POST["hidden_name"],
            'item_price' => $_POST["hidden_price"],
            'item_quantity' => $_POST["quantity"]

            );
            $_SESSION["shopping_cart"][$count]=$item_array;

        }
        else
        {
            echo '<script> alert("item Already added")</script> ';
            echo '<script> window.location="index.php"</script>';

        }
    }
    else
    {
        $item_array = array(
            'item_id' => $_GET["id"],
            'item_name' => $_POST["hidden_name"],
            'item_price' => $_POST["hidden_price"],
            'item_quantity' => $_POST["quantity"]
        );
        $_SESSION["shopping_cart"][0]=$item_array;
    }
}

if(isset($_GET["action"]))
{
    if($_GET["action"] == "delete")
    {
        foreach($_SESSION["shopping_cart"] as $keys => $values)
        {
            if($values["item_id"] == $_GET["id"])
            {
                unset($_SESSION["shopping_cart"][$keys]);
                echo '<script>alert("item remove")</script>';
                echo '<script>windows.location="index.php"</script>';
            }
        }
    }

};
?>
<!DOCTYPE html>
<html>
    <head>
        <title>tires shop</title>
        <!----------------the needed links------------>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" >
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" >
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" ></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" ></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" ></script>
    </head>
    <body>
        <br/>
        
        
            <form action="index.php" method="post">
                <input type="text" name="search" placeholder="Search for product... "/ >
                <input type="submit" value="Find Product"/ >
            </form>
        

       
                <div class="table-responsive" >
            
        
               
                <?php 
                        if(!empty($_SESSION["shopping_cart"]))
                        {
                ?>
                    <table class="table table-bordered">
                    <tr>
                        <th width="40%">Item name</th>
                        <th width="10%">Quantity</th>
                        <th width="20%">price</th>
                        <th width="15%">Total</th>
                        <th width="5%">Action</th>
                    </tr>

                    <?php
                            $total = 0;
                            foreach($_SESSION["shopping_cart"] as $keys => $values)
                            {
                     ?>
                                 <tr>
                                    <td><?php echo $values["item_name"] ?></td>
                                    <td><?php echo $values["item_quantity"] ?></td>
                                    <td> €<?php echo $values["item_price"] ?></td>
                                    <td> €<?php echo number_format($values["item_quantity"] * $values["item_price"],2 ) ?></td>
                                    <td> <a href="index.php?action=delete&id=<?php echo $values['item_id']; ?>" > <span class="text-danger">remove</span> </a> </td>
                                 </tr>
                     <?php
                                $total=$total + ($values["item_quantity"] * $values["item_price"]);
                            }
                    ?>
                            <tr>
                                <td colspan="3" align="right"> <img src="img/cart.png" style="width:25px; height:25px;"> Total </td>
                                <td align="right"> €<?php echo number_format($total,2)?> </td>
                                <td></td>
                            </tr>

                            <?php
                        }
                    ?>
                </table>
            </div>
                
         <div class="container" >
            <h2 align="center">Tires Shop</h2>
            
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
                      echo "<p><b> There are  $count Products  </b></p>";
                      while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) )
                      {
                          ?>
                              <div class="col-md-4" style="float:left; padding:20px;  max-height:400px">
                                  <form method="post" action="index.php?action=add&id=<?php echo $row["id"]; ?>">
                                      <div style="border: 1px solid #333; background-color:#f1f1f1; border-radius:5px; ">
                                          <img src="<?php echo $row["product_image"]?>" class="img-fluid" /><br/>
                                          <p class="text-info"> product name : <?php echo $row["name"]?> </p>
                                          <p class="text-info">product manufacturer :<?php echo $row["manufacturer"]?></p>
                                          
                                          <p class="text-danger">Price : €<?php echo $row["price"]?> </p>
                                          <input type="text" name="quantity" class="form-control" value="1" />
                                          <input type="hidden" name="hidden_name" value="<?php echo $row["name"]?>" / >
                                          <input type="hidden" name="hidden_price" value="<?php echo $row["price"]?>" / >
                                          <input type="submit" name="add_to_chart" style="margin-top:5px " class="btn btn-success" value="Add to Cart" />
                                          <a href='details.php?id="<?php echo $row["id"] ?>"'><b>More details</b></a>
                                      </div>
                                  </form>
                                  
                              </div>
                          <?php
                      }
                  }
              
              }
              else
              {

                $stmt = $pdo->query("SELECT * FROM  product");
                  $count = $stmt->rowCount();
                  if ($count == 0 ) 
                  {
                      echo "there was no results!!";
                  }
                  else
                  {
                    echo "<p><b> There are  $count Products  </b></p>";
                    while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) )
                      {
                          ?>
                              <div class="col-md-4" style="float:left; padding:20px;  max-height:400px">
                                  <form method="post" action="index.php?action=add&id=<?php echo $row["id"]; ?>">
                                      <div style="border: 1px solid #333; background-color:#f1f1f1; border-radius:5px; ">
                                          <img src="<?php echo $row["product_image"]?>" class="img-fluid"  /><br/>
                                          <p class="text-info"> product name : <?php echo $row["name"]?> </p>
                                          <p class="text-info">product manufacturer :<?php echo $row["manufacturer"]?></p>
                                         
                                          <p class="text-danger">Price : €<?php echo $row["price"]?> </p>
                                          <input type="text" name="quantity" class="form-control" value="1" />
                                          <input type="hidden" name="hidden_name" value="<?php echo $row["name"]?>" / >
                                          <input type="hidden" name="hidden_price" value="<?php echo $row["price"]?>" / >
                                          <input type="submit" name="add_to_chart" style="margin-top:5px " class="btn btn-success" value="Add to Cart" />
                                          <a href='details.php?id="<?php echo $row["id"] ?>"'><b>More details</b></a>
                                      </div>
                                  </form>
                              </div>
                          <?php
                      }
                  }
              }
            ?>
           
            </div>
       
            
        
        
        <br/>
    </body>
</html>