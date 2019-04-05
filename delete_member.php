<?php
    session_start();
    require_once "pdo.php";
    /*if( !isset($_SESSION['id']) )
    {
        die('ACCESS DENIED');
    }
    if( $_SESSION['role'] != '0' )
    {
        die('ACCESS DENIED');
    }*/
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
    <div class="wrapper">
	
    <?php 
		if (isset($_SESSION['mem']))  
		{	
			include "navbar.php";  
			$stmt = $pdo->prepare('SELECT COUNT(*) FROM department WHERE Member_id = :dn');
			$stmt->execute(array(':dn' => $_POST['id']));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if($row['COUNT(*)'] !== '0')
			{
				$_SESSION['error'] = "This Member does not exist";
				header('Location: delete_member.php');
				return;
			}
			else
			{
				$stmt = $pdo->prepare('delete from member where Member_id = :dn');
				$stmt->execute(array(':dn' => $_POST['id']));
				$_SESSION['success'] = "Member Removed Successfully";
				header('Location: home.php');
				return;
			}  			
		}
		else
			include "navbar_index.php";  ?>
		<div class="container-fluid row" id="content">
        <div class="page-header">
			<h1>REMOVE MEMBER</h1>
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

    <form method="POST" action="confirm_delete.php" class="col-xs-5">

    <div class="input-group">
    <span class="input-group-addon">Enter Id</span>
    <input type="text" required name="id" class="form-control" placeholder="Enter Member Id"> </div><br/>
    
    <input type="submit" value="Remove Member" name="mem" class="btn btn-info">
    <a class ="link-no-format" href="home.php"><div class="btn btn-my">Cancel</div></a>
    </form>

    </div>
    
    <script type="text/javascript" src="script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>