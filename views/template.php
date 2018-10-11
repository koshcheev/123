<!DOCTYPE html>
<html lang="ru">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="css.css">

    <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
    <script type="text/javascript">
        $(window).load(function(){

            $(" #editLink ").on('click', function(){
                //дополняем ссылку значением поля
                $("#editLink").attr(
                    "href",
                    $("#editLink").attr("href") + ($(" #editArea ").val() || "Не заполнено описание")
                );
            });

            $(" #addLink ").on('click', function(){
                console.log($(" #addArea ").val() || "Не заполнено описание");
                //дополняем ссылку значением поля
                $("#addLink").attr(
                    "href",
                    $("#addLink").attr("href") + ($(" #addArea ").val() || "Без названия")
                );
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

            <div class="row ">
                <div class="col s8">
                    <h5>Пользователь: <?php echo OdnoklassnikiSDK::$user_name?> </h5>
                </div>
                <div class="col s2">

                </div>

                <div class="col s2">
                    <a class="waves-effect waves-light btn"
                       href="?action=logout">
                        Выйти
                    </a>
                </div>

            </div>
        </div>
    </header>
    <div class="container centercol" >

        <?php include 'views/'.$content; ?>

    </div>
</body>

</html>