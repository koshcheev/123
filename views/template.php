<!DOCTYPE html>
<html lang="ru">
<!--<link rel="stylesheet" type="text/css" href="/css/style.css" />-->
<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
<script type="text/javascript">
    $(window).load(function(){

        // $(" #editArea ").on('input keyup', function(){
        //     $("#editLink").attr("href", "http://www.google.com/")
        // });

        $(" #editLink ").on('click', function(){
            //заменили что запомнили на текущее
            $("#editLink").attr(
                "href",
                $("#editLink").attr("href") + $(" #editArea ").val())
            );

        });



    });


</script>


<head>
    <meta charset="utf-8">
    <title>CRUD операции с фото </title>
</head>
<body>
<?php include 'views/'.$content; ?>
</body>

</html>