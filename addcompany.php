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
    }
    if(isset($_POST['cancel']))
    {
        header("Location: home.php");
        return;
    }*/

    if(isset($_POST['add_co']) )
    {        
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM company WHERE Company_name = :cn');
        $stmt->execute(array(':cn' => $_POST['co_name']));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row['COUNT(*)'] !== '0')
        {
            $_SESSION['error'] = "This Company already exists";
            header('Location: addcompany.php');
            return;
        }
        else
        {
            $stmt = $pdo->prepare('INSERT INTO company (Company_name,Domain,Owner,City,Country,Est) VALUES (:Company_Name,:Domain,:Owner,:City,:Country,:Establishment)');
			$stmt->execute(array(':Company_Name' => $_POST['co_name'], ':Domain' => $_POST['domain'], ':Owner' => $_POST['owner'], ':City' => $_POST['city'], ':Country' => $_POST['country'], ':Establishment' => $_POST['est']));
            $_SESSION['success'] = "Company Added Successfully";
            header('Location: home.php');
            return;
        }
    }    
?>
<html>
<head>
    <title>Machine Tracking</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
    <?php if (isset($_SESSION['id'])&&$_SESSION['role']=='0') include "navbar.php"; 
                else if(isset($_SESSION['id'])&&$_SESSION['role']=='1')  include "navbar_faculty.php";
                else include "navbar_tech.php";?>
      <div class="container-fluid row" id="content">
        <div class="page-header">
        <h1>ADD COMPANY</h1>
        </div>
        <div id="error" style="color: red; margin-left: 90px; margin-bottom: 20px;">
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
        <div class="col-xs-5">
        <form method="POST" action="addcompany.php">

        <div class="input-group">
        <span class="input-group-addon">Company Name </span>
        <input type="text" name="co_name" required class="form-control" placeholder="Company_Name" id="depname" onchange="Names('depname')" required> </div><br/>
		
		<div class="input-group">
        <span class="input-group-addon">Domain </span>
        <input type="text" name="domain" required class="form-control" placeholder="Domain" id="depname" onchange="Names('depname')" required> </div><br/>
		
		<div class="input-group">
        <span class="input-group-addon">Owner </span>
        <input type="text" name="owner" required class="form-control" placeholder="Owner" id="depname" onchange="Names('depname')" required> </div><br/>
		
		<div class="input-group">
        <span class="input-group-addon">City </span>
        <input type="text" name="city" required class="form-control" placeholder="City" id="depname" onchange="Names('depname')" required> </div><br/>
		
		<div class="input-group">
        <span class="input-group-addon">Country </span>
        <input type="text" name="country" required class="form-control" placeholder="Country" id="depname" onchange="Names('depname')" required> </div><br/>
		
		<div class="input-group">
        <span class="input-group-addon">Establishment </span>
        <input type="text" name="est" required class="form-control" placeholder="Establishment" id="depname" onchange="Names('depname')" required> </div><br/>

        <input type="submit" value="Add Company" name="add_co"class="btn btn-info">
        <a class ="link-no-format" href="home.php"><div class="btn btn-my">Cancel</div></a>
        </form>

    </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>