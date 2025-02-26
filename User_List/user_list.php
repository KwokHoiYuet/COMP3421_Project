<?php

// Initialize the session.
session_start();

// Include config file
require_once "../config.php";

// //Check if the user is already logged in, if no then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false){
    header("location: /");
    exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST["search"]))){
        $search = "";
    } else{
        $search = trim($_POST["search"]);
        echo $search;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COMP3421 Final Project</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./user_list.css">

</head>
<body>
    <div>
        <section class="user-page">

            <!-- User Account Information -->
            <div class="account">
                <div class="account-info">
                    <img src="./img/people.jpg" alt="Mary" class="image-icon">
                    <div class="content">
                        <span><?php echo $_SESSION['username']?></span>
                        <p><i class="fa fa-circle" id="my-status-indicator"></i> &nbsp Active</p>
                    </div>
                </div>
                <a id="logout-button" href="/logout.php">Logout</a> 
            </div>

            <!-- Search -->
            <form class="search" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="text" placeholder="Enter name to search...." name="search" value="<?php echo isset($search)?$search:""; ?>">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>

            <!-- Friend Account Information -->
            <div class="user-list">
                <!-- <div class="account">
                    <div class="account-info">
                        <img src="./img/peter.jpg" alt="Peter" class="image-icon">
                        <div class="content">
                            <span>Peter Lam</span>
                            <p>Professional Photographer</p>
                        </div>
                    </div>
                    <i class="fa fa-circle" style="color:green;font-size: 12px;"></i>
                </div> -->
            
                <?php
                    // Prepare a select statement
                    $sql = "SELECT id, username FROM users WHERE id != ?";

                    if($stmt = mysqli_prepare($link, $sql)){
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt, "i", $param_id);

                        $param_id = $_SESSION['id'];

                        if(mysqli_stmt_execute($stmt)){
                            mysqli_stmt_store_result($stmt);
                            mysqli_stmt_bind_result($stmt, $id, $username);
                            $number_of_list = mysqli_stmt_num_rows($stmt);

                            $counter = 0;
                            for($x = 0; $x < $number_of_list; $x++){
                                if(mysqli_stmt_fetch($stmt)){
                                    if(empty($search) || str_contains($username, $search)){
                                        $counter += 1;
                                        echo 
                                        '<div class="account">
                                            <div class="account-info">
                                                <img src="./img/peter.jpg" alt="'.$username.'" class="image-icon">
                                                <div class="content">
                                                    <span>'.$username.'</span>
                                                    <p>'."New user. Hi!".'</p>
                                                </div>
                                            </div>
                                        </div>';
                                    }
                                }
                            }

                            if ($counter == 0){
                                echo "No user is found!";
                            }
                        }
                    }

                    mysqli_stmt_close($stmt);

                ?>
            </div>    
        </section>
    </div>
</body>
</html>
