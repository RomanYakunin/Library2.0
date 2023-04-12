<?php
session_start();
require_once 'connection.php'; // подключаем скрипт
// подключаемся к серверу
$link = mysqli_connect($db_host, $db_user, $db_password, $database)
  or die("Ошибка " . mysqli_error($link));
?> 
<!DOCTYPE HTML>
<html html lang="en" translate="no">
<head>
<title>Книжный магазин</title>
<meta name=»book_store» content=»notranslate» />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Книги Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!-- Custom Theme files -->
<link href="./images/favicon.png" rel="icon">
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href="css/component.css" rel='stylesheet' type='text/css' />
<!-- Custom Theme files -->
<!--webfont-->
<link href='//fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Dorsa' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<!-- start menu -->
<link href="css/megamenu.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="js/megamenu.js"></script>
<script>$(document).ready(function(){$(".megamenu").megamenu();});</script>
<script src="js/jquery.easydropdown.js"></script>
<script src="js/simpleCart.min.js"> </script>
<!-- <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script> -->
<script src="js/ajax.js"></script>
<style>
	
.bit input{ 
	width:250px;
}
	.but {
		width: 80%;
  display: flex;
  justify-content: center;
}
.but input{
	height:50px; 
	width:230px;
}
	summary:hover {
		background: #FFDEAD;
		cursor: pointer;
		display: block;
	}
   </style>
