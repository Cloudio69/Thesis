<?php
$session = $_COOKIE['thesis_session'];
$path_frontespizio = THESIS_URL . "app/files/" . $session . "/frontespizio.jpg";
?>


<div class="thesis--frontespizio frontespizio flex items-center justify-center">
    <a href="<?php echo $path_frontespizio; ?>" class="flex items-center justify-center" data-fancybox><img class="drop-shadow-md w-1/2 h-full" src="<?php echo $path_frontespizio; ?>" /></a>
</div>

<?php
wp_enqueue_script('fancybox', "https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js", array(), null, true);
wp_enqueue_style('fancybox-css', "https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css");
?>