<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<title> COMP2190 Project 3, Problem 4</title>
		<link rel="stylesheet" type="text/css" href="Styles/stylep1A.css" />
	</head>
	<body>


<!--TEST IF INFORMATION IS CORRECT FROM THE FORM
Username: 			 	<?php echo $_POST["username"]; ?><br />
Password:   			 	<?php echo $_POST["password"]; ?><br />-->					

<?php 
	//login information to database specified in project
	$servername = "localhost:";
	$username =  "comp2190SA";
	$password = "2018Sem1";
	

	$hidden 	= 	$_POST["test"];
	$sessionID 	=   "cbdba09469eb25ebbe4987a57edfcf6e";  //ND5 of hidden field from the Login form
	$loginName  = 	$_POST["username"];
	$loginPass  = 	$_POST["password"];
	$logSuccess = 	0;
	$lastLog    =	 date('Y-m-d h:i:s', strtotime('-5 hours')); //current adjust for Jamaica Time Zone
	$logFail	=	 0;
	//echo ($hidden);  //check hidden field
	//echo  $lastLog;
	echo "<br />";

	if (md5($hidden)==$sessionID){
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
	}
	else{ 
		print "Invalid Session";
	}

	$selectStmt = $pdoConnect->prepare('SELECT * FROM users');             //Connect to user table in database
	$selectStmt->execute();
	$data = $selectStmt->fetchAll();

	foreach($data as $data){
		if ($loginName==$data["username"]){									//if user is a valid user in database
			if(md5($loginPass.$data["salt"])==$data["password_digest"]){   //check MD5 hash of enter password+salt against digest
				echo "Login Successful";
				echo "<br />";
				$logSuccess+=1;
		}
		else{
		//UPDATE USER FAILATTEMPS WHEN INCORRECT PASSWORD IS ENTERED
		$logFail=1+$data["failed_attempts"]; 								//Add to the number already in the database
		$query = 'UPDATE users SET last_login = :lastLog, failed_attempts =:logFail WHERE username = :loginName'; 
		$selectStmt = $pdoConnect->prepare($query);
		$updateStmt= $selectStmt->execute(array( ':lastLog'=>$lastLog,':logFail'=>$logFail, ':loginName'=>$loginName));
		
		/*if ($updateStmt){
   			 echo 'Data Updated';  					 //TEST IF FIELDS ARE UPDATED
			}
		else{
   			echo 'ERROR Data not updated';			//TEST IF FIELDS ARE  NOT UPDATE 
		}	*/

		}																//no error message for security purposes
	}
	else{}																//no error message for security purposes
	}
		//echo $logSuccess;  											//test to see how many sucessful login
		if ($logSuccess>0){

			$query = "SELECT * FROM courses";
			$data = $pdoConnect->query($query);							//Connect to course table to display contents below

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
		}
		else{
			echo "Invalid Login!!";										//if there are no user name or password in the database
		}

?>
	</body>
</html>
