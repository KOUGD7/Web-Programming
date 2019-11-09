<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<title> COMP2190 Project 3, Problem 3</title>
		<link rel="stylesheet" type="text/css" href="Styles/stylep1A.css" />
	</head>
	<body>

<h3> Your Submission:</h3>
<div>
	Course Discipline:	 	<?php echo $_POST["courseDiscipline"]; ?><br />
	Course Code:			<?php echo $_POST["courseCode"]; ?><br />
	Course Title:	 		<?php echo $_POST["courseTitle"]; ?><br />
	Level:				 	<?php echo $_POST["level"]; ?><br />
	Semester: 			 	<?php echo $_POST["semester"]; ?><br />
	Credit:   			 	<?php echo $_POST["credit"]; ?><br />
	Author ID:				<?php echo $_POST["author"]; ?><br /><br />						
</div>
<?php 
	//login information to database specified in project
	$servername = "localhost:";
	$username =  "comp2190SA";
	$password = "2018Sem1";
	
	$discip 	= 	$_POST["courseDiscipline"];
	$code 		= 	$_POST["courseCode"];
	$title 		= 	$_POST["courseTitle"];
	$level 		= 	$_POST["level"];
	$semester 	= 	$_POST["semester"]; 
	$credit 	=	$_POST["credit"];
	$author 	= 	$_POST["author"];
	$hidden 	= 	$_POST["test"];
	#echo ($hidden);
	#echo "<br />";


	try {
    	$pdoConnect  = new PDO("mysql:dbname=coursemgmtdb;host=localhost", $username, $password);
    	// set the PDO error mode to exception
    	$pdoConnect ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   		echo "Connected successfully.";
   		echo "<br />";
    	}
	catch(PDOException $e) {
    	echo "Connection failed: "; //. $e->getMessage();
    	}

	if (preg_match("/^([0-9]{4})$/", $code)) {  	 	# while a valid course code of length 4 consisting only of integers
		if (preg_match("/^([a-zA-Z]{4})$/", $discip)) { # Valid disciplines are four characters long
			if ($title != ''){							# valid course title is any non-empty string
				#if ($hidden=="c7fafc6d1d3ec4671a342b64e319909f"){} #was not a specified requirement. Not included, used in p4.

					///Insert Data for the FORM
					$pdoQuery = "INSERT INTO `courses`(`discipline`, `code`, `title`, `level`, `credits`, `AuthorID`, `semester` ) VALUES (:discipline,:code,:title,:level,:credits,:AuthorID,:semester)";
    
    				$pdoResult = $pdoConnect->prepare($pdoQuery);
    
    				$pdoExec = $pdoResult->execute(array(":discipline"=>$discip,":code"=>$code,":title"=>$title, ":level"=>$level,":credits"=>$credit,":AuthorID"=>$author, ":semester"=>$semester));
    
        			// check if mysql insert query successful
    				if($pdoExec){
       					 echo 'Submission was successfully added to database.';

    				}
    				else{
    					echo 'Data Not Inserted.';
    				}

			} else{ print "Error, invalid submission. Try again."; }    //no specific information for security purposes
		} else{ print "Error, invalid submission. Try again."; }		//no specific information for security purposes
	}else{ print "Error, invalid submission. Try again."; }				//no specific information for security purposes

	//Fetch all Data
	$query = "SELECT * FROM courses";									//Load all data from course table and display below

	$data = $pdoConnect->query($query);

	echo "<br />";
	echo "<br />";
	echo '<table>
			<thead>
				<tr>
					<th>Discipline</th>
					<th>Code</th>
					<th>Course Title</th>
					<th>Level</th>
					<th>Semester</th>
					<th>Credit </th>
					<th>Author ID</th>
					<th>ID</th>
				</tr>
			</thead>';
		$count=0;
		foreach($data as $row){
			$count++;
			if ($count%2==0){
				echo '<tr class="shaded">
						<td>'.$row["discipline"].'</td> 
						<td>'.$row["code"].'</td>
						<td>'.$row["title"].'</td> 
						<td class="center">'.$row["level"].'</td>
						<td class="center">'.$row["semester"].'</td> 
						<td class="center">'.$row["credits"].'</td> 
						<td class="center">'.$row["AuthorID"].'</td> 
						<td>'.$row["id"].'</td> 
						</tr>';
			}
			else{
				echo '<tr class="grshaded">
						<td>'.$row["discipline"].'</td> 
						<td>'.$row["code"].'</td>
						<td>'.$row["title"].'</td> 
						<td class="center">'.$row["level"].'</td>
						<td class="center">'.$row["semester"].'</td> 
						<td class="center">'.$row["credits"].'</td> 
						<td class="center">'.$row["AuthorID"].'</td> 
						<td>'.$row["id"].'</td> 
						</tr>';
			}
			
		}
		echo '</table>';
?>
	</body>
</html>
