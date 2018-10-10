<h2>Фотогрфии </h2>
<h3>Пользователь: <?php echo $current_user['name']?> </h3>
<p>Всего фтографий: <?php echo $result['totalCount']?></p>
<br>
<br>
<br>

<?php
    foreach ($result['photos'] as $key => $value){?>
        <div>
            <img src="<?php echo $value['pic640x480']?>" alt="<?php echo $value['text']?>">
            <p>
                <a href="?action=delete&id=<?php echo $value['id']?>">Удалить </a>
                <a href="?action=edit&id=<?php echo $value['id']?>&desc=<?php echo $value['text']?>">Редактировать </a>
            </p>
            <p>Описание фото: <?php echo $value['text']?></p>
            <p>Количество комментариев: <?php echo $value['comments_count']?></p>
            <br>
            <br>
            <br>

        </div>
        <?php
    }
?>

<a href="?action=add">Добавить фото</a>





