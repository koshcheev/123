<h4>Редактирование описания </h4>
<textarea name="" id="editArea" cols="30" rows="10"><?php echo $_GET['desc']?></textarea>
<!--<input type="text" id="editinput" value="--><?php //echo $_GET['desc']?><!--">-->

<p>
    <a class="waves-effect waves-light btn"
            id="editLink"
            href="?action=save&id=<?php echo $_GET['id']?>&desc=">
        Сохранить
    </a>
    <a class="waves-effect waves-light btn"
            href="?action=list">
        На главную
    </a>
</p>






