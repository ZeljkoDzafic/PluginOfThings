<?php
/*
 * Plugin Name: WordUp Conference
 * Description: We are fast learners, if not we will Google it anyway 
 * Version: 0.1
 * Author: Zeljko Dzafic
 * Author URI: http://madebyjaffa.com
 * Plugin URI: http://wordupconference.me/plugin/
 * License: GPL2
 * Date: 24th March 2015
 */

 
 
#########################################################################


     function wordup_add_menu() {
		//add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
		//https://codex.wordpress.org/Function_Reference/add_menu_page
        add_menu_page( 'WordUp Conference', 'WordUp BL', 'manage_options', 'word-up-conference-dashboard', wordup_dashboard , plugins_url('word-up-conference/images/word-up-conference.png'));
	 }
	 function wordup_dashboard () {
		  echo "<div class=\"wrap\">";
			 echo "<h2>Plugin Dashboard</h2>";

		 echo "<p><strong>Jer sam opak dasa ja</strong> <br/> <img src=\"http://i.ytimg.com/vi/AM7KYjL_9dk/hqdefault.jpg\"></p>";
		 echo "</div>";
	 }

add_action('admin_menu', 'wordup_add_menu');

	 
############################################################################
	 
	 
     function wordup_add_option_page() {
		//add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function);
		//https://codex.wordpress.org/Function_Reference/add_options_page
		add_options_page( $page_title, $menu_title, $capability, $menu_slug, $functio);
		
        add_options_page( 'WordUp Conference Options', 'WordUp Options', 'manage_options', 'word-up-conference-options', wordup_options);
	 }
	 function wordup_options () {
		 		  echo "<div class=\"wrap\">";
			 echo "<h2>Koje su tvoje opcije</h2>";
		 echo "<quote>I know what you're thinking: \"Did he fire six shots or only five?\" Well, to tell you the truth, in all this excitement, I've kinda lost track myself. But being this is a .44 Magnum, the most powerful handgun in the world, and would blow your head clean off, <b>you've got to ask yourself one question: 'Do I feel lucky?' Well, do ya, punk?</b>";
		 
		 ?>
		 <table class="form-table">
<tbody>
				<tr>
				<th scope="row"><label for="opcija">Opcija1</label></th>
				<td><input name="blogname" type="text" id="1" value="Test" class="regular-text"></td>
				</tr>
				<tr>
				<th scope="row"><label for="start_of_week">"Kako bi petak bio ljepsi"</label></th>
				<td><select name="start_of_week" id="start_of_week">

					<option value="0">1</option>
					<option value="1" selected="selected">da sutra nije subota radna</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option></select></td>
				</tr>
	</tbody>
</table>
		 <?php
		 echo "</div>";
	 }
add_action('admin_menu', 'wordup_add_option_page');
	 
################################################################################	



// Add Toolbar Menus
function custom_toolbar() {
	global $wp_admin_bar;

	$args = array(
		'id'     => 'word-up-conf-bar',
		'title'  => __( 'WordUp Bar', 'text_domain' ),
		'href'   => '#',
		'meta'  => array( 'class' => 'my-word-up-conf-page' )
		//'group'  => true,
	);
	$main = $wp_admin_bar->add_menu( $args );
	$args2 = array(
		'id'    => 'my_page',
		'title' => 'My Page',
		'href'  => 'http://mysite.com/my-page/',
		'meta'  => array( 'class' => 'my-toolbar-page' ),
		'parent' => 'word-up-conf-bar',
	);
	$wp_admin_bar->add_node( $args2 );
}

// Hook into the 'wp_before_admin_bar_render' action
add_action( 'wp_before_admin_bar_render', 'custom_toolbar', 999 ); 

################################################################################	



function wordup_setting_filed_callback() {
		$value = get_option( 'word_up_field', '' );
		echo '<input type="text" id="word-up-field" name="word_up_field" value="' . esc_attr( $value ) . '" />';
}

function register_my_setting() {
	//add_settings_section( $id, $title, $callback, $page ) 
	//add_settings_field( $id, $title, $callback, $page, $section, $args ).
	//register_setting( 'my_options_group', 'my_option_name', 'intval' );
	
        register_setting( 'general', 'word-up-field', 'esc_attr' );
        add_settings_field('word_up_field', 'WordUpField' , wordup_setting_filed_callback , 'general' );	
		
} 
add_action( 'admin_init', 'register_my_setting' );

##########################################################################################

function create_word_up_type() {
    register_post_type( 'wordup',
        array(
            'labels' => array(
                'name' => 'Word Ups',
                'singular_name' => 'Word Up',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Word Up',
                'edit' => 'Edit',
                'edit_item' => 'Edit Word Up',
                'new_item' => 'New Word Up',
                'view' => 'View',
                'view_item' => 'View Word Up',
                'search_items' => 'Search Word Up',
                'not_found' => 'No Word Up found',
                'not_found_in_trash' => 'No Word Up found in Trash',
                'parent' => 'Parent Movie Review'
            ),
 
            'public' => true,
            'menu_position' => 15,
            'supports' => array( 'title', 'editor', 'comments', 'thumbnail', 'custom-fields' ),
            'taxonomies' => array( 'post_tag',  ),
            'menu_icon' => plugins_url( 'images/image.png', __FILE__ ),
            'has_archive' => true
        )
    );
}
add_action('init',create_word_up_type );


