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


//-------------------------------------------------------
if($submit=='Next Question' && isset($opt))

	   {
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
           

		}
         if ($submit=='Next Question' && !isset($opt)){
             echo "<div class=alret>";
			echo "<div class='alert alert-danger'>";
			echo "<strong> Oh, Heads up!</strong>  please choose the answer first. </div></div>";
           
   
		}
        
		if($submit=='Submit' && isset($opt)){
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
			echo "<div class=pointbox>";
			$wrong=$_SESSION["quesNum"] -$_SESSION["trueopt"];
			
			
			if ($_SESSION["trueopt"]>$wrong){
				
				echo "<div class=note>";
				echo "<div class=h5 ><div class=h3>Well Done!</div>  <div class=container>You passed the quiz.</div></div>";
				echo " </div>";
			}else{
				
				echo "<div class=note>";
				echo "<div class=h5 ><div class=h3>Pay Attention!!</div> <div class=container> Keep learning to get better grades.</div></div>";
				echo " </div>";
			}
			echo "<div class=point>";
			echo "<h2><strong>".$_SESSION["trueopt"]." Point(s)</strong></h2></div>";
			echo "<div class=su>";
            echo "<form action=quizelist.php><input class=but type=submit value='Quiz List'></form>";
			echo "<form action=#><input  class=but type=submit value='Home Page'></form></div>";
			echo "</div>";
			
			

            // remove all session variables
			session_unset();
			//header("location: quizelist.php");
			exit;
		}
	    if ($submit=='Submit' && !isset($opt)){
			echo "<div class=alret>";
			echo "<div class='alert alert-danger'>";
			echo "<strong> Oh, Heads up!</strong>  please choose the answer first. </div></div>";
           
		}
		if ($submit=='Exit'){
			// remove all session variables
			session_unset();

			header("location: quizelist.php");
		}
		


// Seek to row number  lik (pointer)
mysqli_data_seek($rowQues,$_SESSION["quesNum"]);
  // Fetch row
$row= mysqli_fetch_row($rowQues);
$rowOption=mysqli_query($con,"select * from question_option where question_id=$row[0]") or die(mysqli_error());
//convert object to array
$rop=mysqli_fetch_array($rowOption);
$counter=$_SESSION["quesNum"]+1;
$quesNumber=mysqli_num_rows($rowQues);
$question=$row[1];
$optOne=$rop[1];
$optTwo=$rop[2];
$optThree=$rop[3];

	   if($_SESSION["quesNum"]<mysqli_num_rows($rowQues)-1){
		$submitvalue="Next Question";
	   }
	   else{
		$submitvalue="Submit";
	   }
	   


?>
<!----------------------------------   Quiz Form    ------------------------------->

<div class="wrapper">
<div class="text-center pb-4">
<div class="h4 font-weight-bold"><span id="number"> </span><?php echo $counter?> of <?php echo $quesNumber?></div> </div>
<div class="h5 font-weight-bold" >Q <?php echo $counter?> : <?php echo $question?></div>
<div class="pt-4">
<form name="myfm" method="post" action="showQuiz.php">
<label class="options"><?php echo $optOne ?> <input type="radio" name="opt" value="1"> <span class="checkmark"></span> </label>
<label class="options"><?php echo $optTwo ?> <input type="radio" name="opt" value="2"> <span class="checkmark"></span> </label>
<label class="options"><?php echo $optThree ?> <input type="radio" name="opt" value="3"> <span class="checkmark"></span> </label>

<div class="d-flex justify-content-end">
	<input class="btn " type="submit" name="submit" value='<?=$submitvalue?>'></div>
	
</div> </div>
<div class="d-flex flex-column align-items-center">
	<input class="btn finish" type="submit" name="submit" value='  Exit  '></form> 
</div>


</body>
</html>