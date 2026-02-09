  <?php
  session_start();
  if(!isset($_SESSION['user_id'])){
    echo '
    <script>
        alert("يرجى تسجيل الدخول أولا لإضافة المنتج إلى السلة");
        window.location.href="user/login.php";
    </script>
    ';
  }
  $user_id =$_SESSION['user_id'];
  //echo "$user_id";
  if($user_id <=0){
    echo '
    <script>
        alert("مستخدم غير صحيح");
        window.location.href="user/login.php";
    </script>
    ';
  }
  ?>
  
  <?php
include('file/header.php');
  ?>
  <!--product start-->

    <main>

    <?php
    $query="SELECT * FROM product";
    $result=mysqli_query($conn,$query);
    while($row=mysqli_fetch_assoc($result)){
       //print_r($row);

    ?>
        <div class="product">
            <!--img-->
            <div class="product-img"><a href="details.php?id=<?php echo $row['id']?>">
                <img src="uploads/img//<?php echo $row['proimg'];?>">
                <span class="unavailable"><?php echo $row['prounv'];?></span>
            </div>
            <!--section-->
            <div class="product-section">
                <a href="section.php?section=<?php echo $row['prosection']; ?>">
            <?php echo $row['prosection'];?></a>
            </div>
            <!--name-->

            <div class="product-name"><a href="details.php?id=<?php echo $row['id']?>"><?php echo $row['proname'];?></a>

            </div>
            <!--price-->

            <div class="product-price"><a href="details.php?id=<?php echo $row['id']?>"><?php echo $row['proprice']?>&nbsp; السعر </a>

            </div>

            <!--description-->

            <div class="product-description">
                <a href="details.php"><i class="fa-solid fa-eye"></i>لتفاصيل المنتج اضغط هنا</a>

            </div>
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



    </main>
    <br>
    <br>
    <!--product end-->
    <?php
include('file/footer.php');
?>