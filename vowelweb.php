<?php
/*
Plugin Name: vowelweb Portfolio Plugin
Plugin URI: https://vowelweb.com/
Description: Task
Version: 0.0.1
Author: Manoj Khande
Author URI: https://profiles.wordpress.org/manojkhande

Instructions:
1. Add sliders with images
2. Add Shortcode [VowelWebSlider] in post or pages

*/

class VowelWeb{
	/**
	 * Function init
	 * Function to registre hooks
	 */  
	public function init()
    {
    	add_action( 'init', array($this,'register_slider_post_type') );
    	add_shortcode( 'VowelWebSlider', array($this,'VowelWebSlider') );
    	add_action( 'wp_enqueue_scripts', array($this,'child_enqueue_styles'));
    }

    /**
	 * Function child_enqueue_styles
	 * Function to REGISTER and enqueue script and styles
	 */ 
    function child_enqueue_styles() {

    	wp_register_style( 'vowelwebcss', plugin_dir_url( __FILE__ ) . 'vowelweb.css', array() );
		wp_enqueue_style( 'vowelwebcss');

		wp_register_script( 'vowelweb', plugin_dir_url( __FILE__ ) . 'vowelweb.js', array('jquery') );
		wp_enqueue_script( 'vowelweb' );
	}

    /**
	 * Function register_slider_post_type
	 */ 
    function register_slider_post_type() {
	    register_post_type( 'vowelweb_slider',
		    array(
		      'labels' => array(
		        'name' => __( 'Sliders' ),
		        'singular_name' => __( 'Slider' )
		      ),
		      'supports' => array('title','editor','excerpt','thumbnail'),
		      'public' => true,
		      'has_archive' => true,
		    )
		  );
	}

	/**
	 * Function VowelWebSlider
	 * Function to output slider
	 */  
	function VowelWebSlider( $atts ){
		ob_start();
		// Query to get posts
		$query = new WP_Query( array( 'post_type' => 'vowelweb_slider' ) );
		if ( $query->have_posts() ) : ?>
			<div id="slider">
				<a href="#" class="control_next">></a>
				<a href="#" class="control_prev"><</a>
				<ul>
					<?php while ( $query->have_posts() ) : $query->the_post();
		    			if(has_post_thumbnail()){
		    				 $image = wp_get_attachment_image_src(get_post_thumbnail_id($query->post->ID),"full");
		    				?>
				    		<li style="background-image: url(<?php echo $image[0] ?>);">
				    			<a href="<?= get_the_permalink() ?>">
				    				<?php echo get_the_title();?>
				    			</a>
				    		</li>
				    		</a>
		    			<?php
		    			} ?>
		    		<?php endwhile; wp_reset_postdata(); ?>
		     	</ul>
		    </div>
		<?php
		endif;

		$content = ob_get_clean();

		return $content;
	}
	
}
$Wordcamp = new VowelWeb;
$Wordcamp->init();
