<?php
// Starting the session so PHP functions.
session_start();
// If the user is not logged in redirect to the login page.
if (!isset($_SESSION['loggedin'])) {
	header('Location: ../assessment/index.html');
	exit;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Home Page</title>
        <link href="../assessment/style.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
    </head>
    <body class="loggedin">
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
		<!--Code for the Banner and the heading-->
		<img src="Images/bannerfinal.jpg">
        <div class="content">
            <h2>Home Page</h2>
            <p>Kia Ora,  <?=$_SESSION['name']?>! Search for the Maori words that you wish to find:</p>
		</div>
		
		<div>
<!--The input code below is for a filter search allowing users to search through the entire table-->
<input class="search" type="text" id="search" onkeyup="myFunction()" placeholder="Search for Maori words.." title="Type in a Word">
<br></br>

<!--This is the table the displays all the words and their information stored in the main table from dictionarydb-->
<table id="myTable">
	<tr>
		<th>Maori</th>
		<th>English</th>
		<th>Definition</th>
		<th>Year Level</th>
		<th>Category</th>
		<th>Entry Date</th>
	</tr>
	<?php 
	//Connection to database: dictionarydb
	$conn = mysqli_connect("localhost", "root", "", "dictionarydb");
	if ($conn-> connect_error) {
		die("Connection failed:". $conn-> connect_error);
	}
	
	//Retrives the data from the table
	$sql = "SELECT maori, english, definition, yearlevel_id, category_id, entrydate from main";
	$result = $conn -> query($sql);
	
	//A while loop is used to gain the information from the database.
	if ($result -> num_rows > 0) {
		while($row = $result-> fetch_assoc()){
			echo "<tr><td>". $row["maori"]."</td><td>". $row["english"]."</td><td>". $row["definition"]."</td><td>". $row["yearlevel_id"]."</td><td>". $row["category_id"]."</td><td>". $row["entrydate"]."</td></tr>";
		}
		echo "</table>";
	}
	else{
		echo "0 result";
	}
	
	//Closes connection
	$conn->close();
	?>
</table>

<!--Javascript for the filter search-->
    <script>
    function myFunction() {
      var input, filter, table, tr, td, i, txtValue;
      input  = document.getElementById("search");
      filter = input.value.toUpperCase();
      table = document.getElementById("myTable");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
	  
	  
    }
	</script>
	
</div>
	<!--Code for the footer-->
	<footer>Alpa Sahai Internal - Copyright 2023</footer>
   </body>
</html>