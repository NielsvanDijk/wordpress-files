<?php

/* ------------------------------------------------------------------------ */
/* Menu class + menu registration | BEGIN
/* ------------------------------------------------------------------------ */
        
    add_action('init', 'register_custom_menu');
 
    function register_custom_menu() {
        register_nav_menu('main_navigation', 'Main Navigation');
    }

    class Clean_Nav extends Walker {
        var $tree_type = array( 'post_type', 'taxonomy', 'custom' );
        var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );
        function start_lvl(&$output, $depth) {
            $indent = str_repeat("\t", $depth);
            $output .= "$indent<ul class=\"submenu\">";
        }
        function end_lvl(&$output, $depth) {
            $indent = str_repeat("\t", $depth);
            $output .= "$indent</ul>\n";
        }
        function start_el(&$output, $item, $depth, $args) {
            global $wp_query;
            

            $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
            $class_names = $value = '';
            
            $classes = empty( $item->classes ) ? array() : (array) $item->classes;
            $classes = in_array( 'current-menu-item', $classes ) ? array( $classes[0].' active' ) : array($classes[0]);

            $ancestor = empty( $item->classes ) ? array() : (array) $item->classes;
            $ancestor = in_array( 'current-menu-ancestor', $ancestor ) ? array( $ancestor[0].' active' ) : array($ancestor[0]);

            $kids = empty($item->classes) ? array() : (array) $item->classes;
            $hasSubmenu = in_array('menu-item-has-children', $kids);
            $kids = $hasSubmenu ? array($kids[0].'has-submenu') : array($kids[0]);

            // Add on Current menu item "class=" active"
            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
            $class_names = strlen( trim( $class_names ) ) > 0 ? ' class="' . esc_attr( $class_names ) . '"' : '';

            // Adds on Master menu when you are on the sub item "class=" active"
            $class_ancestor = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $ancestor ), $item, $args ) );
            $class_ancestor = strlen( trim( $class_ancestor ) ) > 0 ? ' class="' . esc_attr( $class_ancestor ) . '"' : '';

            $id = apply_filters( 'nav_menu_item_id', '', $item, $args );
            $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
            
            $output .= $indent . '<li' . $id . $value . $class_names .$class_ancestor.'>';

                                 
            $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
            $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
            $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
            $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
            
            $item_output = $args->before;
            $item_output .= '<a'. $attributes .'>';
            
            $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
            if( $hasSubmenu ) {
                $item_output .= '<span class="submenu-toggle">
                                <i class="icon-right-open-mini"></i>
                            </span>';
            }
            $item_output .= '</a>';
            $item_output .= $args->after;
            
            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }
        function end_el(&$output, $item, $depth) {
            $output .= "</li>";
        }
    }

/* ------------------------------------------------------------------------ */
/* Menu class + menu registration | END
/* ------------------------------------------------------------------------ */    
?>
