<?php
include('file/header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الاقسام</title>
</head>
<body>

<main>
<?php
$section = $_GET['section'];
$query = "SELECT * FROM product WHERE prosection ='$section' ORDER BY id DESC";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
?>
    <div class="product">

        <!-- img -->
        <div class="product-img">
            <a href="details.php?id=<?php echo $row['id'] ?>">
                <img src="uploads/img/<?php echo $row['proimg']; ?>">
                <span class="unavailable"><?php echo $row['prounv']; ?></span>
            </a>
        </div>

        <!-- section -->
        <div class="product-section">
            <a href="details.php?id=<?php echo $row['id'] ?>">
                <?php echo $row['prosection']; ?>
            </a>
        </div>

        <!-- name -->
        <div class="product-name">
            <a href="details.php?id=<?php echo $row['id'] ?>">
                <?php echo $row['proname']; ?>
            </a>
        </div>

        <!-- price -->
        <div class="product-price">
            <?php echo $row['proprice']; ?> السعر
        </div>

        <!-- description -->
        <div class="product-description">
            <a href="details.php?id=<?php echo $row['id'] ?>">
                <i class="fa-solid fa-eye"></i> لتفاصيل المنتج اضغط هنا
            </a>
        </div>

        <!--  start FORM -->

        <!--quantity-->
            <div class="qty-input">
                <!--cart form-->
                <form action="cart.php?action<?php echo $row['id'];?>" method="post">
                <button class="qty-count-mins">-</button>
                <input type="number" id="" name="quantity" value="1" min="0" max="7">

                <input type="hidden" name="product_id" value="<?php echo $row['id'];?>">

                <input type="hidden" name="h_name" value="<?php echo $row['proname'];?>">
                <input type="hidden" name="h_price" value="<?php echo $row['proprice'];?>">
                <input type="hidden" name="h_img" value="<?php echo $row['proimg'];?>">

                <button class="qty-count-add">+</button>
            </div> <br>
             <!--quantity-->

            <!--submit-->

            <div class="submit"><a href="">
                    <button class="addto-cart" type="submit" name="add" value="add_cart">
                        <i class="fa-solid fa-cart-plus">&nbsp;</i> أضف إلى السلة
                    </button>
                </a>
            </div>
             <!--submit-->
                </form> 
        </div>
        <?php
         }
         ?>
        <!--  END FORM -->

    </div>
<?php
    }
else{
    echo '<div class="notification">لا توجد منتجات في هذا القسم</div>';
}
?>
</main>

</body>
</html>
<?php
include('file/footer.php');
?>