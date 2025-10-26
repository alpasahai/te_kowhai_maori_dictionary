<!DOCTYPE html>
<html>
    <head>
	    <title>Edit List</title>
		<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		<link href="../assessment/style.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
	</head>
	<body>
		<!--Navigation Bar code - consistent in all pages-->
		<nav class="navtop">
			<div>
				<h1>Te Kowhai - The Maori Dictionary</h1>
                <a href="../assessment/home.php"><i class="fas fa-home"></i>Home</a>
				<a href="../assessment/wordlist.php"><i class="fas fa-list"></i>Word List</a>
		        <a href="../assessment/editlist.php"><i class="fas fa-pen-to-square"></i>Edit List</a>	
				<a href="../assessment/profile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="../assessment/logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
	
	<div class="content">
		<h2>Edit List Page</h2>
		<p>Add in new Maori words to the Te Kowhai Dictionary!</p>
    </div>
	   <!--The code below is for the textboxes and dropdowns so that user can enter a new words into the dictionary. It also links to the main table in the database so that words can be directly altered or added in-->
	   <?php require_once '../assessment/editlistprocess.php'; ?>
	   
	   	   <div class= "content" class ="row justify-content-center">
	   <form action="../assessment/editlistprocess.php" method="POST">
		   <input type="hidden" name="main_id" value="<?php echo $main_id; ?>">
	       <!--Textbox for Maori Words-->
		   <div class="form-group">
	       <label>Maori</label>
	       <input type="text" name="maori" class="form-control" 
				  value="<?php echo $maori; ?>" placeholder="Enter Maori word">
		   </div>
		   <!--Textbox for English Words-->
		   <div class="form-group">
	       <label>English</label>
	       <input type="text" name="english" class="form-control" 
				  value="<?php echo $english; ?>" placeholder="Enter English word">
		   </div>
		   <!--Textbox for Definition-->
		   <div class="form-group">
	       <label>Definition</label>
	       <input type="text" name="definition" class="form-control" 
				  value="<?php echo $definition; ?>" placeholder="Enter Definition">
		   </div>
		   <!--Dropdown for Year level-->
		   <div class="form-group">
		   <label>Year Level</label>
		   <div class="select">
			<select class="input is-large" name="yearlevel_id" id="yearlevel_id">
			<option value="">Select Year Level</option>
			<?php //Code connects the dropdown to the year_level table allowing retrival of data relating to year level and difficulty
				$mysqli = new mysqli('localhost', 'root', '', 'dictionarydb') or die(mysqli_error($mysqli));
				$result = $mysqli->query("SELECT * FROM year_level") or die($mysqli->error);
				
				while($row=mysqli_fetch_array($result)){
			?>
			<option value="<?php echo $row['yearlevel_id'];?>"><?php echo $row['difficulty'];?></option>
			<?php }?>
			</select>
		   </div>
		   </div>
		   <!--Dropdown for Categroy-->
		   <div class="form-group">
		   <label>Category</label>
		   <div class="select">
			<select class="input is-large" name="category_id" id="category_id">
			<option value="">Select Category</option>
			<?php //Code connects the dropdown to the category table allowing for access to the category data
				$mysqli = new mysqli('localhost', 'root', '', 'dictionarydb') or die(mysqli_error($mysqli));
				$result = $mysqli->query("SELECT * FROM category") or die($mysqli->error);
				
				while($row=mysqli_fetch_array($result)){
			?> 
			<option value="<?php echo $row['category'];?>"><?php echo $row['category'];?></option>
			<?php }?>
			</select>
		   </div>
		   </div>
		   <!--Textbox for Entry Date-->
		   <div class="form-group">
		   <label>Entry Date</label>
		   <input type="text" name="entrydate" 
				  value="<?php echo $entrydate; ?>" class="form-control" placeholder="Enter Entry Date">
		   </div>
		   
		   <!--Code for the Update and Save Buttons if word was altered-->
		   <div class="form-group">
		   <?php 
		   if ($update == true):
		   ?>
				<button type="submit" class="btn btn-info" name="update">Update</button>
			<?php else: ?>
				<button type="submit" class="btn btn-primary" name="save">Save</button>
			<?php endif; ?>
		   </div>
		   
		   
	   </form>
	   </div>
	   
	   <?php
	   
	   if (isset($_SESSION['message'])): ?>
	   
	   <div class="alert alert-<?=$_SESSION['msg_type']?>">
	   
			<?php
				echo $_SESSION['message'];
				unset($_SESSION['message']);
			?>
		</div>
		<?php endif ?>
	   <div class="container">
	   <?php
	   //Establish connection to database
	     $mysqli = new mysqli('localhost', 'root', '', 'dictionarydb') or die(mysqli_error($mysqli));
		 $result = $mysqli->query("SELECT * FROM main ORDER BY main_id DESC") or die($mysqli->error);
		 ?>
		 <!--This is the table the displays all the words and their information stored in the main table from dictionarydb. It also has the Action column allowing users to delete or edit their words-->
		 <div class="row justify-content-center">
			<table id="myTable">
				<thead>
					<tr>
						<th>Maori</th>
						<th>English</th>
						<th>Definition</th>
						<th>Year Level</th>
						<th>Category</th>
						<th>Entry Date</th>
						<th colspan="2">Action</th>
					</tr>
				</thead>
		<?php //Retrieves data for each word from database and displays it on table
			while($row = $result->fetch_assoc()): ?>		
				<tr>
					<td><?php echo $row['maori']; ?></td>
					<td><?php echo $row['english']; ?></td>
					<td><?php echo $row['definition']; ?></td>
					<td><?php echo $row['yearlevel_id']; ?></td>
					<td><?php echo $row['category_id']; ?></td>
					<td><?php echo $row['entrydate']; ?></td>
					<td>
					<!--Code for the Edit and Delete buttons-->
						<a href="../assessment/editlist.php?edit=<?php echo $row['main_id']; ?>"
							class="btn btn-info">Edit</a>
						<a href="../assessment/editlistprocess.php?delete=<?php echo $row['main_id']; ?>"
							class="btn btn-danger">Delete</a>
					</td>
				</tr>
			<?php endwhile; ?>
			</table>
		 </div>
		 <?php	
		 
		 function pre_r( $array ){
			echo '<pre>';
			print_r($array);
			echo '</pre>';
		 }
	   ?>
	   
	   </div>
	   <!--Code for the footer-->
	   <footer>Alpa Sahai Internal - Copyright 2023</footer>
	</body>