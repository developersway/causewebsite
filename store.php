<?php
$conn = mysqli_connect('localhost','root','','causeWebsite');

$form = isset($_GET['form'])? $_GET['form'] : "";



switch($form)
{
    case 'sign_up':
        $fullname = isset($_GET['fullname'])? $_GET['fullname'] : "";
        $email = isset($_GET['email'])? $_GET['email'] : "";
        $password = isset($_GET['password'])? $_GET['password'] : "";

        $insert = "INSERT INTO `users` (`fullname`,`email`,`password`,`status`) VALUES('$fullname','$email','$password',1)";
        $conn->query($insert);
        header('location:./index.php');
    break;

    case 'login':
        $email = isset($_GET['email']) ? $_GET['email'] : "";
        $password = isset($_GET['password']) ? $_GET['password'] : "";

        $select = "SELECT * FROM `users`WHERE `email`='$email' AND `password`='$password'";
        
        $row = $conn->query($select);
        
        if($row->num_rows>0)
        {
            $data = $row->fetch_assoc();
            session_start();
            $_SESSION['login'] = 1;
            $_SESSION['userId'] = $data['userId'];
            $_SESSION['fullname'] = $data['fullname'];
            $_SESSION['loginId'] = $data['email'];
            $_SESSION['profileImage'] = $data['image'];
            $_SESSION['totalCause'] = $data['totalCause'];



            $_SESSION['search'] = "";
            $userId =$_SESSION['userId'];
            $name = $data['fullname'];
            $date = date("Y-m-d");

            $notification_select = "SELECT * FROM `notification` WHERE `userId` = '$userId' ";
            $notification_row = $conn->query($notification_select);

            if($notification_row->num_rows>0)
            {
                
            }
            else{
                $insert = "INSERT INTO `notification` (`userId`,`causeId`,`text`,`date`,`type`,`read`,`status`)
                         VALUES('$userId','0','Welcome $name to the Cause Website.Tap on any cause to upvote it','$date','1','0','1')";
                
                $conn->query($insert);

                
                $insert = "INSERT INTO `notification` (`userId`,`causeId`,`text`,`date`,`type`,`read`,`status`)
                        VALUES('$userId','0','Create Your First Cause Today','$date','2','0','1')";
                $conn->query($insert);

                
            }

            header('location:./home.php');
        }
        else
        {
            ?><script>
                alert('Invalid Credentials');
                window.location.href='./index.php';
            </script><?php

        }
    break;

    case 'causeView':

        $id = isset($_GET['id'])?$_GET['id'] : 0;
        session_start();
        $_SESSION['id'] = $id;
        header('location:./upvote_cause.php');
    break;


    case 'upvote':
        session_start();
        $id = isset($_SESSION['id'])? $_SESSION['id'] : 0;
        $string = isset($_GET['string'])? $_GET['string'] : "";
        $array = explode("-",$string);
        if($string == "")
            $array = [];
        array_push($array,$_SESSION['fullname']);
        $string = implode("-",$array);
        //echo $string;

        $update = "UPDATE `causes` SET `signed` = '$string' WHERE `id` = '$id'";
        if($conn->query($update))
        {

        }
        else 
            echo $conn->error;

        $fullname = $_SESSION['fullname'];
        $date = date("Y-m-d");

        $select ="SELECT * FROM `causes` WHERE `id` = '$id'";
        $row = $conn->query($select);

        if($row->num_rows>0)
        {
            $data = $row->fetch_assoc();
            $userId = $data['userId'];
            echo $userId;
        }

        $insert = "INSERT INTO `notification` (`userId`,`causeId`,`text`,`date`,`type`,`read`,`status`)
        VALUES('$userId','$id','$fullname has signed your cause','$date','3','0','1')";
   
        $conn->query($insert);


        header('location:./upvote_cause.php');        
        
    break;

    case 'upvoted':
        session_start();
        $id = isset($_SESSION['id'])? $_SESSION['id'] : 0;
        $string = isset($_GET['string'])? $_GET['string'] : "";
        $array = explode("-",$string);

        $array1 = [];
        for($i=0;$i<count($array);$i++)
        {
            if($array[$i] == $_SESSION['fullname'])
                $i++;
            
            if($i>=count($array))
                break;

            array_push($array1,$array[$i]);
        }

        $string = implode("-",$array1);
        

        $update = "UPDATE `causes` SET `signed` = '$string' WHERE `id` = '$id'";
        if($conn->query($update))
        {

        }
        else 
            echo $conn->error;

        header('location:./upvote_cause.php');        
        
    break;

    case 'search_home':
        $text = isset($_GET['search'])? $_GET['search'] : "";
        $url = isset($_GET['url'])? $_GET['url'] : "";
        session_start();
        $_SESSION['search'] = 1;
        $_SESSION['search_text'] = $text;
        header('location:./home.php');
    break;
        
    case 'search_disable_home':
        $url = isset($_GET['url'])? $_GET['url'] : "";
        session_start();
        $_SESSION['search'] = 0;
        header('location:./home.php');
    break;

    case 'search_my_causes':
        $text = isset($_GET['search'])? $_GET['search'] : "";
        $url = isset($_GET['url'])? $_GET['url'] : "";
        session_start();
        $_SESSION['search'] = 1;
        $_SESSION['search_text'] = $text;
        header('location:./my_causes.php');
    break;
        
    case 'search_disable_my_causes':
        $url = isset($_GET['url'])? $_GET['url'] : "";
        session_start();
        $_SESSION['search'] = 0;
        header('location:./my_causes.php');
    break;

    case 'redirect':
        $type = isset($_GET['type'])? $_GET['type'] : "";
        $id = isset($_GET['id'])? $_GET['id'] : "";
        $causeId = isset($_GET['causeId'])? $_GET['causeId'] : 0;


        $update = "UPDATE `notification` SET `read` = 1 WHERE `id` =$id";
        $conn->query($update);

        if($type==1)
            header('location:./home.php');

       if($type==2)
            header('location:./my_causes.php');
        
        if($type==3)
        {
            session_start();
            $_SESSION['id'] = $causeId;
            header('location:./upvote_cause.php');
        }

        echo $type;

    break;

    case 'delete':
        $id = isset($_GET['id'])?$_GET['id']: 0;
        session_start();
        $userId = isset($_SESSION['userId'])? $_SESSION['userId'] : 0;
        
        $update = "UPDATE `causes` SET `status` = 0 WHERE `id` = $id";
        $conn->query($update);

        $update = "UPDATE `users` SET `totalCause`=totalCause-1 WHERE `userId`='$userId'";
        $conn->query($update);



        session_start();
        $_SESSION['totalCause'] = $_SESSION['totalCause']-1;

        header('location:./my_causes.php');
    break;



    default:
       // header('location:./home.php');
}

?>