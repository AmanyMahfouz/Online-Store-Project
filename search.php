<?php
include('file/header.php');
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
  </head>
  <style>
    .notification{
      width:1000px;
      height: 50px;
      background-color: wheat;
      border: 2px solid red;
      margin: 140px 130px;
      padding: 10px;
      font-size: 40px;
      color: black;
      text-align: center;
}
  </style>
  <body>
    
  </body>
  </html>
<?php
if(isset($_GET['btn_search'])){
   $search =$_GET['search'];
    $query ="SELECT * FROM product WHERE
     prodescrip LIKE '%$search%'
    or proname LIKE '%$search%'
    or id LIKE '%$search%'
    or prosection LIKE '%$search%'
    or proprice LIKE '%$search%'";
    $_result = mysqli_query($conn,$query);
    if(mysqli_num_rows($_result) > 0){
        while ($row = mysqli_fetch_assoc($_result)){
            echo '

             <div class="product">
            <!--img-->
            <div class="product-img">
                <img src="uploads/img//' .$row['proimg'].'">
                <span class="unavailable">'.$row['prounv'].'</span>
            </div>
            <!--section-->
            <div class="product-section"><a href="">'.$row['prosection'].'</a>
            </div>
            <!--name-->

            <div class="product-name"><a href="">'.$row['proname'].'</a>

            </div>
            <!--price-->
           <div class="product-price">
           <a href="">' . $row['proprice'] . ' السعر</a>
        </div>

            <!--description-->

            <div class="product-description">
                <a href="details.php"><i class="fa-solid fa-eye"></i>لتفاصيل المنتج اضغط هنا</a>

            </div>
            <!--quantity-->
            <div class="qty-input">
                <button class="qty-count-mins">-</button>
                <input type="number" id="quantity" name="" value="1" min="0" max="7">
                <button class="qty-count-add">+</button>
            </div> <br>

            <!--submit-->

            <div class="submit"><a href="">
                    <button class="addto-cart" type="submit" name="">
                        <i class="fa-solid fa-cart-plus">&nbsp;</i> أضف إلى السلة
                    </button>
                </a></div>
        </div>
            
            ';
        }
    }
    else{
echo ',<div class="notification">
المنتج الذي تبحث عنه غير متوفر حاليا
</div>';        
    }
}
?>


<?php
include('file/footer.php');
?>