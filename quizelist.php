<?php 
session_start();
include("database.php");
extract($_GET);

?>

<!DOCTYPE >
<html>
<head>
<title> Quiz</title>
<link rel="stylesheet" href="style.css" />
</head>
<body>
<h1>Quiz List</h1>
<?php

$rowQ=mysqli_query($con,"select * from quiz");

//fetch one row from group of result
echo "<div class='listST'>";
echo"<ul>";

while($row=mysqli_fetch_row($rowQ)){
    //Assign id of quiz to quiz_id variable 
    //Also,Passing Quiz Id through href
    echo"<li><a href=showQuiz.php?quiz_id=$row[0]> $row[1] </a></li>";

}
echo"</div>";
echo"</ul>";
?>
<script type="text/javascript"
    id="botcopy-embedder-d7lcfheammjct"
    class="botcopy-embedder-d7lcfheammjct" 
    data-botId="602d769cd23ea5000830a75a"
>
    var s = document.createElement('script'); 
    s.type = 'text/javascript'; s.async = true; 
    s.src = 'https://widget.botcopy.com/js/injection.js'; 
    document.getElementById('botcopy-embedder-d7lcfheammjct').appendChild(s);
</script>
</body>
</html>

