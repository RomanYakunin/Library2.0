<?
session_start();
require_once 'connection.php'; // подключаем скрипт
// подключаемся к серверу

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once __DIR__."/phpQuery/phpQuery/phpQuery.php";



function parser($url){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}
$result = parser("https://bookskazan.ru/catalog/knigi/");
// echo $result;
$pq = phpQuery::newDocument($result);
$arrDataBooks = array();
 $listLinks = $pq->find('.card-hover a.product-link');
// $listLinks = $pq->find('.slider__item a');
foreach ($listLinks as $link){
    // echo $link;
    $arrDataBooks[] = pq($link)->attr('href');
    // $img=$pq->find('.genres-carousel__item .product-cover .cover img')->attr('src');
    // $img[]=$pq->find('.slider__item .product-card.slider__item-card img')->attr('src');
    
}
// var_dump($img);
// echo "<pre>";
// var_dump($arrDataBooks);
// echo "<pre>";

/*===========================================================*/
$arrListBooks=array();
foreach(array_slice($arrDataBooks, 0, 32) as $book){
    $linkPage="https://bookskazan.ru".$book;
    $resultBook = parser($linkPage);
    $pq = phpQuery::newDocument($resultBook);
    
//     echo "<pre>";
//     echo("https://bookskazan.ru".$pq->find('.swiper-wrapper img')->attr('src'));
// echo "<pre>";
$genre_chek=$pq->find('.info-big__characteristics__list span')->text();
// echo "<pre>";
//     echo($pq->find('.info-big__characteristics__list span')->text());
// echo "<pre>";
$symbol = 'Серия';
$isSymbolExist = strpos($genre_chek, $symbol);
    if (!$isSymbolExist){
        $genre="Без жанра";
    }else{
        echo 
        $whatIWant = substr($isSymbolExist, strpos($isSymbolExist, $symbol) + 1);
        $genre=$whatIWant; 
    }
    $Summary_chek= $pq->find('.info-big__description p')->text();
    if (!$Summary_chek){
        $Summary="Нет описания";
    } else{
        $Summary=$Summary_chek;
    }
    $arrListBooks[]=[
        "Name" => $pq->find('h1')->text(),
        "Author" => $pq->find('.promo-block-product__conten__head a')->text(),
        "Genre" => $genre,
        "Summary" => $Summary,
        "Picture" => "https://bookskazan.ru".$pq->find('.swiper-wrapper img')->attr('src')
    ];
}
// echo "<pre>";
// var_dump($arrListBooks);
// echo "<pre>";
$link = mysqli_connect($db_host, $db_user, $db_password, $database)
  or die("Ошибка " . mysqli_error($link));
    $query = "DELETE FROM `books`";
    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
    $query = "DELETE FROM `authors`";
    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
    $query = "DELETE FROM `authors_of_books`";
    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
    $query = "DELETE FROM `genre`";
    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
    $query = "DELETE FROM `genre_of_books`";
    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
    for($i = 0, $size = count($arrListBooks); $i < $size; ++$i) {
    $Name_book=mysqli_real_escape_string ($link,$arrListBooks[$i]['Name']);
    $author=$arrListBooks[$i]['Author'];
    $genre=$arrListBooks[$i]['Genre'];
    $Summary=mysqli_real_escape_string ($link,$arrListBooks[$i]['Summary']);
    $picture=$arrListBooks[$i]['Picture'];
   $query = "INSERT INTO `books` (`Name_book`, `Summary`, `Picture`) 
   VALUES ('$Name_book', '$Summary', '$picture')";
        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
        $query = "SELECT `Name_author` FROM `authors` WHERE `Name_author`='$author'";
        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
             $row = mysqli_fetch_array($result);
             if ($row>0){
                $result=0;
            }else{
                $query = "INSERT INTO `authors` (`Name_author`) VALUES ('$author')";
                $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
            }
            $query = "SELECT `ID_author`,`ID_book` FROM `authors`,`books`
             WHERE `Name_author`='$author' AND `Name_book`= '$Name_book'";
        $result_r = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
            $row = mysqli_fetch_array($result_r);
            if ($row>0){
                while ($row != NULL) {
                $Id_author=$row['ID_author'];
                $Id_book=$row['ID_book'];
                $query = "INSERT INTO `authors_of_books` (`ID_author`,`ID_book`) 
                VALUES ('$Id_author','$Id_book')";
                $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
                $row = mysqli_fetch_array($result_r);
            }
            }
            $query = "SELECT `Name_genre` FROM `genre` WHERE `Name_genre`='$genre'";
            $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));  
            $row = mysqli_fetch_array($result);
             if ($row>0){
                $result=0;
            }else{
                $query = "INSERT INTO `genre` (`Name_genre`) VALUES ('$genre')";
                $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
            }
            $query_g = "SELECT `ID_genre`,`ID_book` FROM `genre`,`books`
             WHERE `Name_genre`='$genre' AND `Name_book`= '$Name_book'";
        $result_g = mysqli_query($link, $query_g) or die("Ошибка " . mysqli_error($link));
            $row_g = mysqli_fetch_array($result_g);
            if ($row_g>0){
                while ($row_g != NULL) {
                $Id_genre=$row_g['ID_genre'];
                $Id_book=$row_g['ID_book'];
                $query = "INSERT INTO `genre_of_books` (`ID_genre`,`ID_book`) 
                VALUES ('$Id_genre','$Id_book')";
                $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
                $row_g = mysqli_fetch_array($result_g);
            }
            }
            // echo "<pre>";
            // var_dump($row);
            // echo "<pre>";
            
            }
header("Location: index.php",  true,  301);
exit();
    ?>


  