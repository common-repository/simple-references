<?php
/*
Plugin Name: Simple References 
Plugin URI: http://funandprog.fr
Description: This plugin permit to approuve your gestion of your client (or references).
Version: 0.2
Author: FunAndProg(BECUWE Adrien) 
Author URI: http://funandprog.fr
*/
define("SLUG_REF", "fnp_references");
define("LABEL_REF", "References");
define("FNP_SHORTNAME", "fnp");
add_action('init', 'fnp_simple_references');
require_once("simple_references_options.php");

function fnp_simple_references()
{
	add_theme_support( 'post-thumbnails' );
	
	register_post_type(SLUG_REF, array(
	  'label' => LABEL_REF,
	  'singular_label' => __('references'),
	  'public' => true,
	  'show_ui' => true,
	  'capability_type' => 'post',
	  'hierarchical' => false,
	  'supports' => array('title', 'excerpt', 'editor', 'thumbnail'),
	  'menu_icon' => plugins_url( '/images/icon-clients_light.png', __FILE__ )
	));
	
	$options  = get_option( 'fnp_options' ); 
	$use_tags = (isset($options['use_tags']) ? $options['use_tags'] : false);
	$use_cats = (isset($options['use_cats']) ? $options['use_cats'] : false);
	
	if(!empty($use_cats))
	{
		register_taxonomy( 'fnp_categories', 'fnp_references', array( 'hierarchical' => true, 'label' => 'Categories', 'query_var' => true, 'rewrite' => true ) );  
	}
	if(!empty($use_tags))
	{
		register_taxonomy( 'fnp_tags', 'fnp_references', array( 'hierarchical' => false, 'label' => 'Tags', 'query_var' => true, 'rewrite' => true ) );
	}
}




add_action('admin_menu', 'fnp_register_custom_menu_page');

//register settings
function fnp_options_init(){
    register_setting( 'fnp_options', 'fnp_options' );
}
//add actions
add_action( 'admin_init', 'fnp_options_init' );

function fnp_register_custom_menu_page() {
   	add_submenu_page("edit.php?post_type=fnp_references", 'Options', 'Options', 'administrator', basename(__FILE__), 'fnp_options');
}

function fnp_scripts_basic()  
{  
	wp_enqueue_script( 'jquery' ); 
	// Register the script like this for a plugin:  
	wp_register_script( 'jquery.bxslider', plugins_url( '/js/jquery.bxslider.min.js', __FILE__ ) );  
	
	// For either a plugin or a theme, you can then enqueue the script:  
	wp_enqueue_script( 'jquery.bxslider' ); 

	wp_register_style( 'jquery.bxslider', plugins_url('/css/jquery.bxslider.css', __FILE__) );
	wp_register_style( 'fnp_references', plugins_url('/css/fnp_references.css', __FILE__) );

	wp_enqueue_style( 'fnp_references' );
    wp_enqueue_style( 'jquery.bxslider' );
}  
add_action( 'wp_enqueue_scripts', 'fnp_scripts_basic' );  


/**
* Get All References .
*
* @param string $limit Limit or all references.
* @param string $post_per_page Limit Or post per page;
* @param string $miniature use the minature ?.
* @param string $link Link ?.
* @param string $sizew Width size of the minature.
* @param string $sizeh  Height size of the minature.
* @param string $sliderJs use the bxSlider?.
**/
function fnp_get_references($limit=-1, $post_per_page=10, $miniature=true, $link=true, $sizew=140, $sizeh=140,$cssClass="fnp_thumb img_black", $sliderJs=true)
{
	$param = array( 
		'post_type' 	 => 'fnp_references',
		'showposts' 	 => $limit,
		'posts_per_page' => $post_per_page,
		'order' 		 => 'ASC' 
	);
	$my_query = null;

	$my_query = new WP_Query($param);
	$classSlider = "bxslider";
	if(empty($sliderJs))
	{
		$classSlider = "nobxslider";
	}
	else
	{
	
	}
	
	if( $my_query->have_posts() ) {
	?>
	<ul class="<?php echo $classSlider; ?>">
	<?php
		while ($my_query->have_posts()) : $my_query->the_post(); ?>
			<li>
				<?php if($link):?>
				<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
				<?php endif; ?>
				<?php if(!empty($miniature)): ?>
					<?php  
							$id = get_post_thumbnail_id();
							$img = wp_get_attachment_image_src( $id,"full" );
					?>
					<img class="<?php echo $cssClass; ?>" src="<?php echo plugins_url( '/script/timthumb.php', __FILE__ ) ?>?src=<?php echo $img[0] ?>&amp;w=<?php echo $sizew; ?>&amp;h=<?php echo $sizeh; ?>&amp;q=100&amp;zc=3" />
				<?php else: ?>
					<?php the_title(); ?>
				<?php endif; ?>
				<?php if($link):?>
				</a>
				<?php endif; ?>
			</li>
		<?php
		endwhile;
	?>
	</ul>
	<?php
	?>
	<script type="text/javascript">
		jQuery(document).ready(function(){
		  jQuery('.bxslider').bxSlider({
			minSlides: <?php echo $post_per_page ?>,
			maxSlides: <?php echo $post_per_page ?>,
			slideWidth: <?php echo $sizew ?>,
			slideMargin: 0,
			auto: true, 
			autoControls: true,
			moveSlides:1
		  });
		});
		</script>
	<?php	
	}
	wp_reset_query();  // Restore global post data stomped by the_post().
}


