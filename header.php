<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_id = $_SESSION['user_id'] ?? 0;
?>

<?php
$host ="localhost";
$username="root";
$password="";
$dbname ="shopping";

$conn =mysqli_connect($host,$username,$password,$dbname);

if(isset($conn)){
    echo"Connected";
}
else{
    echo"disConnected";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> الصفحة الرئيسية </title>
    <link rel="styleSheet" href="./style.css">
    <!--Start fontawsome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--End fontawsome-->


</head>

<body>
    <header>
        <!--start logo-->

        <div class="logo">
            <!-- <h1>Online Store</h1> -->
            <img src="./img/store.png">
        </div>

        <!--end logo-->
        <!--start search-->

        <div class="search">
            <div class="search_bar">
                <form action="search.php" method="get">
                    <input type="text" class="search_input" name="search" placeholder="ادخل كلمة البحث">
                    <button class="button_search" name="btn_search"> بحث </button>

                </form>

            </div>
        </div>

        <!--end search-->
    </header>

    <!--start social-->
    <nav>
        <div class="social">
            <ul>
                <li><a href="" target_blank><i class="fa-brands fa-facebook"></i></a> </li>
                <li><a href="" target_blank><i class="fa-brands fa-tiktok"></i></a> </li>
                <li><a href="https://www.youtube.com/@ElzeroWebSchool" target_blank><i class="fa-brands fa-youtube"></i></a> </li>

            </ul>
        </div>

        <!--Start section-->
        <div class="section">
            <ul>
                <li><a href="index.php">الرئيسية</a></li>
                
                    <?php
                    $query="SELECT * FROM section";
                    $result=mysqli_query($conn,$query);
                    while($row=mysqli_fetch_assoc($result)){
                        ?>
                    <li><a href="section.php?section=<?php echo $row['Sectionname'];?>"><?php echo $row['Sectionname'];?></a></li>

                <?php
                }
                ?>

            </ul>
        </div>
    </nav>
    <!--End section-->


    <div class="last-post">
        <h4>مضاف حديثا</h4>
        <ul>
<?php
    $query="SELECT * FROM product ORDER BY ID DESC LIMIT 3";
    $result=mysqli_query($conn,$query);
    while($row=mysqli_fetch_assoc($result)){
       //print_r($row);

    ?>

            <li>
                <a href="details.php?id=<?php echo $row['id'];?>">
                    <span class="span-img">
                        <img src="uploads/img//<?php echo $row['proimg'];?>">
                    </span>
                </a>
            </li>
<?php
    }
    ?>
        </ul>

        <!--cart start-->
        <div class="cart">
            <ul>
                <li><a href="user/logout.php"><i class="fa-solid fa-arrow-right-to-bracket"></i></a></li>

<!--start icon cart-->

<?php
$select_icon ="SELECT * FROM cart WHERE user_id ='$user_id'";
$result=mysqli_query($conn,$select_icon);
if($result){
    $row_count =mysqli_num_rows($result);
}else{
    $row_count =0;
}
?>
                <li class="cart-icon"><a href="cart.php"><i class="fas fa-shopping-cart"></i></a>
                    <span class="cart-count"><?php echo $row_count ?></span>
                </li>
<!--end icon cart-->

            </ul>
        </div>
        <!--cart end-->
    </div>