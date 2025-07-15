<?php
include 'classes/TeamManager.php';
$tm1 = new TeamManager ('mayang2026', '/equipe1');
$tm1->renderPages();
?>
<hr>
<div style="text-align: center">
    <b>Base arrière : L'équipe de Centre Terre en appui technique et scientifique</b>
</div>
<hr>
<?php
$tm2 = new TeamManager ('mayang2026', '/equipe2');
$tm2->renderPages();
?>
