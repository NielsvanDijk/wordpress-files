<?php
$nav = array(
    'menu'            => 'main_navigation',
    'link_before'     => '',
    'echo'            => false,
    'menu_id'         => '',   
    'container_class' => false, 
    'fallback_cb'     => '',
    'items_wrap'      => '<ul>%3$s</ul>',
    'walker'          => new Clean_Nav('main_navigation')
);
$navigation = wp_nav_menu( $nav );  
?>

<?php echo $navigation ?>