</head>
<body>
	<div class="men_banner">
   	  <div class="container">
   	  	
   	  <div class="header_bottom">
	   <div class="logo">
		  <h1><a href="index.html"><span class="m_1">К</span>ниги</a></h1>
	   </div>
	   <div class="menu">
	     <ul class="megamenu skyblue">
			
			</ul>
			</div>
	        <div class="clearfix"> </div>
	    </div>
	  </div>
   </div>
   <div class="men">
    <div class="container">
		<!-- <form action="query.php" method="post"> -->
    	<div class="col-md-4 sidebar_men">
		<div class="but">
			<input type="button" onclick="location.href='parser.php';" value="Спарсить книги" />
		</div>
		</br>
		<div class="but">
			<input type="submit" value="Поиск" name='Search' class='Search'>
		</div>
		
		<div class="bit">
			<h3>Поиск по названию</h3>
			<input type="text" value="" name='Name_Book' class='Name_Book'>
		</div>
			<details>
				<summary><h3>Жанры</h3></summary>
				<?php echo "<ul class='product-categories color'>";
					$query = "SELECT * FROM `genre`";
					$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
          			$row = mysqli_fetch_array($result);
					    if ($row > 0) {
						    while ($row != NULL) {
							   $id_genre=$row['ID_genre'];
							   $Name_genre=$row['Name_genre'];
							   $query_genre_of_books = "SELECT COUNT(ID_book) FROM `genre_of_books` WHERE `ID_genre`='$id_genre'";
							   $result_genre_of_books = mysqli_query($link, $query_genre_of_books) or die("Ошибка " . mysqli_error($link));
							   $row_genre_of_books = mysqli_fetch_array($result_genre_of_books);
								  if ($row_genre_of_books>0){
									$count=$row_genre_of_books['COUNT(ID_book)'];
								  }else{
									$count='0';
								  }
					echo "<li class='cat-item cat-item-63'><input type='checkbox' class='genre' name='genre[$id_genre]' value='$id_genre'> $Name_genre<span class='count'>($count)</span></li>";
					$row = mysqli_fetch_array($result);
								}
		 			echo "</ul>";
							}
					?>
			</details>
		  <details>
					<summary><h3>Авторы</h3></summary>
					<?php echo "<ul class='product-categories color'>";
					$query = "SELECT * FROM `authors`";
					$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
          			$row = mysqli_fetch_array($result);
					    if ($row > 0) {
						    while ($row != NULL) {
							   $id_author=$row['ID_author'];
							   $Name_author=$row['Name_author'];
							   $query_authors_of_books = "SELECT COUNT(ID_book) FROM `authors_of_books` WHERE `ID_author`='$id_author'";
							   $result_authors_of_books = mysqli_query($link, $query_authors_of_books) or die("Ошибка " . mysqli_error($link));
							   $row_authors_of_books = mysqli_fetch_array($result_authors_of_books);
								  if ($row_authors_of_books>0){
									$count=$row_authors_of_books['COUNT(ID_book)'];
								  }else{
									$count='0';
								  }
					echo "<li class='cat-item cat-item-63'><input type='checkbox' class='author' name='author[$id_author]' value='$id_author'> $Name_author<span class='count'>($count)</span></li>";
					$row = mysqli_fetch_array($result);
								}
		 			echo "</ul>";
							}
					?>
		</details>
	</div>
						<!-- </form> -->
    	<div class="col-md-8 mens_right">
    		<div class="dreamcrub">
                <div class="clearfix"></div>
			   </div>
			   <div class="mens-toolbar">
                 <div class="sort">
               	   <div class="sort-by">
		            </div> 
    		     </div>
    	        
                <div class="clearfix"></div>		
		        </div>
    		<div id="cbp-vm" class="cbp-vm-switcher cbp-vm-view-grid">
					<div class="cbp-vm-options">
					</div>
					<div class="pages">   
        	 		<div class="limiter visible-desktop">
              		 </div> 
       	   			</div><div class='clearfix'></div><ul id = "result">
					<?php 
					$query = "SELECT * FROM `books` ORDER BY RAND()";
					$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
          			$row = mysqli_fetch_array($result);
					    if ($row > 0) {
						    while ($row != NULL) {
							   $id=$row['ID_book'];
							   $name=$row['Name_book'];
							   $summary=$row['Summary'];
							   $picture=$row['Picture'];
							   $query_authors_of_books = "SELECT * FROM `authors_of_books` WHERE `ID_book`='$id'";
							   $result_authors_of_books = mysqli_query($link, $query_authors_of_books) or die("Ошибка " . mysqli_error($link));
							   $row_authors_of_books = mysqli_fetch_array($result_authors_of_books);
								  if ($row_authors_of_books>0){
									$id_author=$row_authors_of_books['ID_author'];
									$query_authors = "SELECT * FROM `authors` WHERE `ID_author`='$id_author'";
							  		$result_authors = mysqli_query($link, $query_authors) or die("Ошибка " . mysqli_error($link));
							   		$row_authors = mysqli_fetch_array($result_authors);
									$Name_author=$row_authors['Name_author']; 
								  }
								  $query_genre_of_books = "SELECT * FROM `genre_of_books` WHERE `ID_book`='$id'";
								  $result_genre_of_books = mysqli_query($link, $query_genre_of_books) or die("Ошибка " . mysqli_error($link));
								  $row_genre_of_books = mysqli_fetch_array($result_genre_of_books);
									 if ($row_genre_of_books>0){
									   $id_genre=$row_genre_of_books['ID_genre'];
									   $query_genre = "SELECT * FROM `genre` WHERE `ID_genre`='$id_genre'";
										 $result_genre = mysqli_query($link, $query_genre) or die("Ошибка " . mysqli_error($link));
										  $row_genre = mysqli_fetch_array($result_genre);
									   $Name_genre=$row_genre['Name_genre']; 
									 }
								echo "
								<li class='simpleCart_shelfItem'>
										<a class='cbp-vm-image' href='/?book=$id''>
										<div class='view view-first'>
										<div class='inner_content clearfix'>
											<div class='product_image'>
												<div class='mask1'><img src='$picture' alt='image' class='img-responsive zoom-img'></div>
												<div class='mask'>
													<div class='info'>Быстрый просмотр</div>
												</div>
												<div class='product_container'>
												<h4>$name</h4>
												<p>$Name_author</p>
												<div class='price mount item_price'>$Name_genre</div>
												</div>		
											</div>
											</div>
										</div>
										</a>
									</li>";
								$row = mysqli_fetch_array($result);
							}	
						}
					?>
					</ul>				
				</div>
				<script src="js/cbpViewModeSwitch.js" type="text/javascript"></script>
                <script src="js/classie.js" type="text/javascript"></script>
    	</div>
    </div>
   </div>
   <div class="footer">
   	 <div class="container">
   	 	<div class="newsletter">
			
		</div>
   		<div class="cssmenu">
		</div>
		<ul class="social">
	    </ul>
	    <div class="clearfix"></div>
	    <div class="copy">
	    </div>
   	</div>
   </div>
</body>
</html>		