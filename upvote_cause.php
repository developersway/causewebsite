<?php 

$conn = mysqli_connect('localhost','root','','causeWebsite');

session_start();
$login = isset($_SESSION['login'])? $_SESSION['login'] : 0;
$id = isset($_SESSION['id'])? $_SESSION['id'] : 0;
$userId = isset($_SESSION['userId'])? $_SESSION['userId'] : 0;
$fullname = isset($_SESSION['fullname'])? $_SESSION['fullname'] : "";


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
    <link rel='stylesheet' href='styles/site.css?version=10'>
    <link rel="stylesheet" href="./styles/w3.css">

    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <title>Document</title>
</head>
<body>

    
    <section class='upper_body'>
        <div class='nav_bar'>
            <div class='right_nav'>
                <span class='search'>
                    <button class='cross_search'><i class="fa fa-times" aria-hidden="true"></i></button>
                    <input type='text' placeholder='Search by Cause Title'>
                    <button>Search</button>
                </span>
                <i class='fa fa-bell notification_icon' arial-hidden='true'></i>
                <i class='fa fa-bell res_notification_icon' arial-hidden='true'></i>
                <a href='./profile.php'><i class='fa fa-user' arial-hidden='true'></i></a>
                <i class="fa fa-bars active" id='active' aria-hidden="true"></i>
            </div>

            <div class='left_nav' id='nav_display1'>
                <a href='./home.php'><div>Home</div></a>
                <a href='./my_causes.php'><div>Causes</div></a>
                <div class='nav_create_cause'>Create Cause</div>
                <a href='./logout.php'><div>Logout</div></a>                
            </div>

            <div class='resp_search'>
                    <button class='resp_cross_search'><i class="fa fa-times" aria-hidden="true"></i></button>
                    <input type='text' placeholder='Search by Cause Title'>
                    <button>Search</button>
            </div>
        </div>
    </section> 

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
                            <h5><i><?=$data['date']?></i></h5>   
                            <div style='font-weight : 900'><?=$data['text']?></div>
                        </a>
                    <?php }else{?>
                        <a style='text-decoration : none' href='./store.php?form=redirect&id=<?=$data['id']?>&type=<?=$data['type']?>&causeId=<?=$data['causeId']?>'>
                            <h5><i><?=$data['date']?></i></h5>   
                            <div><?=$data['text']?></div>
                        </a>
                    <?php }?>

                </div>

                    <?php }    }?>

            </div>
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
                            <h5><i><?=$data['date']?> </i><i class="fa fa-circle" style="font-size:12px;color:green"></i></h5>
                            <div style='font-weight : 900'><?=$data['text']?></div>
                        </a>
                    <?php }else{?>
                        <a style='text-decoration : none' href='./store.php?form=redirect&id=<?=$data['id']?>&type=<?=$data['type']?>&causeId=<?=$data['causeId']?>'>
                            <h5><i><?=$data['date']?></i></h5>   
                            <div><?=$data['text']?></div>
                        </a>
                    <?php }?>

                </div>

                    <?php }    }?>



            </div>


    <?php 
        $select = "SELECT * FROM `causes` WHERE `id` = $id";
        $row = $conn->query($select);
        if($row->num_rows>0)
        {
            $data = $row->fetch_assoc();

            $string = $data['signed'];
            $array = explode("-",$string);
            
            $res = array_search($_SESSION['fullname'],$array);
            if($res===0)
                $res = 1;
    ?>
    <section class='upvote_lower_body'>

        

        <div class='upvote_cause_entire_container'>
            <div class='upvote_cause_img'>
                <div><img src='<?=$data['causeImage']?>'></div>

                <?php if(!$res){?>
                    <div class='upvote_button'>
                        <form action='./store.php' method='get'>
                            <input type='hidden' name='form' value='upvote'>
                            <input type='hidden' name='string' value='<?=$data['signed']?>'>
                            <button type='submit'>Upvote</button>
                        </form>
                    </div>
                <?php }else{ ?>
                    <div class='upvote_button'>
                        <form action='./store.php' method='get'>
                            <input type='hidden' name='form' value='upvoted'>
                            <input type='hidden' name='string' value='<?=$data['signed']?>'>
                            <button type='submit' style='background-color : green'>Upvoted</button>
                        </form>
                    </div> 
                <?php }?>

            </div>   
            <div class='upvote_text'>
                <div class='upvote_title'><?=$data['causeTitle']?></div>
                <div class='upvote_desc'><?=$data['causeDescription']?></div>
            </div> 
            
        </div>
    
        

        
    </section>

    <section class='resp_upvote_lower_body'>
        <div class='resp_upvote_cause_entire_container'>
            <div class='media_upvote_title'><?=$data['causeTitle']?></div>
            <div><img src='<?=$data['causeImage']?>'></div>
            <div class='media_upvote_desc'><?=$data['causeDescription']?></div>

            <?php if(!$res){?>
                    <div class='upvote_button'>
                        <form action='./store.php' method='get'>
                            <input type='hidden' name='form' value='upvote'>
                            <input type='hidden' name='string' value='<?=$data['signed']?>'>
                            <button type='submit'>Upvote</button>
                        </form>
                    </div>
                <?php }else{ ?>
                    <div class='upvote_button'>
                        <form action='./store.php' method='get'>
                            <input type='hidden' name='form' value='upvoted'>
                            <input type='hidden' name='string' value='<?=$data['signed']?>'>
                            <button type='submit' style='background-color : green'>Upvoted</button>
                        </form>
                    </div> 
            <?php }?>

        </div>

    </section>

    <?php } ?>

    <!--_____________________________________________________Modal__________________________________________________________________________-->

            <div class="w3-container">
                  <div  class="w3-modal class01">
                    <div class="w3-modal-content w3-card-4 w3-animate-zoom" id='modal_create_cause'>
                
                        <div class="w3-center" ><br>
                        <span class="w3-button w3-xlarge w3-hover-red w3-display-topright cross" title="Close Modal">&times;</span>
                        
                        </div>
                
                        <form class="w3-container" action="./upvote_cause.php" method='post' enctype="multipart/form-data">
                        <div class="w3-section">
                            <label><b>Title</b></label>
                            <input style='width: 99%;' class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Give your cause a title." name="title" required>
                            <label><b>Description</b></label>
                            <textarea style='width: 99%;' class="w3-input w3-border w3-margin-bottom" rows='6' column='30' name='description' placeholder='Brief your cause...'></textarea>
                            <label><b>Upload your image</b></label><br>
                            <input type='file' name='filetoupload' required>
                            <button class="w3-button w3-block w3-section w3-padding" style='background-color: #2e3f51;color: white' type="submit">Create Cause</button>
                         </div>   
                            
                        </form>
                
                        
                
                    </div>
                </div>
             </div>

    <!------------------------------------------------------Upvote_cause------------------------------------------------------------------------->

           <!-- <div class="w3-container">
                <div class="w3-modal upvote_modal">
                <div class="w3-modal-content w3-card-4 w3-animate-zoom" id="upvote_modal_confirm" >
            
                    <div class="w3-center" ><br>
                    <span class="w3-button w3-xlarge w3-hover-red w3-display-topright cross" title="Close Modal">&times;</span>
                    
                    </div>
            
                    <div class='sign_confirmed'>Great! You signed this Cause.</div>
            
                    
            
                </div>
                </div>
            </div> -->
</body>
</html>
<script src='scripts/self_jquery.js?version=11'></script>


<?php

    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        $directory = "images/causeImage/";
        $fileName = $_FILES['filetoupload']['name'];
        $path = $directory.$fileName;

        $x = move_uploaded_file($_FILES['filetoupload']['tmp_name'],$path);


        $title = isset($_POST['title'])? $_POST['title'] : "";
        $description = isset($_POST['description'])? $_POST['description'] : "";

        $insert = "INSERT INTO `causes` (`userId`,`fullname`,`causeImage`,`causeTitle`,`causeDescription`,`status`)
                    VALUES('$userId','$fullname','$path','$title','$description',1)";


        echo $userId;
        $conn->query($insert);

        $update = "UPDATE `users` SET `totalCause`=totalCause+1 WHERE userId='$userId'";
        $conn->query($update);

        $_SESSION['totalCause'] = $_SESSION['totalCause']+1;


        //echo $fileName;
        if(!$x)
            echo "Failed";

       
    }

?>