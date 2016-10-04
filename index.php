<head xmlns="http://www.w3.org/1999/html">

    <link rel="stylesheet" type="text/css" href="root/styleSheet.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
</head>

<title> Daisy's World </title>


<?php

require 'database.php';

$database = new Database;
$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);


// $database->query('SELECT * FROM posts');
// $rows = $database->resultset();
//print_r($rows);

if(@$_POST['delete']){
    $delete_id = $_POST['delete_id'];
    $database->query('DELETE FROM posts WHERE id = :id');
    $database->bind(':id', $delete_id);
    $database->execute();
}

if(@$post['update']){
    $id = $post['id'];
    $title = $post['title'];
    $body = $post['body'];

    $database->query('UPDATE posts SET title = :title, body = :body WHERE id = :id');
    $database->bind(':title', $title);
    $database->bind(':body', $body);
    $database->bind(':id', $id);
    $database->execute();
}

if(@$post['submit']){
    $title = $post['title'];
    $body = $post['body'];

    $database->query('INSERT INTO posts (title, body) VALUES(:title, :body)');
    $database->bind(':title', $title);
    $database->bind(':body', $body);
    $database->execute();
    if($database->lastInsertId()){
        echo '<p>Post Added!</p>';
    }
}

$database->query('SELECT * FROM posts');
$rows = $database->resultset();

?>
<body>

<center>
<h1 style="color: black; font-size: 60px"> Daisy's World </h1>
    </center>

<!--<div data-role="page" id="pageone">-->
    <div data-role="header">
        <br>
<center>
     <a href="index.php" style="color: white;transition: color 5s"> HOME </a> <a href="about.php" style="color: white"> ABOUT</a>
</center>
    <br>

    </div>

    </div>


<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
<br>

    <label style=" font-family: 'American Typewriter';">Post ID </label><br />
    <input type="text" name="id" placeholder="Specify ID" /><br /><br />

    <label style="font-family: 'American Typewriter'">Post Title</label><br />
    <input type="text" name="title" placeholder="Add a Title..." /><br /><br />

    <label style="font-family: 'American Typewriter'">Post Body</label><br />
    <textarea name="body" placeholder=" What would you like to say?"></textarea><br /><br />

    <center>
    <div id="submit">
     <input type="submit" name="submit" value="Submit" />
</div>

    </center>
</form>

 <center>
<h1 style="color: black; font-family:'Arial Black'; font-weight: bold; font-size: 40px"> Recent Posts </h1>
</center>

<center>
    <div>
    <?php foreach($rows as $row) : ?>
    <h3><?php echo $row['title']; ?></h3>
    <p><?php echo $row['body']; ?></p>
   <?php   include ("footer.php")?>
    <br />


    <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
        <input type="submit" name="delete" value="Delete" />
    </form>

</div>
</center>
<?php endforeach; ?>
</div>
</body>