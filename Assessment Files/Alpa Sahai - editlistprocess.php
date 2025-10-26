<?php
//Starting session
session_start();
//Establish connection to database
$mysqli = new mysqli('localhost', 'root', '', 'dictionarydb') or die (mysqli_error($mysqli));

//Identification of variables
$main_id = 0;
$update = false;
$maori = '';
$english = '';
$definition = '';
$yearlevel_id = '';
$category_id = '';
$entrydate = '';

//Code if the user wants to save a word after updating
if (isset($_POST['save'])){
	$maori = $_POST['maori'];
	$english = $_POST['english'];
	$definition = $_POST['definition'];
	$yearlevel_id = $_POST['yearlevel_id'];
	$category_id = $_POST['category_id'];
	$entrydate = $_POST['entrydate'];
	  
	$mysqli->query("INSERT INTO main (maori, english, definition, yearlevel_id, category_id, entrydate) VALUES('$maori', '$english', '$definition', '$yearlevel_id', '$category_id', '$entrydate')") 
		or die ($mysqli->error);
	
	$_SESSION['message'] = "Record has been saved";
	$_SESSION['msg_type'] = "success";
	
	header("location: ../assessment/editlist.php");

	} 

//Code if user wants to delete a word from the table
if (isset($_GET['delete'])){
		$main_id = $_GET['delete'];
		$mysqli->query("DELETE FROM main WHERE main_id=$main_id") or die($mysqli->error());
		
		$_SESSION['message'] = "Record has been deleted";
		$_SESSION['msg_type'] = "danger";
		
		header("location: ../assessment/editlist.php");
	}

//Code if user wants to edit the word
if (isset($_GET['edit'])){
	$main_id = $_GET['edit'];
	$update = true;
	$result = $mysqli->query("SELECT * FROM main WHERE main_id=$main_id") or die($mysqli->error());
	if (!empty($result)==1){
		$row = $result->fetch_array();
		$maori = $row['maori'];
		$english = $row['english'];
		$definition = $row['definition'];
		$yearlevel_id = $row['yearlevel_id'];
		$category_id = $row['category_id'];
		$entrydate = $row['entrydate'];
	}
}

//Code after user has edited and saved the word - updates the word on the table in the database and the website
if (isset($_POST['update'])){
	$main_id = $_POST['main_id'];
	$maori = $_POST['maori'];
	$english = $_POST['english'];
	$definition = $_POST['definition'];
	$yearlevel_id = $_POST['yearlevel_id'];
	$category_id = $_POST['category_id'];
	$entrydate = $_POST['entrydate'];
	
	$mysqli->query("UPDATE main SET maori='$maori', english='$english', definition='$definition', yearlevel_id='$yearlevel_id', category_id='$category_id', entrydate='$entrydate' WHERE main_id=$main_id") or
			die($mysqli->error);
			
	$_SESSION['message'] = "Record has been updated!";
	$_SESSION['msg_type'] = "warning";
	
	header('location: ../assessment/editlist.php');
}