<?php
session_start();
/*connecting to MySql*/
require_once "pdo.php";
if(!isset($_GET['id']))
{
    die("the is no such item ");
}
else
{
?>
<!DOCTYPE html>
<html>
    <head>
        <title> product details</title>
        <!----------------the needed links------------>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" >
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" >
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" ></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" ></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" ></script>
    </head>
    <body>
        <div class="details">
        <?php
            $stmt = $pdo->query("SELECT * FROM  product WHERE id =".$_GET['id']);
                            
                            
                                while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) )
                                {
                                    ?>
                                        <div  style="float:left; padding:20px;  width:100%;">
                                            <form method="post" action="index.php?action=add&id=<?php echo $row["id"]; ?>">
                                                <div style="border: 1px solid #333; background-color:#f1f1f1; border-radius:5px; ">
                                                    <img src="<?php echo $row["product_image"]?>" class="img-fluid" width="35%" /><br/>
                                                    <p class="text-info"> product name : <?php echo $row["name"]?> </p>
                                                    <p class="text-info">product manufacturer :<?php echo $row["manufacturer"]?></p>
                                                    <p class="text-info">additional info :<?php echo $row["additional"]?></p>
                                                    <p class="text-info">product amount : <?php echo $row["availability"]?></p>
                                                    <p class="text-danger">Price : €<?php echo $row["price"]?> </p>
                                                    <a href='index.php'><b>Back to Products</b></a>

                                                </div>
                                            </form>
                                        </div>
                                    <?php
                                }
                            
            }
            ?>

        </div>
        

</body>
</html>