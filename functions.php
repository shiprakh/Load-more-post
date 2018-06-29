<?php

function misha_my_load_more_scripts() {

	wp_register_script( 'my_loadmore', get_stylesheet_directory_uri() . '/js/loadmorepost.js', array('jquery') );

 /*?>wp_localize_script( 'twentysixteen-script', 'screenReaderText', array(
	'ajaxurl' => admin_url( 'admin-ajax.php' ),
	'noposts'  => esc_html__('No older posts found', 'twentysixteen'),
	'loadmore' => esc_html__('Load more', 'twentysixteen')
) );<?php */
 
 	wp_enqueue_script( 'my_loadmore' );
}
 
add_action( 'wp_enqueue_scripts', 'misha_my_load_more_scripts' );


function post_taxonomy_display()
{
	$id = $_POST['id'];
	$name = $_POST['name'];
	$postsPerPage = 3;
           
    $custom_terms = get_terms('sector');

	foreach($custom_terms as $custom_term) {
    		wp_reset_query();
    $args = array('post_type' => 'company',
	'posts_per_page' => $postsPerPage,
        'tax_query' => array(
            array(
                'taxonomy' => 'sector',
                'field' => 'slug',
                'terms' => $id,
            ),
        ),
     );

     $loop = new WP_Query($args);
     if($loop->have_posts()) {
		// $data .= ' <main id="main" class="site-main ajax_posts" role="main"> ';
		//$out = '<div class="post-rem"><div class="post-head"> <h3> </h3> </div> ';
		$out .= '<div class="elementor-widget-container">
			<div class="post-block-grid">
            <div class="card-deck loadmorediv">';
        while($loop->have_posts()) : $loop->the_post();
		//$out .= '<div class="post-body"> <a href="'.get_permalink().'">'.get_the_title().'</a><br></div>';
		$out .= '<div class="card feature-shade post-block">
            <a href="'.get_permalink().'">
              <div class="card-img-top featured-grid-background;" style="background: url(\''.get_the_post_thumbnail_url().'\');min-height:245px;background-size:cover;">
              </div>
              </a>
              <div class="card-body">
              <div class="entry-meta">May 16, 2018</div>
              <h5 class="card-title">
              <a href="'.get_permalink().'">'.get_the_title().'
              </a>
              </h5>
              <p class="post-excerpt">'.get_the_content().'</p>
<p>
<a class="read-more-post text-link" href="'.get_permalink().'">Read More</a></p>
</div>
</div>';
		//$out .= '  <div id="more_posts">'.$taxid.'</div>';
        endwhile;
		$out .= '</div></div></div>';
		//$out .= '';
		//$out .= '</div>';
		
		echo json_encode(array('status' => true , 'msg' => $out ));
		exit;
		
     }
	 else {
		
		 echo json_encode(array('status' => false));
		exit;
		 
		}
}     
        wp_reset_postdata();
		
}
add_action('wp_ajax_nopriv_post_taxonomy_display', 'post_taxonomy_display');
add_action('wp_ajax_post_taxonomy_display', 'post_taxonomy_display');



function post_taxonomy_display_load_more()
{
	$id = $_POST['id'];
	$name = $_POST['name'];
	$postsPerPage = 3;
	$offset = $_POST['offset'];
           
    $custom_terms = get_terms('sector');

	foreach($custom_terms as $custom_term) {
    		wp_reset_query();
    $args = array('post_type' => 'company',
	'posts_per_page' => $postsPerPage,
        'tax_query' => array(
            array(
                'taxonomy' => 'sector',
                'field' => 'slug',
                'terms' => $id,
            ),
        ),
		 'offset'          => $offset,
     );

     $loop = new WP_Query($args);
     if($loop->have_posts()) {
		// $data .= ' <main id="main" class="site-main ajax_posts" role="main"> ';
		//$out = '<div class="post-rem"><div class="post-head"> <h3> </h3> </div> ';
		//$out .= '';
        while($loop->have_posts()) : $loop->the_post();
		//$out .= '<div class="post-body"> <a href="'.get_permalink().'">'.get_the_title().'</a><br></div>';
		$out .= '<div class="card feature-shade post-block">
            <a href="'.get_permalink().'">
              <div class="card-img-top featured-grid-background;" style="background: url(\''.get_the_post_thumbnail_url().'\');min-height:245px;background-size:cover;">
              </div>
              </a>
              <div class="card-body">
              <div class="entry-meta">May 16, 2018</div>
              <h5 class="card-title">
              <a href="'.get_permalink().'">'.get_the_title().'
              </a>
              </h5>
              <p class="post-excerpt">'.get_the_content().'</p>
<p>
<a class="read-more-post text-link" href="'.get_permalink().'">Read More</a></p>
</div>
</div>';
		//$out .= '  <div id="more_posts">'.$taxid.'</div>';
        endwhile;
		//$out .= '</div></div></div>';
		//$out .= '';
		//$out .= '</div>';
		
		echo json_encode(array('status' => true , 'msg' => $out ));
		exit;
		
     }
	 else {
		
		 echo json_encode(array('status' => false  ));
		exit;
		 
		}
}     
        wp_reset_postdata();
		
}
add_action('wp_ajax_nopriv_post_taxonomy_display_load_more', 'post_taxonomy_display_load_more');
add_action('wp_ajax_post_taxonomy_display_load_more', 'post_taxonomy_display_load_more');











	

?>