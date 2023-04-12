<?php
session_start();
require_once 'connection.php'; // подключаем скрипт
// подключаемся к серверу
$link = mysqli_connect($db_host, $db_user, $db_password, $database)
  or die("Ошибка " . mysqli_error($link));

  $genre = $_POST['genre']; 
  $author = $_POST['author'];
  $name_book = $_POST['name_book'];
    if (!$genre and !$author and !$name_book){
      $query = "SELECT * FROM `books` ORDER BY RAND()";
    }
    if ($name_book and !$genre and !$author){
      $query = "SELECT * FROM `books` WHERE Name_book LIKE '%$name_book%' ORDER BY RAND() ";
    }
    if (!$name_book and $genre and !$author){
      $query = "SELECT * FROM `books` WHERE  `ID_book` IN (SELECT `ID_book` FROM 
      `genre_of_books` WHERE `ID_genre` IN ($genre)) ORDER BY RAND()";
    }
    if (!$name_book and !$genre and $author){
      $query = "SELECT * FROM `books` WHERE  `ID_book` IN (SELECT `ID_book` 
      FROM `authors_of_books` WHERE `ID_author` IN ($author)) ORDER BY RAND()";
    }
    if ($name_book and $genre and !$author){
      $query = "SELECT * FROM `books` WHERE  `ID_book` IN (SELECT `ID_book` 
      FROM `genre_of_books` WHERE `ID_genre` IN ($genre)) AND `Name_book` LIKE '%$name_book%' ORDER BY RAND()";
    }
    if ($name_book and !$genre and $author){
      $query = "SELECT * FROM `books` WHERE  `ID_book` IN (SELECT `ID_book` 
      FROM `authors_of_books` WHERE `ID_author` IN ($author)) AND `Name_book` LIKE '%$name_book%' ORDER BY RAND()";
    }
    if ($name_book and $genre and $author){
      $query = "SELECT * FROM `books` WHERE  `ID_book` IN (SELECT `ID_book` FROM 
      `genre_of_books` WHERE `ID_genre` IN ($genre)) AND `ID_book` IN (SELECT `ID_book` 
      FROM `authors_of_books` WHERE `ID_author` IN ($author)) AND `Name_book` LIKE '%$name_book%' ORDER BY RAND()";
    }
    if (!$name_book and $genre and $author){
      $query = "SELECT * FROM `books` WHERE  `ID_book` IN (SELECT `ID_book` FROM 
      `genre_of_books` WHERE `ID_genre` IN ($genre)) AND `ID_book` IN (SELECT `ID_book` 
      FROM `authors_of_books` WHERE `ID_author` IN ($author)) ORDER BY RAND()";
    }
// if ($_POST['author']){
//   $genre = $_POST['author']; 
// }elseif (!$_POST['author']) {
//   echo('Вы не выбрали автора');
// }

// $query = "SELECT * FROM `books` WHERE `ID_book` IN (SELECT `ID_book` FROM `genre_of_books` WHERE `ID_genre` IN ('$genre'))";
					
$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
          			$row = mysqli_fetch_array($result);
                if ($row > 0) {
                  while ($row != NULL) {
                   $id=$row['ID_book'];
                   $name=$row['Name_book'];
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
                      <a class='cbp-vm-image' href='single.php?book=$id''>
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
              
            }else{
              echo "<h3>По вашему запросу ничего не найдено</h3>";
            }
            
            				
// var_dump($a);?>