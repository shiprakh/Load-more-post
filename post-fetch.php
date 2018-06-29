<?php
/*
Template Name: Post Fetch
*/

get_header();

$container   = get_theme_mod( 'understrap_container_type' );

?>
<style>
.tax-post {
    display: block;
    float: left;
    padding: 10px;
    margin: 10px;
    cursor: pointer;
}
.category-list {
    border-bottom: 1px solid grey;
}
div#more_posts {
    cursor: pointer;
}
div#main {
    width: 100%;
    /* height: 100%; */
}
.post-block {
	width: 33.33%;
	max-width:30.33%;
	flex : none !important;
	margin-top:30px;	
}
.card-deck.loadmorediv {
    margin-top: 30px;
    margin-bottom: 30px;
}
#loaderimage_more,#loaderimage {
	 width: 100%;
    display: block;
	
}
/*.post-rem {
	overflow:scroll;
	max-height:500px;
	height:auto;}*/
</style>
<div class="wrapper" id="page-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">
    
    <div class="row">
               
        <?php
    $sector = array(
      'taxonomy'=>'sector',
      'child_of'=> 0,'parent'=> 0,
      'orderby'=> 'name',
      'show_count'=> 0,
      'pad_counts'=> 0,
      'hierarchical' => 0,
      'title_li'=> '',
      'hide_empty'=> 0
    );
    $sectors = get_categories( $sector );
    ?>
    <div class="category-list">
    <!--loop through the style and show it in a checkbox -->
    <?php foreach($sectors as $br){ 
    ?>
     
     <div class="tax-post" data-id="<?php echo $br->slug; ?>" data-taxname="<?php echo $br->name; ?>">
     <?php echo $br->name; ?> 
     </div> 
     <?php } ?>
           
       </div>    <!-- caztegory ;ist-end -->      
         
        <div class="ajaxpostload site-main ajax_posts" id="main" > 
        
         <div id="loaderimage">
            <img src="<?php echo get_stylesheet_directory_uri().'/images/loader.gif'; ?>" style="width: 40px;margin: 0 auto;display: block;" />
         </div>
         <div class="post-rem" data-offset="3">
         		<div class="elementor-widget-container">
			<div class="post-block-grid ">
            <div class="card-deck loadmorediv">
         <?php
         
           $custom_terms = get_terms('sector');
    
        //foreach($custom_terms as $custom_term) {
                wp_reset_query();
        $args = array('post_type' => 'company',
        'posts_per_page' => 3,
            'tax_query' => array(
                array(
                    'taxonomy' => 'sector',
                    'field' => 'slug',
                    'terms' => 'advanced-materials',
                ),
            ),
         );
    
         $loop = new WP_Query($args);
         if($loop->have_posts()) {
            // $data .= ' <main id="main" class="site-main ajax_posts" role="main"> ';
            //$out = '<div class="post-rem"><div class="post-head"> <h3> </h3> </div> ';
    
            while($loop->have_posts()) : $loop->the_post();
			?>
            <div class="card feature-shade post-block">
            <a href="<?php echo get_permalink(); ?>">
              <div class="card-img-top featured-grid-background;" style="background:url(<?php the_post_thumbnail_url(); ?>);min-height:245px;background-size:cover;">
             
              </div>
              </a>
              <div class="card-body">
              <div class="entry-meta">May 16, 2018</div>
              <h5 class="card-title">
              <a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?>
              </a>
              </h5>
              <p class="post-excerpt"><?php echo get_the_content(); ?></p>
<p>
<a class="read-more-post text-link" href="<?php echo get_permalink(); ?>">Read More</a></p>
</div>
</div>


	
			<?php		
              //  $out .= '<div class="post-body"> <a href="'.get_permalink().'">'.get_the_title().'</a><br></div>';
           
            endwhile;
            //$out .= '</div>';
          //  $out .= '<div class="load-btn" data-offset="3" data-postid=""> Load More </div>'; ?>
            
        <?php }
        
    //}    
  
            wp_reset_postdata();
        
            ?>
            </div></div></div>
            
      </div> <!-- post-rem end -->
      <div class="elementor-widget-container ajaxload" data-offset = "3" data-postslug = "advanced-materials" data-more = "">
					<div class="elementor-button-wrapper">
			<a href="" class="elementor-button-link elementor-button elementor-size-md" role="button">
						<span class="elementor-button-content-wrapper">
						<span class="elementor-button-text ">Load More</span>
		</span>
					</a>
		</div>
				</div>
                <div class="no_more_posts"> No posts under this category </div>
               <div id="loaderimage_more">
            <img src="<?php echo get_stylesheet_directory_uri().'/images/loader.gif'; ?>" style="width: 40px;margin: 0 auto;display: block;" />
         </div>
    </div>  <!-- ajaxpostload end -->
    
            <!-- Do the right sidebar check -->
            <?php get_template_part( 'global-templates/right-sidebar-check' ); ?>
    
        </div><!-- .row -->

</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php /*?> <span>
    <input name="<?php echo $br->term_id; ?>" type="checkbox"><?php echo $br->cat_name; ?>
 </span>
<?php */?>
            
<?php /*?><?php if(isset($_POST['filter'])){ ?>
 <?php 
   $sector=array();
   $cat_term=$_POST['term_id'];

   $sector_arg = array(
    'taxonomy'=>'sector',
    'child_of'=> 0,
    'parent'=> 0,
    'orderby'=> 'name',
    'show_count'=> 0,
    'pad_counts'=> 0,
    'hierarchical' => 0,
    'title_li'=> '',
    'hide_empty'=> 0
   );
  $sectors = get_categories( $sector_arg );
 
 
 //if sector is empty then choose all the brands
 if(count($_POST['sector'])==0){
   foreach($sectors as $a){
     array_push($sector,$a->term_id);
   }
 }
 if(count($_POST['sector'])!=0){
   $sector=$_POST['sector'];
 }
 
 $filter_set=true;
 ?>
 <!-- if filter set -->
 <?php if($filter_set){ ?>
 
 <?php 
   $args=array(
    'post_type'=>'company',
    'tax_query' => array(
    'relation' => 'AND',
       array(
         'taxonomy' => 'sector',
         'field' => 'term_id',
         'terms' => array($cat_term),
         'operator' => 'IN'
       )
    )
 );
 ?>
 <?php $the_query = new WP_Query( $args ); ?>
 <?php if ( $the_query->have_posts() ) : ?>
 <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
 <div class="single_prod">
   <div class="single_prod_top row">
     <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
   </div>
   <div class="single_prod_bot row">
     <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
   </div>
 </div>
 <?php endwhile; ?>
 <?php wp_reset_postdata(); ?>
 <?php else : ?>
 <p><?php _e( 'Sorry, no products matched your criteria.' ); ?></p>
 <?php endif; ?>
 <?php } ?>
 <?php } ?>

		</div><!-- #primary --><?php */?>
        

            


<?php get_footer(); ?>
