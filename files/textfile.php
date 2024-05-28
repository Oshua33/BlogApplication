<?php
if (isset($_FILES['file']))
{
$file_name = $_FILES['file']['name'];
$tmp_name = $_FILES['file']['tmp_name'];
$location = "images/";
$b = move_uploaded_file($tmp_name, $location.$file_name);
if ($b == 1)
{
    echo "files uploaded <br>";
} else 
{
    echo "failed<br>";
}
}
?>

<html>
    <form method="post" enctype="multipart/form-data"> 
        <input type="file" name="file" id="file" >
        <input type="submit" value="upload">
    </form>
</html>