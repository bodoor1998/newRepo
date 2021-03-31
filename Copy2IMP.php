<?php 
session_start();
include("database.php");
extract($_POST);
extract($_GET);
extract($_SESSION);

//$quiz_id coming  from GET ($_GET['quiz_id'])
if(isset($_GET['quiz_id']))
{
	
$_SESSION["QuizID"]=$_GET['quiz_id'];
header("location:showQuiz.php");
}

echo "<p>I'm here ooo" . $_SESSION["QuizID"] ."</p>";

if(!isset($_SESSION["QuizID"]))
{
	//if quiz not exist, back to list
	header("location: quizelist.php");
}

?>



<!DOCTYPE >
<html>
	<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	   <link rel="stylesheet" href="bootstrap/s2.css">
	</head>
<body>

<?php



if(!isset($_SESSION["quesNum"]))
{
//counter number of question
	$_SESSION["quesNum"]=0; 

//total Number of true answer or option
   $_SESSION["trueopt"]=0;
	
}

//The total of questions rows with the same Quiz ID
$rowQues=mysqli_query($con,"select * from quiz_question where quiz_id=$_SESSION[QuizID]") or die(mysqli_error());
//Fetch one question row
//$row= mysqli_fetch_row($rowQues);
//Fetch the options (answers) expected to specific question.
//$rowOption=mysqli_query($con,"select * from question_option where question_id=$row[0]") or die(mysqli_error());
//convert object to array
//$rop=mysqli_fetch_array($rowOption);


//-------------------------------------------------------
if($submit=='Next Question' && isset($opt))
//echo "<p>". $rop[4]."</p><br>";
	   {echo "<p>". $_SESSION["trueopt"]. "</p><br>";
			/*function accepts a result object and an integer value representing an offset, as parameters, 
			and moves the data seek of the given result object to the specified row */
			mysqli_data_seek($rowQues,$_SESSION["quesNum"]);
           // Fetch row
             $row= mysqli_fetch_row($rowQues);
             $rowOption=mysqli_query($con,"select * from question_option where question_id=$row[0]") or die(mysqli_error());
             $rop=mysqli_fetch_array($rowOption);
				if($opt==$rop[4])
				{
							$_SESSION["trueopt"]=$_SESSION["trueopt"]+1;
                          

				}
				$_SESSION["quesNum"]=$_SESSION["quesNum"]+1;
            echo "<p>". $_SESSION["trueopt"] . "</p><br>";

		}
         if ($submit=='Next Question' && !isset($opt)){
              echo "<h1>please choose answer</h1>";
		}
        
		if($submit=='Submit' && isset($opt)){
			mysqli_data_seek($rowQues,$_SESSION["quesNum"]);
           // Fetch row
             $row= mysqli_fetch_row($rowQues);
             $rowOption=mysqli_query($con,"select * from question_option where question_id=$row[0]") or die(mysqli_error());
             $rop=mysqli_fetch_array($rowOption);
			echo "<p>". $trueopt . "</p><br>";
			echo "<p>". $rop[4]."</p><br>";
			if($opt==$rop[4])
			{
				echo "<p> I'm hereeeeeeeeeeee</p><br>";
   
						$_SESSION["trueopt"]=$_SESSION["trueopt"]+1;
						

			}
			echo "<p>". $trueopt . "</p><br>";
			$_SESSION["quesNum"]=$_SESSION["quesNum"]+1;

			echo "<p>Total of correct answers:".$_SESSION["trueopt"]."</p> <br>";
			$wrong=$_SESSION["quesNum"] -$_SESSION["trueopt"];
			echo "<p>Total of wrong  answers:".$wrong."</p><br>";

			unset($_SESSION["quesNum"]);
			unset($_SESSION["trueopt"]); 
			unset($_SESSION["QuizID"]) ;
			session_unset();
			//header("location: quizelist.php");
			exit;
		}
	    if ($submit=='Submit' && !isset($opt)){
			echo "<h1>please choose answer</h1>";
           
		}
		
        
//-------------------------------------------------------


if($_SESSION["quesNum"]>mysqli_num_rows($rowQues)-1)
{
unset($_SESSION["quesNum"]);
echo "<h1>Some Error  Occured</h1>";
session_destroy();
echo "Please <a href=index.php> Start Again</a>";

exit;
}
//----------------------------------   Quiz Form    -------------------------------

// Seek to row number  lik (pointer)
mysqli_data_seek($rowQues,$_SESSION["quesNum"]);
  // Fetch row
$row= mysqli_fetch_row($rowQues);
$rowOption=mysqli_query($con,"select * from question_option where question_id=$row[0]") or die(mysqli_error());
//convert object to array
$rop=mysqli_fetch_array($rowOption);
$counter=$_SESSION["quesNum"]+1;
echo "<div class=wrapper>";
//echo "<div class=wrap id=q1>";
echo "<div class=text-center pb-4>";
echo "<div class=h5 font-weight-bold><span id=number> </span>".$counter ." of ". mysqli_num_rows($rowQues). "</div> </div>";

//echo "<form name=myfm method=post action=showQuiz.php>";

//echo "<table width=100%> <tr> <td width=30><td> <table border=0>";


//echo "<tR><td>Question ".  $counter .":". $row[1]."</style>";
//echo "<tr><td><input type=radio name=opt value=1>$rop[1]";
//echo "<tr><td> <input type=radio name=opt value=2>$rop[2]";
//echo "<tr><td><input type=radio name=opt value=3>$rop[3]";

echo "<div class=h4 >Question".  $counter .": ". $row[1]."</div>";
            echo"<div class=pt-4>";
			echo "<form name=myfm method=post action=showQuiz.php>";
			echo " <label class=options>".$rop[1]."<input type=radio name=opt value=1> <span class=checkmark></span> </label>";
			echo " <label class=options>".$rop[2]."<input type=radio name=opt value=2> <span class=checkmark></span> </label>";
			echo "<label class=options>".$rop[3]. "<input type=radio name=opt value=3> <span class=checkmark></span> </label>"; 
			echo" </div>";
            
           // <div class="d-flex justify-content-end pt-2"> <button class="btn btn-primary" id="next1">Next <span class="fas fa-arrow-right"></span> </button> </div>
        
       //echo" </div> </div>";
	   echo "<div class=d-flex justify-content-end pt-2>";
	   if($_SESSION["quesNum"]<mysqli_num_rows($rowQues)-1){
		
		echo "<div class=d-flex justify-content-end pt-2><input class=btn btn-primary type=submit name=submit value='Next Question'></form> </div>";
	   }
	   else{
		echo "<div class=d-flex justify-content-end pt-2><input class=btn btn-primary type=submit name=submit value='Submit'></form> </div>"; 
	   }
	   
	   echo " </div> </div>";

//if($_SESSION["quesNum"]<mysqli_num_rows($rowQues)-1)
//echo "<input type=submit name=submit value='Next Question'></form>";
//else
//echo "<input type=submit name=submit value='Submit'></form>";
//echo "</table> </table>";





?>

</body>
</html>