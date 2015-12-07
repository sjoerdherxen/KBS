$(function(){
   $("#opslaan").click(function(){
       var fields = $("form").serialize();
       $.post("/admin/editCategorie.php", fields);
   });
});
