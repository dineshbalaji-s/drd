<?php
include("../connectivity/connect.php");
session_start();
$var = "";
if (isset($_SESSION["login_user"])){
    $var = $_SESSION["login_user"];
    header("Location: ../");
}

if (isset($_POST["signup"])){
    $email = $_POST["email"];
    $first = $_POST["first"];
    $last = $_POST["last"];
    $pass = $_POST["pass"];
    $pass_conf = $_POST["pass_conf"];
    if ($pass == $pass_conf){
        $query = "insert into user_details (`full_name`, `last_name`, `email`,`password`) VALUES ('$first','$last','$email','$pass')";
        $result = mysqli_query($connection,$query);
        $query1 = "select * from user_details where email = '$email' and password='$pass'";
        $result1 = mysqli_query($connection,$query1);
        $fet = mysqli_fetch_array($result1);
        if ($result1){
            $_SESSION["login_user"] = $fet['full_name'];
            header("Location: ../");

        }else{
            $errorMessage = "Registration cannot be Done !!";
        }
    }else{
        $errorMessage = "Password is not equal !!";
    }
}

if (isset($_POST["signin"])){
    $email = $_POST["email"];
    $pass = $_POST["pass"];
    $query = "select * from user_details where email = '$email' and password='$pass'";
    $result = mysqli_query($connection,$query);
    $fet = mysqli_fetch_array($result);
    if (isset($fet)){
        $_SESSION["login_user"] = $fet['full_name'];
        header("Location: ../");
    }else{
        $errorMessage = "Email or Password is wrong. Please Try again !!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

    <title>Deal Raja Deal</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

</head>

<body>

<nav class="navbar navbar-expand-md navbar-light bg-warning fixed-top">

    <div class="container">

        <a class="navbar-brand" href="../">DealRajaDeal</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Categories</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown01" style="width: 630px">
                        <div class="row" style="padding-left: 20px">
                            <div style="width: 200px;background-color: white;"><?php
                                $query = "select * from category WHERE cat_id != '22' and main_cat != 'Travel' limit 3";
                                $res = mysqli_query($connection,$query);
                                while($row = mysqli_fetch_array($res)){
                                    echo"<a href='../categories/?cat_id=".$row['cat_id']."'><h4 style='font-size: 15px' class=\"dropdown-header text-primary\">".$row['main_cat']."</h4></a>";
                                    $cat_id = $row['cat_id'];
                                    $query1 = "select * from sub_cat WHERE cat_id = '$cat_id' LIMIT 3";
                                    $res1 = mysqli_query($connection,$query1);
                                    while($row1 = mysqli_fetch_array($res1)){
                                        echo "<a class=\"dropdown-item\" style = 'padding-left: 40px' href=\"../categories/?sub_cat_id=".$row1['sub_cat_id']."\">".$row1['sub_cat_name']."</a>";
                                    }
                                    echo '<div class=\"dropdown-divider\"></div>';
                                }
                                ?>
                            </div>
                            <div style="width: 150px;background-color: white;"><?php
                                $query = "select * from category where main_cat = 'Travel'";
                                $res = mysqli_query($connection,$query);
                                while($row = mysqli_fetch_array($res)){
                                    echo"<a href='../categories/?cat_id=".$row['cat_id']."'><h4 style='font-size: 15px' class=\"dropdown-header text-primary\">".$row['main_cat']."</h4></a>";
                                    $cat_id = $row['cat_id'];
                                    $query1 = "select * from sub_cat WHERE cat_id = '$cat_id' LIMIT 4";
                                    $res1 = mysqli_query($connection,$query1);
                                    while($row1 = mysqli_fetch_array($res1)){
                                        echo "<a class=\"dropdown-item \" style = 'padding-left: 40px' href='../categories/?sub_cat_id=".$row1['sub_cat_id']."'>".$row1['sub_cat_name']."</a>";
                                    }
                                    echo '<div class=\"dropdown-divider\"></div>';
                                }
                                ?>
                            </div>
                            <div style="width: 270px;background-color: white;"><?php

                                echo"<h4 style='font-size: 15px' class=\"dropdown-header text-primary\">More Categories</h4>";
                                $query = "select * from category LIMIT 5,11";
                                $res = mysqli_query($connection,$query);
                                while($row = mysqli_fetch_array($res)){
                                    echo "<a class=\"dropdown-item \" style = 'padding-left: 40px' href='../categories/?cat_id=".$row['cat_id']."'>".$row['main_cat']."</a>";
                                }
                                echo"<a class=\"dropdown-item text-primary\" style = 'padding-left: 40px' href=\"../all-categories/\">See all Categories</a>";
                                ?>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Top Stores</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown01" style="width: 602px;">
                        <div class="row" style="padding-left: 15px">
                            <div  style="width: 200px;background-color: white;"><?php
                                $query2 = "select * from store limit 5";
                                $res1 = mysqli_query($connection,$query2);
                                while($row1 = mysqli_fetch_array($res1)){
                                    echo"
                                    <a style = 'height: 75px;width:200px;padding-left:-20px' class=\"dropdown-item bg-light border border-left-0 border-right-0\" href='../deals/?store_id=".$row1['store_id']."'>
                                    <div class = 'row'>
                                    <div class='col-md-4 pull-left' style='padding-top: 20px;' >
                                    <img class=\"rounded\" height=\"20\" width=\"50\" src=\"".$row1['store_logo']."\">
                                    </div>
                                    <div class='col-md-6' style='padding-top: 10px;'>".$row1['store_name']."<br>";

                                    $store_id = $row1['store_id'];
                                    $query3 = "select * from cpn_offr WHERE store_id = '$store_id'";
                                    $res2 = mysqli_query($connection,$query3);
                                    $fet = mysqli_num_rows($res2);
                                    echo $fet." offers
                                       </div>
                                    </div>
                                    </a>";
                                }
                                ?>
                            </div>
                            <div  style="width: 200px;background-color: white; padding-left: 0px"><?php
                                $query2 = "select * from store limit 5,5";
                                $res1 = mysqli_query($connection,$query2);
                                while($row1 = mysqli_fetch_array($res1)){
                                    echo"
                                    <a style = 'height: 75px;width:200px;' class=\"dropdown-item bg-light border border-right-0\"href='../deals/?store_id=".$row1['store_id']."'>
                                    <div class = 'row'>
                                    <div class='col-md-4 pull-left' style='padding-top: 20px;' >
                                    <img class=\"rounded\" height=\"20\" width=\"50\" src=\"".$row1['store_logo']."\">
                                    </div>
                                    <div class='col-md-6' style='padding-top: 10px;'>".$row1['store_name']."<br>";

                                    $store_id = $row1['store_id'];
                                    $query3 = "select * from cpn_offr WHERE store_id = '$store_id'";
                                    $res2 = mysqli_query($connection,$query3);
                                    $fet = mysqli_num_rows($res2);
                                    echo $fet." offers
                                       </div>
                                    </div>
                                    </a>";
                                }
                                ?>
                            </div>
                            <div  style="width: 150px;background-color: white; padding-left: 0px"><?php
                                $query2 = "select * from store limit 10,4";
                                $res1 = mysqli_query($connection,$query2);
                                while($row1 = mysqli_fetch_array($res1)){
                                    echo"
                                    <a style = 'height: 75px;width:200px;' class=\"dropdown-item bg-light border border-right-0\" href='../deals/?store_id=".$row1['store_id']."'>
                                    <div class = 'row'>
                                    <div class='col-md-4 pull-left' style='padding-top: 20px;' >
                                    <img class=\"rounded\" height=\"20\" width=\"50\" src=\"".$row1['store_logo']."\">
                                    </div>
                                    <div class='col-md-6' style='padding-top: 10px;'>".$row1['store_name']."<br>";

                                    $store_id = $row1['store_id'];
                                    $query3 = "select * from cpn_offr WHERE store_id = '$store_id'";
                                    $res2 = mysqli_query($connection,$query3);
                                    $fet = mysqli_num_rows($res2);
                                    echo $fet." offers
                                       </div>
                                    </div>
                                    </a>";
                                }
                                echo"
                                    <a style = 'height: 75px;width:200px;' class=\"dropdown-item bg-light border border-right-0\" href='../all-stores'>
                                    <p style='padding-top: 20px;padding-left: 10px'>View all stores <i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></p>
                                    </a>";
                                ?>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
            <div class="row">
                <?php if (isset($_SESSION['login_user'])){
                    $var = $_SESSION['login_user'];
                    echo"<ul class=\"navbar-nav mr-auto\">
                            <li class=\"nav-item dropdown\">
                                <a href='' class=\"nav-link dropdown-toggle\"  id=\"dropdown01\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\"><i class=\"fa fa-user-circle-o\" aria-hidden=\"true\"></i> ".$var."</a>
                                <div class=\"dropdown-menu\" aria-labelledby=\"dropdown01\">
                                    <a class=\"dropdown-item\" href=\"../connectivity/logout.php\"><i class=\"fa fa-user-circle-o\" aria-hidden=\"true\"></i> Profile</a>
                                    <div class=\"dropdown-divider\"></div>
                                    <a class=\"dropdown-item\" href=\"../connectivity/logout.php\"><i class=\"fa fa-heart-o\" aria-hidden=\"true\"></i> Favourites</a>
                                    <div class=\"dropdown-divider\"></div>
                                    <a class=\"dropdown-item\" href=\"../connectivity/logout.php\"><i class=\"fa fa-sign-out\" aria-hidden=\"true\"></i> logout</a>
                                </div>
                            </li>
                          </ul>";
                } else{
                    echo"
                  <div class=\"col-lg-4\">
                      <a href='../login/' role='button' class=\"btn btn-outline-success\" >Login</a>
                  </div>";
                }?><div class="col-md-6"></div>
            </div>
        </div>
    </div>
</nav>
<br/><br/><br/><br/>

<div class="container">
    <?php if (isset($errorMessage)){ if ($errorMessage != ""){ ?><div class="alert alert-danger alert-dismissible fade show" role="alert"><?php echo $errorMessage; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button></div><?php }}  if (isset($info)){ if ($info != ""){  ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert"><?php echo $info; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div><?php }} if (isset($smsg)){if ($smsg != ""){  ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert"><?php echo $smsg; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div><?php }} ?>

    <h3 class="page-header" align="center">Welcome to DealRajaDeal</h3>
    <br>
    <div class="row justify-content-md-center">
        <div class="col-md-6">
            <div class="card border-danger bg-light  mb-3"  >
                <div class="card-header"><h1 class="text-danger" align="center">Signup</h1></div>
                <div class="card-body" align="center">
                    <form method="post">
                        <div class="row justify-content-md-center">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="first" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="First Name" value="<?php if (isset($first)){ echo $first;} ?>" autofocus required>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="last" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Last Name" value="<?php if (isset($last)){ echo $last;} ?>" autofocus required>

                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" value="<?php if (isset($email)){ echo $email;} ?>" required autofocus>

                        </div>
                        <div class="form-group">
                            <input type="password" name="pass" class="form-control" id="exampleInputPassword1" placeholder="Password" value="<?php if (isset($pass)){ echo $pass;} ?>" autofocus required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="pass_conf" class="form-control" id="exampleInputPassword1" placeholder=" Confirm Password" value="<?php if (isset($pass_conf)){ echo $pass_conf;} ?>" autofocus required>
                        </div>

                        <button type="submit" value="signin" name="signup" class="btn btn-outline-danger">Signup</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<footer class="footer" style="background-color: #6c757d; height: 200px;color: #FFFFFF">
    <div class="container" align="center"><br>
        <span class="text-white" >Copyright @ DealRajaDeal | 2017</span><br><br>Home | Categories | Stores<br><br>
        <i class="fa fa-facebook-official fa-2x"  aria-hidden="true"></i> <i class="fa fa-instagram fa-2x"  aria-hidden="true"></i> <i class="fa fa-twitter-square fa-2x"  aria-hidden="true"></i> <br>Follow Us on social Medias
    </div>
</footer>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="../../../../assets/js/vendor/jquery.min.js"><\/script>')</script>
<script src="../../../../assets/js/vendor/popper.min.js"></script>
<script src="../../../../dist/js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../../../../assets/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>