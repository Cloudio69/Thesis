<?php
$session = $_COOKIE['thesis_session'];
$path_frontespizio = THESIS_URL . "app/files/" . $session . "/frontespizio.jpg";
?>


<div class="thesis--frontespizio frontespizio flex items-center justify-center">
    <img class="drop-shadow-md w-1/2 h-full" src="<?php echo $path_frontespizio; ?>" />
</div>