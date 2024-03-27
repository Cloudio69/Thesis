<?php
$session = $_COOKIE['thesis_session'];
$pathFrontespizio = THESIS_URL . "app/files/" . $session . "/frontespizio.jpg";
?>


<div class="thesis--frontespizio frontespizio flex items-center justify-center">
    <img class="drop-shadow-md" src="<?php echo $pathFrontespizio; ?>" width="75%" height="100%" />
</div>