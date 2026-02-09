<?php
include('file/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل المنتج</title>
</head>
<style>
    /* -- -- -- -- -- -- -- CSS -- -- -- -- -- -- -- --  */
    /* -- -- -- start main product details [1] -- -- -- */
    main{
        display:flex;
        flex-wrap: wrap;
    }
    .container{
        width:90%;
        height: 400px;
        margin:20px auto;
        border-radius: 8px;
    }
    .product-img{
        float: left;
        display: flex;
        flex-wrap: wrap;
        margin-bottom:20px;
    }
    .product-img img{
        width: 400px;
        height: 400px;
        margin-left: 40px;
        margin-bottom: 20px;
    }
    .product-info{
        float: right;
        width: 200px;
        height: 400px;
        text-align: center;
        font-size: 20px;
        margin-bottom: 10px;
        margin-right: 50px;
        padding: 10px 10px;
        margin-top: 20px;
        color: #351d08ff;
    }
    h3{
        margin-top: 20px;
    }
    .product-title{
        margin: 10px 0;
    }
    .product-price{
        color: #e67e22;
        margin: 10px 0;
    }
    .product-description{
        font-size:16px;
        line-height:2;
    }
    .add_cart{
        width: 150px;
        height: 35px;
        /* margin-right: 50px; */
        /* margin-left: 50px; */
        padding: 10px 10px;
        background-color: #e67e22 ;
        border-radius: 5px;
        cursor:pointer;
        font-weight: bold;

    }
    .add_cart:hover{
        background-color: #e67e22;
    }

    /* recently added products [2] -- */
    .recently_added{
        float:right;
        width:30%;
        margin-top:30px;
        border-radius: 8px;
        padding: 10px 10px;
        box-shadow: 0 5px 10px rgba(0,0,0,1.0);
    }
    .added_img img{
        float:right;
        margin: 10px 10px;
        width:70px;
        height: 70px;
        margin-right: 50px;
        border-radius:10px;
    }

    /* -- -- -- -- -- -- --  start comment section [3] -- -- -- -- -- -- -- */
    .comment_info{
        float:left;
        width:40%;
        height:300px;
        margin-bottom: 50px;
        box-shadow: 0 2px 2px  rgba(0,0,0,1.0);
    }
    h5{
        font-size: 20px;
        margin-top: 20px;
        text-align: center;
        color: #351d08ff;
    }
    textarea{
        text-align: center;
        width: 80%;
        margin-top: 20px;
        margin-left: 50px;
        margin-bottom: 10px;
        padding: 10px;
        border: 1px solid #e67e22;
        border-radius: 10px;
        height: 50px;
    }
    .add_comment{
        width: 100px;
        height: 35px;
        margin-left: 40px;
        padding: 10px 10px;
        background-color: #fff;
        border-radius: 5px;
    }
    .add_comment:hover{
        background-color: #e67e22;
    }
    .comments{
        margin-top: 10px;
    }
    .comment{
        color: black;
        font-size: larger;
        margin: 5px 5px;
        text-align: center;
        padding:10px;
        background-color: #fff;
        border: 1px solid #ddd;
        margin-bottom: 10px;
        border-radius: 5px;
        overflow:hidden;
        text-overflow: ellipsis;
    }
    .username{
        padding: 4px 5px;
        text-align: right;
        color: #351d08ff;
        font-size: 20px;
    }

</style>
<body>

    <!-- [1] -->
    <main>
        <?php
        @$id =$_GET['id'];
        if(isset($_GET['id'])){
            $query= "SELECT * FROM product WHERE id='$id'";
            $result = mysqli_query($conn,$query);
            $row =mysqli_fetch_assoc($result);
        }
        ?>
        <!-- img -->
        <div class="product-img">
            <a href="details.php?id=<?php echo $row['id'] ?>">
                <img src="uploads/img/<?php echo $row['proimg']; ?>">
                <!-- <span class="unavailable"><?php echo $row['prounv']; ?></span> -->
            </a>
        </div>
        
        <!--start information-->
        <div class="product-info">
            <h1 class="product-title"><?php echo @$row['proname'];?></h1>
            <h2 class="product-price"><?php echo @$row['proprice'];?> &nbsp; السعر </h2><br>

            <!-- product section -->
            <div class="product-section">
                <a href="section.php?section=<?php echo $row['proname']; ?>">
            <?php echo @$row['proname'];?></a>
            </div>
            <!-- product section -->

            <h3> <?php echo @$row['prosize'];?> &nbsp; المقاسات المتوفرة  </h3>
            <h4 class="product-description"> تفاصيل المنتج </h4>
            <p> <?php echo @$row['prodescrip'];?> </p>
             <!--quantity-->
            <div class="qty-input">
                <button class="qty-count-mins">-</button>
                <input type="number" id="quantity" name="" value="1" min="0" max="7">
                <button class="qty-count-add">+</button>
            </div> <br>
             <!--quantity-->

             <!--submit-->
            <div class="submit"><a href="">
                <button class="add_cart" type="submit" name="">إرســـال
                </button>
                </a>
        </div>
            <!--submit-->
            </div>
        
    </main>
    <hr>

    <!-- -- -- -- start recently added  صور المنتجات الحديثة (مضافة آخر حاجة) [2] - -->
    <div class="container">
        <div class="recently_added">
            <h4>منتجات حديثة</h4>

            <?php
            $query= "SELECT * FROM product WHERE id!='$id' ORDER BY rand() LIMIT 3";
            $result= mysqli_query($conn,$query);
            while($row=mysqli_fetch_assoc($result))
                {
            ?>

            <div class="added_img">
                <a href="details.php?id=<?php echo $row['id']?>">
                <img src="uploads/img/<?php echo $row['proimg'];?>">  
                </a>
            </div>
        <?php
        }
        ?>

        </div>
        <!--end recently added-->


        <!-- --- -- -- -- -- --- -- --  عبارة عن كومينت للتقييم المنتج start comment [3]-- -- -->
        <div class="comment_info">
            <?php
              // add comment
            @$comment =$_POST['comment'];
            @$add_comment =$_POST['add_comment'];

                if(isset($add_comment))
                    {
                       if(empty($comment))
                        {
                           echo '<script> alert("الرجاء كتابة تعليق لأن الحقل فارغ")</script>';
                        }
                        else
                            {
                              $query=" INSERT INTO comments (comment) VALUES('$comment') ";
                              $result=mysqli_query($conn,$query);
                            }
                    }

        //استرجاع المعلومات من قاعدة البيانات الى المتجر
            $query="SELECT * FROM comments";
            $result=mysqli_query($conn,$query);
            ?> 


            <h5> هل تود تقييم هذا المنتج</h5>
            <form action="" method="post">
                <textarea name="comment" placeholder="قيم هذا المنتج من فضلك " ></textarea>
                <button class="add_comment" type="submit" name="add_comment">إرســـــال</button>
            </form>

            <h5>تقييمات العملاء</h5>
            <div class="comments">
            <?php
            if(mysqli_num_rows($result) > 0)
                {
                while($row=mysqli_fetch_assoc($result))
                    {
                    echo " <div class='username'nbsp&; Rating by >" .$row['username']. "</div>";
                    //  echo " <div class='username'> تقييم بواسطة &nbsp;" .$row['username']. "</div>";
                     echo " <div class='comment'>" .$row['comment']. "</div>";
                    }
                }
                else
                   
                    {
                    echo "لا يوجد اي تقييم الى الان";
                    }
            ?>
            </div>
        </div>

        <!--end comment-->

    </div>
    <!--end recently added-->
</body>
<?php
include('file/footer.php');
?>
</html>
