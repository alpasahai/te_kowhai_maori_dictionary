<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"> 
	<meta >
	<title>Word List</title>
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

<div class="content">
   <h2>Wordlist Page</h2>
   <p>Look though the entire Te Kowhai Dictionary here:</p>
</div>

<div>
<!--This is the table the displays all the words and their information stored in the main table from dictionarydb-->
<table id="myTable"> 
	<thead>
	<tr class="header">
		<th>Maori</th>
		<th>English</th>
		<th>Definition</th>
		<th>Year Level</th>
		<th>Category</th>
		<th>Entry Date</th>
	</tr>
	</thead>
	<tbody>
	<!--This is the pagination Code-->
	<?php
	// Enter your Host, username, password, database below.
	$conn = mysqli_connect('localhost','root','','dictionarydb');
		if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		die();
		}
		if (isset($_GET['page_no']) && $_GET['page_no']!="") {
		$page_no = $_GET['page_no']; //Counts amount of pages
		} else {
			$page_no = 1;
			}
			$total_records_per_page = 15; //Determines how many rows you have displaying on the page
			$offset = ($page_no-1) * $total_records_per_page;
	$previous_page = $page_no - 1;
	$next_page = $page_no + 1;
	$adjacents = "2";
	$result_count = mysqli_query($conn,"SELECT COUNT(*) As total_records FROM main");
	$total_records = mysqli_fetch_array($result_count);
	$total_records = $total_records['total_records'];
	$total_no_of_pages = ceil($total_records / $total_records_per_page); //Divides the total amount of words by the number of records for page to find the amount of pages needed.
	$second_last = $total_no_of_pages - 1; // Total pages minus 1
	$result = mysqli_query(
		$conn,
		"SELECT * FROM `main` LIMIT $offset, $total_records_per_page"
		);
	
	//This is the code for the table - shows all the data
	while($row = mysqli_fetch_array($result)){
    echo "<tr>
	 <td>".$row['maori']."</td>
	 <td>".$row['english']."</td>
	 <td>".$row['definition']."</td>
	 <td>".$row['yearlevel_id']."</td>
	 <td>".$row['category_id']."</td>
	 <td>".$row['entrydate']."</td>
	 </tr>";
        }	
	$conn->close();
	?>
	</tbody>
</table>

<!--Code for the buttons and arrows relating to pagination-->
<ul class="pagination">
		
			<!-- If the user is on the very first page, then disable the previous button -->
			<li <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
			<a <?php if($page_no > 1){
				echo "href='?page_no=$previous_page'";
			} ?>>Previous</a>
			
			<!-- If the user is on a page greater or equal to 4, add the pagination break after page 3 -->
			<?php
			if($page_no <= 4) {
				for ($counter = 1; $counter < 6; $counter++){
				if ($counter == $page_no) {
					echo "<li class='active'><a>$counter</a></li>";
				}else{
					echo "<li><a href='?page_no=$counter'>$counter</a></li>";
					 }
				}
			echo "<li><a>...</a></li>";
			echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
			echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
			}
			
			// If the user is on any other page, add the pagination break after page 5
			else {
				echo "<li><a href='?page_no=1'>1</a></li>";
				echo "<li><a href='?page_no=2'>2</a></li>";
				echo "<li><a>...</a></li>";
				for (
					$counter = $total_no_of_pages - 4;
					$counter <= $total_no_of_pages;
					$counter++
					) {
					if ($counter == $page_no) {
					echo "<li class='active'><a>$counter</a></li>";
					}else{
						echo "<li><a href='?page_no=$counter'>$counter</a></li>";
					}
					}
				}
			?>
			</li>
			
			<!-- If the user is on the last page, disable the next button -->
			<li <?php if($page_no >= $total_no_of_pages){
			echo "class='disabled'";
			} ?>>
			<a <?php if($page_no < $total_no_of_pages) {
			echo "href='?page_no=$next_page'";
			} ?>>Next</a>
			</li>
</ul>
</div>
<!--Code for the footer-->
<footer>Alpa Sahai Internal - Copyright 2023</footer>
</body>
</html>