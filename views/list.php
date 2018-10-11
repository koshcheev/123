
<p>Всего фтографий: <?php echo $result['totalCount']?></p>
<br>

<div class="row">

    <div class="col s2">
        <a class="waves-effect waves-light btn"
                href="?action=add">Создать альбом</a>
    </div>
    <div class="col s10">

    </div>
</div>
<br>
<br>

<?php
    foreach ($result['photos'] as $key => $value){?>
        <div class = "card-panel grey lighten-5 z-depth-2">


            <div class="row ">
                <div class="col s6">

                </div>
                <div class="col s3">
                    <a class="waves-effect waves-light btn"
                            href="?action=edit&id=<?php echo $value['id']?>&desc=<?php echo $value['text']?>">
                        Редактировать
                    </a>
                </div>
                <div class="col s3">
                    <a class="waves-effect waves-light btn"
                            href="?action=delete&id=<?php echo $value['id']?>">
                        Удалить
                    </a>
                </div>

            </div>

            <div class="row">
                <div class="col s6">
                    <br>
                    Количество комментариев: <?php echo $value['comments_count']?>
                </div>

                <div class="col s6 ">
                    <div class="card">
                        <div class="card-image">
                            <img src="<?php echo $value['pic640x480']?>">
                        </div>
                        <div class="card-content">
                            <p>
                                Описание: <?php echo $value['text']?>
                            </p>
                        </div>
                    </div>
                </div>


            </div>

        </div>



        <br>
        <br>

        <?php
    }
?>







