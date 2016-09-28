<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="styleSheet.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet'  type='text/css'>
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>

<title> Daisy's Playground </title>

</head>
<body>
<center>
<h1> Daisy's Playground </h1>
    </center>
<form>


</form>
<?php

require 'database.php';

$database = new Database;
$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);


if(@$_POST['delete']){
    $delete_id = $_POST['delete_id'];
    $database->query('DELETE FROM posts WHERE id = :id');
    $database->bind(' :id',$delete_id);
    $database->execute();
}
if(@$post['update']){
    $id = $post['id'];
    $title = $post['title'];
    $body = $post['body'];

    $database->query('UPDATE posts SET title :title, body = :body WHERE id =:id');
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
        echo '<h3> Your post has been added :-) </h3>';
    }
}

$database->query('SELECT * FROM posts');
$rows = $database->resultset();
?>
</body>

</html>
