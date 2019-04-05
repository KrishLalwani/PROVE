<?php
    session_start();
    require_once "pdo.php";
    if ( ! isset($_SESSION['id']) || ! isset($_SESSION['teacher']))
    {
        die('ACCESS DENIED');
    }
    if ( isset($_POST['cancel']) )
    {
        header('Location: teacherin.php');
        return;
    }
    if ( isset($_POST['title']))
    {
        if ( strlen($_POST['title'])<1)
        {
            $_SESSION['error'] = "All fields are required";
            header("Location: addassignment.php?assignment_id=" . $_POST["assignment_id"]);   //See for get parameter
            return;
        }

    }

    //For Position
    for($i=1; $i<=50; $i++)
    {

        if ( ! isset($_POST['word_limit'.$i]) ) continue;

        if ( ! isset($_POST['desc'.$i]) ) continue;
        $word_limit = $_POST['word_limit'.$i];
        $desc = $_POST['desc'.$i];

        if ( strlen($word_limit) == 0 || strlen($desc) == 0 )
        {

            $_SESSION['error'] = "All fields are required";
            header("Location: addassignment.php?assignment_id=" . $_POST["assignment_id"]);
            return;
        }

        if ( ! is_numeric($word_limit) )
        {

            $_SESSION['error'] = "word_limit must be numeric";
            header("Location: addassignment.php?assignment_id=" . $_POST["assignment_id"]);
            return;
        }

    }

    if ( isset($_POST['title']) && isset($_POST['branch']) && isset($_POST['sem']))
    {
        $stmt = $pdo->prepare('INSERT INTO assignment
            (teacher_id, title, branch, sem)
            VALUES ( :tid, :title, :branch, :sem)');
            $stmt->execute(array(
            ':tid' => $_SESSION['id'],
            ':title' => $_POST['title'],
            ':branch' => $_POST['branch'],
            ':sem' => $_POST['sem'])
            );

    $assignment_id = $pdo->lastInsertId();
    //$rank =1;

    for($i=1; $i<=50; $i++)
    {
        if ( ! isset($_POST['word_limit'.$i]) ) continue;

        if ( ! isset($_POST['desc'.$i]) ) continue;

        $stmt = $pdo->prepare('INSERT INTO question

            (assignment_id, description, word_limit)

            VALUES ( :aid, :desc, :word_limit)');

            $stmt->execute(array(

            ':aid' => $assignment_id,

            ':desc' => $_POST['desc'.$i],

            ':word_limit' => $_POST['word_limit'.$i])

            );

            //$rank++;
    }

    $_SESSION['success']="Assignment added";
    header("Location: teacherin.php");
    return;
    }

?>

<html>
<head>
    <title>foxy.</title>
    <link rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
    integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
    crossorigin="anonymous">

    <link rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"
    integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r"
    crossorigin="anonymous">

    <link rel="stylesheet"
    href="https://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css">

    <script
    src="https://code.jquery.com/jquery-3.2.1.js"
    integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
    crossorigin="anonymous"></script>

    <script
    src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
    integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30="
    crossorigin="anonymous"></script>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width = device-width, initial-scale = 1">

    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >

    <style>
        .input-group-addon {
        min-width:150px;
        text-align:left;
    }
    </style>
</head>
<body>
    <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="teacherin.php"><b>foxy.</b></a>
    </div>
    <ul class="nav navbar-nav navbar-right">
      <?php
            echo("<li><span class=\"navbar-brand\">Hello ".htmlentities($_SESSION['first_name'])." ".htmlentities($_SESSION['last_name'])." </span></li>");
        ?>
        <li><span class="navbar-brand"><a href="logout.php">Logout</a> </span></li>
    </ul>
    </div>
    </nav>

    <div class="container">
    <div class="page-header">
    <?php
    if ( isset($_SESSION['id']) )
    {
        echo "<h1>Create New Assignment ";
        echo "</h1></div>\n";
    }
    if ( isset($_SESSION['error']))
    {
        echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
        unset($_SESSION['error']);
    }
    ?>

    <form method="post">
    <div class="input-group">
    <span class="input-group-addon">Title</span>
    <input type="text" name="title" size="60" class="form-control"/> </div><br/>
    <div class="input-group">
    <span class="input-group-addon">Branch</span>
    <select name="branch" class="form-control">
        <option value="CSE">CSE</option>
        <option value="CE">CE</option>
        <option value="EC">EC</option>
        <option value="EE">EE</option>
        <option value="AU">AU</option>
        <option value="EEE">EEE</option>
        <option value="IT">IT</option>
        <option value="ME">ME</option>
        <option value="FT">FT</option>
    </select>
    </div><br>
    <div class="input-group">
    <span class="input-group-addon">Semester</span>
    <select name="sem" class="form-control">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
    </select>
    </div><br>
    <p>
    Questions: <input type="submit" id="addQue" value="+">
    <div id="question_fields">
    </div>
    </p>
    <input type="submit" value="Add" class="btn btn-info">
    <input type="submit" name="cancel" value="Cancel" class="btn btn-info">
    </p>
    </form>

<script>
countQue = 0;

// http://stackoverflow.com/questions/17650776/add-remove-html-inside-div-using-javascript
$(document).ready(function(){
    window.console && console.log('Document ready called');

    $('#addQue').click(function(event){
        // http://api.jquery.com/event.preventdefault/
        event.preventDefault();
        if ( countQue >= 50 ) {
            alert("Maximum of 50 position entries exceeded");
            return;
        }
        countQue++;
        window.console && console.log("Adding position "+countQue);
        $('#question_fields').append(
            '<div id="question'+countQue+'"> \
            <p>Word Limit: <input type="text" name="word_limit'+countQue+'" value="" /> \
            <input type="button" value="-" onclick="$(\'#question'+countQue+'\').remove();return false;"><br>\
            <textarea name="desc'+countQue+'" rows="8" cols="80"></textarea>\
            </div>');
    });

});

</script>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>