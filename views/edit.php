<h2>Редактирование описания </h2>
<textarea name="" id="editArea" cols="30" rows="10"><?php echo $_GET['desc']?></textarea>
<!--<input type="text" id="editinput" value="--><?php //echo $_GET['desc']?><!--">-->

<p>
    <a id="editLink" href="?action=save&id=<?php echo $_GET['id']?>&desc=">Сохранить</a>
    <a href="?action=list">На главную</a>
</p>






