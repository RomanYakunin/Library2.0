

$(document).ready(function(){

      //I selected the body tag first because I do not know if you are creating
      //the pswd element dynamically
      $("body").on("blur", ".Name_Book", function() {
         var name = $('input.Name_Book').val();
            $.ajax({
               method: "POST",
               url: "\query.php",
               data: { name_book: name},
               success: function( result ) {
               $('#result').html(result);
               }
            });
         });
   
    $(".Search, .author, .genre").on('click',function(){
        var name = $('input.Name_Book').val();
        var genress = document.getElementsByClassName('genre');
        var authorss = document.getElementsByClassName('author');
        var authors=[];
        var genres=[];
        for (var i = 0; i < genress.length; i++) {
            if (genress[i].checked) {
               genres.push(genress[i].value); // положим в массив выбранный
            }
         }
        for (var i = 0; i < authorss.length; i++) {
            if (authorss[i].checked) {
               authors.push(authorss[i].value); // положим в массив выбранный
            }
         }
         var genreValue = genres.join(", ");
         var authorValue = authors.join(", ");
         $.ajax({
            method: "POST",
            url: "\query.php",
            data: { genre: genreValue, author: authorValue, name_book: name },
            success: function( result ) {
            $('#result').html(result);
            }
            });
    })
    
});