/**
* Get All References by categories.
*
* @param string $category Slug categorie/tags or id.
* @param string $limit Limit or all references.
* @param string $post_per_page Limit Or post per page;
* @param string $miniature use the minature ?.
* @param string $link Link ?.
* @param string $sizew Width size of the minature.
* @param string $sizeh  Height size of the minature.
* @param string $sliderJs use the bxSlider?.
**/
function fnp_get_references_by_cat($category, $limit=-1, $post_per_page=10, $miniature=true, $link=true, $sizew=140, $sizeh=140, $cssClass="fnp_thumb img_black", $sliderJs=true)
{
	$param = array( 
		'post_type' 	 => 'fnp_references',
		'showposts' 	 => $limit,
		'posts_per_page' => $post_per_page,
		'tax_query' 	 => array(
			array( 'taxonomy' => 'fnp_categories', 'terms' => array( $category ) )
		),
		'order' 		 => 'ASC' 
	);
	$my_query = null;

	$my_query = new WP_Query($param);
	$classSlider = "bxslider";
	if(empty($sliderJs))
	{
		$classSlider = "nobxslider";
	}
	else
	{
	
	}
	
	if( $my_query->have_posts() ) {
	?>
	<ul class="<?php echo $classSlider; ?>">
	<?php
		while ($my_query->have_posts()) : $my_query->the_post(); ?>
			<li>
				<?php if($link):?>
				<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
				<?php endif; ?>
				<?php if(!empty($miniature)): ?>
					<?php  
							$id = get_post_thumbnail_id();
							$img = wp_get_attachment_image_src( $id,"full" );
					?>
					<img class="<?php echo $cssClass; ?>" src="<?php echo plugins_url( '/script/timthumb.php', __FILE__ ) ?>?src=<?php echo $img[0] ?>&amp;w=<?php echo $sizew; ?>&amp;h=<?php echo $sizeh; ?>&amp;q=100&amp;zc=3" />
				<?php else: ?>
					<?php the_title(); ?>
				<?php endif; ?>
				<?php if($link):?>
				</a>
				<?php endif; ?>
			</li>
		<?php
		endwhile;
	?>
	</ul>
	<?php
	?>
	<script type="text/javascript">
		jQuery(document).ready(function(){
		  jQuery('.bxslider').bxSlider({
			minSlides: <?php echo $post_per_page ?>,
			maxSlides: <?php echo $post_per_page ?>,
			slideWidth: <?php echo $sizew ?>,
			slideMargin: 0,
			auto: true, 
			autoControls: true,
			moveSlides:1
		  });
		});
		</script>
	<?php	
	}
	wp_reset_query();  // Restore global post data stomped by the_post().
}


/**
* Get All References by tags.
*
* @param string $category Slug tags or id.
* @param string $limit Limit or all references.
* @param string $post_per_page Limit Or post per page;
* @param string $miniature use the minature ?.
* @param string $link Link ?.
* @param string $sizew Width size of the minature.
* @param string $sizeh  Height size of the minature.
* @param string $sliderJs use the bxSlider?.
**/
function fnp_get_references_by_tags($tag, $limit=-1, $post_per_page=10, $miniature=true, $link=true, $sizew=140, $sizeh=140, $cssClass="fnp_thumb img_black", $sliderJs=true)
{
	$param = array( 
		'post_type' 	 => 'fnp_references',
		'showposts' 	 => $limit,
		'posts_per_page' => $post_per_page,
		'tax_query' 	 => array(
			array( 'taxonomy' => 'fnp_tags', 'terms' => array( $category ) )
		),
		'order' 		 => 'ASC' 
	);
	$my_query = null;

	$my_query = new WP_Query($param);
	$classSlider = "bxslider";
	if(empty($sliderJs))
	{
		$classSlider = "nobxslider";
	}
	else
	{
	
	}
	
	if( $my_query->have_posts() ) {
	?>
	<ul class="<?php echo $classSlider; ?>">
	<?php
		while ($my_query->have_posts()) : $my_query->the_post(); ?>
			<li>
				<?php if($link):?>
				<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
				<?php endif; ?>
				<?php if(!empty($miniature)): ?>
					<?php  
							$id = get_post_thumbnail_id();
							$img = wp_get_attachment_image_src( $id,"full" );
					?>
					<img class="<?php echo $cssClass; ?>" src="<?php echo plugins_url( '/script/timthumb.php', __FILE__ ) ?>?src=<?php echo $img[0] ?>&amp;w=<?php echo $sizew; ?>&amp;h=<?php echo $sizeh; ?>&amp;q=100&amp;zc=3" />
				<?php else: ?>
					<?php the_title(); ?>
				<?php endif; ?>
				<?php if($link):?>
				</a>
				<?php endif; ?>
			</li>
		<?php
		endwhile;
	?>
	</ul>
	<?php
	?>
	<script type="text/javascript">
		jQuery(document).ready(function(){
		  jQuery('.bxslider').bxSlider({
			minSlides: <?php echo $post_per_page ?>,
			maxSlides: <?php echo $post_per_page ?>,
			slideWidth: <?php echo $sizew ?>,
			slideMargin: 0,
			auto: true, 
			autoControls: true,
			moveSlides:1
		  });
		});
		</script>
	<?php	
	}
	wp_reset_query();  // Restore global post data stomped by the_post().
}

