<!DOCTYPE html>
<html lang="ru">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="css.css">

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
                $("#editLink").attr("href") + ($(" #editArea ").val() || "-"));

        });
    });
</script>


<head>
    <meta charset="utf-8">
    <title>CRUD операции с фото </title>
</head>
<body>
    <header>
        <div class="container" >
            <h4>Фотогрфии </h4>
            <h5>Пользователь: <?php echo $current_user['name']?> </h5>
        </div>
    </header>
    <div class="container centercol" >

        <?php include 'views/'.$content; ?>

    </div>
</body>

</html>