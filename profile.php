<?php 
    $conn = mysqli_connect('localhost','root','','causeWebsite');

    session_start();
    $login = isset($_SESSION['login'])? $_SESSION['login'] : 0;
    $userId = isset($_SESSION['userId'])? $_SESSION['userId'] : 0;
    $fullname = isset($_SESSION['fullname'])? $_SESSION['fullname'] : "";
    $loginId = isset($_SESSION['loginId'])? $_SESSION['loginId'] : "";
    $search = isset($_SESSION['search'])? $_SESSION['search'] : 0;
    $totalCause = isset($_SESSION['totalCause'])? $_SESSION['totalCause'] : 0;



    

    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        $directory = "images/profileImage/";
        $fileName = $_FILES['filetoupload']['name'];
        $path = $directory.$fileName;
        $x = move_uploaded_file($_FILES['filetoupload']['tmp_name'],$path);


        $update = "UPDATE `users` SET `image`='$path' WHERE `userId` = '$userId'";
        $conn->query($update);
        
        $_SESSION['profileImage'] = $path;

        //echo $fileName;
        if(!$x)
            echo "Failed";
        
        header('location:./profile.php');

       
    }



    

    //echo $search_text;

    if($login == 0)
        header('location:./index.php');


    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <link rel="stylesheet" href="styles/site.css?version=<?php echo (rand(10,99));?>">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <title>Document</title>
</head>



<body >

     
    <section class='upper_body'>
        <div class='nav_bar'>
        <div class='right_nav'>
                <span class='notification_icon'>
                    <i class='fa fa-bell ' arial-hidden='true'>
                    <?php 
                        $select = "SELECT * FROM `notification` WHERE `read` = 0 AND `userid` = $userId";
                        $row = $conn->query($select);
                        if($row->num_rows>0){
                    ?>
                    <span class="dot1">.</span> <?php }?>
                </span></i>
                <span class='res_notification_icon'>
                    <i class='fa fa-bell ' arial-hidden='true'>
                    <?php 
                        $select = "SELECT * FROM `notification` WHERE `read` = 0 AND `userid` = $userId";
                        $row = $conn->query($select);
                        if($row->num_rows>0){
                    ?>
                    <?php }?>
                </span></i>
                <a href='./profile.php'><i class='fa fa-user' arial-hidden='true'></i></a>
                <i class="fa fa-bars active" id='active' aria-hidden="true"></i>
            </div>

            <div class='left_nav' id='nav_display1'>
                <a href='./home.php'><div>Home</div></a>
                <a href='./my_causes.php'><div>Causes</div></a>
                <a href='./logout.php'><div>Logout</div></a>                

            </div>

            
        </div>
    </section>    

    <section class='profile_section' style='box-sizing:initial'>

        <div class='profile_view'>
                    <div class='res_notification_display'>

                <?php 
                    $select = "SELECT * FROM `notification` WHERE `userId` = '$userId' ORDER BY `id` desc";
                    $row = $conn->query($select);

                    if($row->num_rows>0){
                        while($data = $row->fetch_assoc()){
                            
                ?>

                <div class='notification_column'>
                    <?php if($data['read']==0){?>
                        <a style='text-decoration : none' href='./store.php?form=redirect&id=<?=$data['id']?>&type=<?=$data['type']?>&causeId=<?=$data['causeId']?>'>
                            <h5 style='font-size : small'><i><?=$data['date']?> </i><i class="fa fa-circle" style="font-size:12px;color:green"></i></h5>
                            <div style='font-weight : 900'><?=$data['text']?></div>
                        </a>
                    <?php }else{?>
                        <a style='text-decoration : none' href='./store.php?form=redirect&id=<?=$data['id']?>&type=<?=$data['type']?>&causeId=<?=$data['causeId']?>'>
                            <h5 style='font-size : small'><i><?=$data['date']?></i></h5>   
                            <div><?=$data['text']?></div>
                        </a>
                    <?php }?>

                </div>

                    <?php }    }?>

            </div>

            <h3 style='color : white;text-align: center;'>Your Profile</h3>

            <div class='profile_view_section'>
                <?php if($_SESSION["profileImage"]==""){?>
                    <img src='./images/generalImage.jpg'>
                <?php }else{?>
                    <img src='<?=$_SESSION["profileImage"]?>'>
                <?php }?>
                <form action='./profile.php' method='post' style='margin-left : 30%;' enctype="multipart/form-data"> 
                    <input type='file' name='filetoupload'>
                    <button style='margin-left : 20%' type="submit">Upload</button>
                </form><br>
                <div>Full Name :- <?=$fullname?></div><br>
                <div>Login id :- <?=$loginId?></div><br>
                <div>Total Cause Created :- <?=$totalCause?></div>
            </div>
        </div>


        <div class='other_profiles'>
            <div class='notification_display' style='right : 10px'>
                <?php 
                    $select = "SELECT * FROM `notification` WHERE `userId` = '$userId' ORDER BY `id` desc";
                    $row = $conn->query($select);

                    if($row->num_rows>0){
                        while($data = $row->fetch_assoc()){
                ?>
                <div class='notification_column'>
                    <?php if($data['read']==0){?>
                        <a style='text-decoration : none' href='./store.php?form=redirect&id=<?=$data['id']?>&type=<?=$data['type']?>&causeId=<?=$data['causeId']?>'>
                            <h5 style='font-size : small'><i><?=$data['date']?> </i><i class="fa fa-circle" style="font-size:12px;color:green"></i></h5>
                            <div style='font-weight : 900'><?=$data['text']?></div>
                        </a>
                    <?php }else{?>
                        <a style='text-decoration : none' href='./store.php?form=redirect&id=<?=$data['id']?>&type=<?=$data['type']?>&causeId=<?=$data['causeId']?>'>
                            <h5 style='font-size : small'><i><?=$data['date']?></i></h5>   
                            <div><?=$data['text']?></div>
                        </a>
                    <?php }?>

                </div>

                    <?php }    }?>
            </div>

            <h3 style='color : white;text-align: center;'>Other People On Cause Website</h3>
            
            <?php  
            $select = "SELECT * FROM `users` ";
            $table = $conn->query($select);
            if($table->num_rows > 0)
            {
                start:
                $i=0;
                ?><div class='card_container'> <?php
                while($data = $table->fetch_assoc())
                {
                    
            ?>
                
                    <div class='cause_card'>
                            <div class='cause_image'>
                                <div>
                                <?php if($data['image']==""){?>
                                            <img src='./images/generalImage.jpg'>
                                        <?php }else{?>
                                            <img src='<?=$data['image']?>'>
                                        <?php }?>
                                </div>
                            </div>
                            <div class='cause_text'>
                                <div class='cause_text_title'><?=$data['fullname']?></div>
                                <div class='cause_text_title'>Cause Created : <?=$data['totalCause']?></div>                                
                            </div>
                    </div>
                  
        <?php   $i++;
                if($i>2){ 
                    ?></div><?php
                    goto start; }
                }
            } else{
                ?>   
                    <style>           
                    .cause_entire_container{
                        width: 0;
                    }

                    .vertical_card_container
                    {
                        margin-top:20px;
                    }

                    </style>

                <?php
            }?>
                    
            </div>

        </div>
    </section>   

<!--______________________________________________________________________Modal_create_cause___________________________________________________________________--> 

               


                
</body>


    
</html>
<script src='scripts/self_jquery.js'></script>



