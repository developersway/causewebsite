<?php 
    $conn = mysqli_connect('localhost','root','','causeWebsite');

    session_start();
    $login = isset($_SESSION['login'])? $_SESSION['login'] : 0;
    $userId = isset($_SESSION['userId'])? $_SESSION['userId'] : 0;
    $fullname = isset($_SESSION['fullname'])? $_SESSION['fullname'] : "";
    $search = isset($_SESSION['search'])? $_SESSION['search'] : 0;



    if($login == 0)
        header('location:./index.php');


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


        
        $conn->query($insert);

        $update = "UPDATE `users` SET `totalCause`=totalCause+1 WHERE userId='$userId'";
        $conn->query($update);



        $_SESSION['totalCause'] = $_SESSION['totalCause']+1;


        //echo $fileName;
        if(!$x)
            echo "Failed";

    
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./styles/w3.css">

    <link rel='stylesheet' href='styles/site.css?version=<?php echo(rand(10,100));?>'>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <title>Document</title>
</head>

<?php
if($search==0)
        $_SESSION['search_text'] = "";
    else
    {
        //echo $search;
        ?><style>
            .search{
            display: block;
            }

            .search_icon{
                display : none;
            }

            @media only screen and (max-width: 600px) {

                .search{
                    display: none;
                }

                .resp_search{
                    display: block;
                }

                
            
            }
        


        </style><?php
    } 

    $search_text = isset($_SESSION['search_text'])? $_SESSION['search_text'] : "kk";

    ?>


<body>

    <section class='upper_body'>
        <div class='nav_bar'>
            <div class='right_nav'>
                <span class='search'>
                    <span style='display : flex;'>
                        <form action='./store.php' method='get'>
                            <input type='hidden' name='form' value='search_disable_my_causes'>
                            <button type='submit' class='cross_search'><i class="fa fa-times" aria-hidden="true"></i></button>
                        </form>
                        <form action='./store.php' method='get'>
                            <input type='text' name='search'value='<?=$search_text?>' placeholder='Search by Cause Title'>
                            <input type='hidden' name='form' value='search_my_causes'>
                            <button type='submit'>Search</button>
                        </form>
                    </span>
                </span>
                <i class='fa fa-search search_icon' arial-hidden='true'></i>
                <i class='fa fa-search resp_icon_search' arial-hidden='true'></i>
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
                    <span class="dot2">.</span> <?php }?>
                </span></i>
                <a href='./profile.php'><i class='fa fa-user' arial-hidden='true'></i></a>
                <i class="fa fa-bars active" id='active' aria-hidden="true"></i>
            </div>

            <div class='left_nav' id='nav_display1'>
                <a href='./home.php' ><div>Home</div></a>
                <div class='nav_color'>Causes</div>
                <div class='nav_create_cause'>Create Cause</div>
                <a href='./logout.php'><div>Logout</div></a>                
            </div>

            <div class='resp_search'>
                <span style='display : flex;width: 100%;'>
                    <form action='./store.php' method='get'>
                        <input type='hidden' name='form' value='search_disable_my_causes'>
                        <button class='resp_cross_search'><i class="fa fa-times" aria-hidden="true"></i></button>
                    </form>
                    <form action='./store.php' method='get' style='width: 100%;'>
                        <input type='text' name='search' placeholder='Search by Cause Title'>
                        <input type='hidden' name='form' value='search_my_causes'>
                        <button type='submit'>Search</button>
                    </form>
                </span>
            </div>
        </div>
    </section> 


    <section class='lower_body'>
        <div class='floating_button'><i class='fa fa-plus' arial-hidden='true'></i></div>
        <div class='my_causes_entire_container'>

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

            <h1 class='your_cause_text'>My Causes</h1>
                <?php 
                    $select = "SELECT * FROM `causes` WHERE `userId` = $userId AND `causeTitle` LIKE '%$search_text%' AND `status` = 1 ORDER BY `id` desc ";
                    $table = $conn->query($select);
                    if($table->num_rows > 0){
                    start:
                    $i=0;
                ?>
                <div class='my_cause_card_container'>

                    <?php 
                        
                            while($data = $table->fetch_assoc()){
                                $i++;
                    ?>
                    <div class='my_cause_card'>
                        <a href='./store.php?form=causeView&id=<?=$data["id"]?>'>

                            <div class='cause_image'>
                                <div><img src='<?php echo $data['causeImage']?>'></div>
                            </div>
                            <div class='cause_text'>
                                <div class='cause_text_title'><?php echo $data['causeTitle']?></div>
                               
                                <?php 
                                    $string = $data['signed'];
                                    $array = explode("-",$string);
                                    $length = count($array);
                                    $length = $length-1;
                                    if($string == ""){
                                ?>
                                    <div class='cause_footer' style='font-weight : bolder'>0 people have signed this.</div>
                                <?php }else{ ?>
                                    <div class='cause_footer' style='font-weight : bolder'><?php echo $array[$length] .  " and " . $length ." others upvoted this.";?></div>
                                <?php }?>
                                <br><form action='./store.php' method='get'>
                                    <input type='hidden' name='form' value='delete'>
                                    <input type='hidden' name='id' value='<?=$data['id']?>'>
                                    <button style='color : white;cursor : pointer; margin-left : 40%; background-color : red'>Delete</button>
                                </form>
                            </div>
                        </a>
                    </div>
                            <?php 
                            if($i>3){ ?></div><?php
                                goto start;}
                        }
                    }else{
                            ?>

                <div class='my_cause_card_container'><h1>No Cause Created Yet</h1>

                <?php 
                    } 
                ?>


                </div>
                
                
            

            
                <div class='my_cause_button'>
                    <button ><i class="fa fa-plus" aria-hidden="true"></i>Create Cause</button>
                </div>    
            
        </div> 

        
    </section>

    <!--_____________________________________________________Modal__________________________________________________________________________-->

            <div class="w3-container">
                  <div  class="w3-modal class01">
                    <div class="w3-modal-content w3-card-4 w3-animate-zoom" id='modal_create_cause'>
                
                        <div class="w3-center" ><br>
                        <span class="w3-button w3-xlarge w3-hover-red w3-display-topright cross" title="Close Modal">&times;</span>
                        
                        </div>
                
                        <form class="w3-container" action="./my_causes.php" method='post' enctype="multipart/form-data">
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

</body>

<script src='scripts/self_jquery.js?version=<?php echo(rand(10,100));?>'></script>
</html>