###########################################################################################

function create_book_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Genres', 'taxonomy general name' ),
		'singular_name'     => _x( 'Genre', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Genres' ),
		'all_items'         => __( 'All Genres' ),
		'parent_item'       => __( 'Parent Genre' ),
		'parent_item_colon' => __( 'Parent Genre:' ),
		'edit_item'         => __( 'Edit Genre' ),
		'update_item'       => __( 'Update Genre' ),
		'add_new_item'      => __( 'Add New Genre' ),
		'new_item_name'     => __( 'New Genre Name' ),
		'menu_name'         => __( 'Genre' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'genre' ),
	);


	register_taxonomy( 'genre', array( 'wordup' ), $args );
	
}
	add_action('init',create_book_taxonomies );
############################################################################################


//function adding_custom_meta_boxes( $post_type, $post ) {
function adding_custom_meta_boxes(  $post ) {
    add_meta_box( 
        'my-meta-box',
        __( 'My Meta Box' ),
        'render_my_meta_box',
        'wordup',
        'normal',
        'default'
    );
}
function render_my_meta_box() {
	
echo "Ja sam meta box i mnogo sam strasan";	
};

//add_action( 'add_meta_boxes', 'adding_custom_meta_boxes', 10, 2 );
add_action( 'add_meta_boxes_wordup', 'adding_custom_meta_boxes' );
###############################################################################################

//https://codex.wordpress.org/Dashboard_Widgets_API

function word_up_dashboard_panel() {
 wp_add_dashboard_widget('wordup-panel', 'Word up panel page', plugin_options_page);
 
 }
 
 function example_dashboard_widget_function () {
	 
	 echo "Svi zele da budu prvi";
 }
 function plugin_options_page () {
	 
	 echo "Cuje se specifican zvuk ferceranja";
 }
 
 function example_add_dashboard_widgets() {
 	wp_add_dashboard_widget( 'example_dashboard_widget', 'Prva WoprdUp konferencija', 'example_dashboard_widget_function' );
 	
 	// Globalize the metaboxes array, this holds all the widgets for wp-admin
 
 	global $wp_meta_boxes;
 	
 	// Get the regular dashboard widgets array 
 	// (which has our new widget already but at the end)
 
 	$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
 	
 	// Backup and delete our new dashboard widget from the end of the array
 
 	$example_widget_backup = array( 'example_dashboard_widget' => $normal_dashboard['example_dashboard_widget'] );
 	unset( $normal_dashboard['example_dashboard_widget'] );
 
 	// Merge the two arrays together so our widget is at the beginning
 
 	$sorted_dashboard = array_merge( $example_widget_backup, $normal_dashboard );
 
 	// Save the sorted array back into the original metaboxes 
 
 	$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
} 
 add_action( 'wp_dashboard_setup', 'word_up_dashboard_panel' );
 add_action( 'wp_dashboard_setup', 'example_add_dashboard_widgets' );
 
 ######################################################################################################################
 
 //add_shortcode('rss-subscribe', 'rss_subscribe_link');
 
  //[postlist title="Radim"]
 function list_posts (){
	 ?>
	 
	 <div class="su-posts su-posts-single-post">
	<?php
		// Prepare marker to show only one post
		$first = true;
		// Posts are found
		if ( $posts->have_posts() ) {
			while ( $posts->have_posts() ) :
				$posts->the_post();
				global $post;

				// Show oly first post
				if ( $first ) {
					$first = false;
					?>
					<div id="su-post-<?php the_ID(); ?>" class="su-post">
						<h1 class="su-post-title"><?php the_title(); ?></h1>
						<div class="su-post-meta"><?php _e( 'Posted', 'su' ); ?>: <?php the_time( get_option( 'date_format' ) ); ?> | <a href="<?php comments_link(); ?>" class="su-post-comments-link"><?php comments_number( __( '0 comments', 'su' ), __( '1 comment', 'su' ), __( '%n comments', 'su' ) ); ?></a></div>
						<div class="su-post-content">
							<?php the_content(); ?>
						</div>
					</div>
					<?php
				}
			endwhile;
		}
		// Posts not found
		else {
			echo '<h4>' . __( 'Posts not found', 'su' ) . '</h4>';
		}
	?>
</div>
	 <?php 
	 
 } 
 function postlist_func( $atts ) {
	$atts = shortcode_atts( array(
		'title' => 'no noo',
		
	), $atts, 'postlist' );

	return "<h4>{$atts['title']}</h4>";
}
add_shortcode( 'postlist', 'bartag_func' );
############################################################

add_filter( 'the_content', 'my_the_content_filter' );

function my_the_content_filter($content) {

  return $content. "Sad ga vidis sad ga ne vidis";
}

###############################################################


function load_custom_wp_admin_style() {
        wp_register_style( 'custom_wp_admin_css', get_template_directory_uri() . '/admin-style.css', false, '1.0.0' );
        wp_enqueue_style( 'custom_wp_admin_css' );
}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );


#############################################################

function theme_name_scripts() {
	wp_enqueue_style( 'style-name', get_stylesheet_uri() );
	wp_enqueue_script( 'script-name', get_template_directory_uri() . '/js/example.js', array(), '1.0.0', true );
}

add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );