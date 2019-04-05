<?php
    session_start();
    require_once "pdo.php";

    if(isset($_POST['cancel']))
    {
        header("Location: index.php");
        return;
    }

    $salt='new_ton56*';

    if(isset($_POST['id']) && isset($_POST['pass']))
    {
		$dom=$_POST['dom'];
        unset($_SESSION['id']);
        if ( strlen($_POST['id']) < 1 || strlen($_POST['pass']) < 1 )
        {
            $_SESSION['error'] = "User name and password are required<br>";
            header('Location: index.php');
            return;
        }
        else
        {				
                $check = hash('md5', $salt.$_POST['pass']);
                $stmt = $pdo->prepare('SELECT * FROM member WHERE id = :id AND pass_word = :pw');
                $stmt->execute(array(':id' => $_POST['id'], ':pw' => $check));
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if($row !== false)
                {
                    $_SESSION['id'] = $row['member_id'];
                    $_SESSION['role'] = $row['role'];
					$co=$row['Company_id'];
                    header("Location: home.php");
                    return;
                }
                else
                {
                    $_SESSION['error'] = "Incorrect ID or Password<br>";
                    header("Location: index.php");
                    return;
                }				
				$stmt1 = $pdo->prepare('SELECT * FROM comapny WHERE Company_id =:co1');
                $stmt1->execute(array(':id' => $_POST['id'], ':pw' => $check,':co1'=>$co));
                $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                if($row1 !== false)
                {                  
					$domain=$row1['Domain'];
					if($domain==$dom)
                    header("Location: home.php");
                    return;
                }
                else
                {
                    $_SESSION['error'] = "Incorrect ID or Password or Domain<br>";
                    header("Location: index.php");
                    return;
                }
        }
    }
?>

<html>
<head>
    <title>PROVE</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="icon" type="image/png" href="favi.ico" />				
    <meta name="viewport" content="width = device-width, initial-scale = 1">

    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
    <link rel="stylesheet" type="text/css" href="style5.css">

    <style>
        .input-group-addon {
        min-width:150px;
        text-align:left;
    }
    </style>
</head>
<body>

    <div class="wrapper" id="add-nav">
    <?php include 'navbar_index.php';?>
    <h1>Machine Tracking</h1>
    </div>
    <?php
        if ( isset($_SESSION['error']) )
        {
            echo('<p style="color: red;">'.$_SESSION['error']."</p>\n");
            unset($_SESSION['error']);
        }
        if ( isset($_SESSION['success']))
        {
            echo('<p style="color: green;">'.$_SESSION['success']."</p>\n");
            unset($_SESSION['success']);
        }
    ?>
    <div class="row">

        <p class ="col-xs-12"style="font-size:22px">Log In</p><br>

            <form method="POST" action="index.php" class="col-xs-5">

                

                <div class="input-group">
                <span class="input-group-addon">ID</span>
                <input type="text" name="id" id="id" class="form-control" required placeholder="Enter your id">
                <br>
            </div>
			
            <br>
			<div class="input-group">
                <span class="input-group-addon">Domain</span>
                <input type="text" name="dom" id="id" class="form-control" required placeholder="Enter your Domain name">
				</div><br>
                <div class="input-group">
                <span class="input-group-addon">Password</span>
                <input type="password" name="pass" id="pass" class="form-control" required="" placeholder="Enter Password">
                <br>
            </div>
            <br>
            <input type="submit" value="Log In" class="btn btn-info">
			&nbsp<a class ="link-no-format" href="addcompany.php"><div class="btn btn-my">Add Company</div></a>
            </form>
        </div>
    </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
    </script>
</body>
</html>
