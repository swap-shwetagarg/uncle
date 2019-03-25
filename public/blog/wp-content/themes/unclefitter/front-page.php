<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Blog Template
 *
Template Name: Blog 
 *
 * @file           blog.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2014 CyberChimps
 * @license        license.txt
 * @version        Release: 1.1.0
 * @filesource     wp-content/themes/responsive/blog.php
 * @link           http://codex.wordpress.org/Templates
 * @since          available since Release 1.0
 */

get_header(); ?>
<div class="blogpage-mainwr">

	<?php if ( have_posts() ) : ?>

		<?php while( have_posts() ) : the_post(); ?>
          <div class="page-head">
            <div class="center-wr clearfix">
			   <a href="https://www.unclefitter.com/">Home ></a><?php get_template_part( 'post-meta', get_post_type() ); ?>
			</div>
		 </div>
  <!-- <h1 class="entry-title post-title newse-title"><?php //get_template_part( 'loop-header', get_post_type() ); ?></h1> -->
   <div class="blog-wrap">
        <div class="center-wr">
	        <div class="letest-articles">
	            <span class="bigline"></span>
	        	<h1>LATEST ARTICLES</h1>
	        </div>
        </div>
         <div class="center-wr">
          <div class="postgallery-masonary clearfix">
          <?php $args =	array(
				    'post_type' => 'post',
				    'posts_per_page' => -1,
				    'order' => 'asc'
				    );
	           $query = new WP_Query( $args ); 
	             if($query->have_posts()){
                    while ($query->have_posts()){ $query->the_post(); 
                    	?>
             
			<?php responsive_entry_before(); ?>
			<div class="clearfix blog-margin blogsection-wrap grid-item" id="post-<?php the_ID(); ?>">
             <div class="blog-image-sec">

             	<div class="post-entry">
					<?php if ( has_post_thumbnail() ) : 
						$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'resize-275x190'); ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				            <img class="slide-image" src="<?php echo $large_image_url[0];?>" alt="<?php the_title(); ?>" />
				            <div class="providing-imgoverlayer"></div>
						</a>
					<?php endif; ?>
					
				</div><!-- end of .post-entry -->
				</div>
				<div class="blog-content-sec">
				     <div class="post-titcont-wr">
				      <span class="post-date"> <?php echo get_the_date(); ?></span>
				       <h2> 
				          <a href="<?php the_permalink($post_id); ?>"><?php the_title(); ?></a>
				      </h2>
				      </div>						
                        <div class="post-data-s"><?php echo wp_trim_words( get_the_content(), 21, '...' );?></div>
                        <div class="auth-time-comm">
				          <span class="author-like"><a href="javascript:;"><i class="fa fa-thumbs-up" aria-hidden="true"></i></a></span>
				                 
				          <span class="author-comment"><a href="<?php the_permalink() ?>"><i class="fa fa-comments" aria-hidden="true"></i><?php echo get_comments_number(); ?></a> </span>
				           <span class="redmore">
						  	   <a href="<?php the_permalink() ?>"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
						   </span>
				        </div>

				       <?php /* <?php get_template_part( 'post-meta', get_post_type() ); ?> 
                         <?php the_content( __( 'Read more &#8250;', 'responsive' ) ); ?> */?>
					
			
				     <?php responsive_entry_bottom(); ?>
				 
				</div>
			</div><!-- end of #post-<?php the_ID(); ?> -->
			<?php responsive_entry_after(); ?>

		<?php
		   } // end of while
				                        
		 } // end of if  
	?>
<?php /*
<?php wp_link_pages( array( 'before' => '<div class="pagination">' . __( 'Pages:', 'responsive' ), 'after' => '</div>' ) ); ?> */?>
	<div class="pagination"> 
		<?php //wp_pagenavi() ?>  				
	</div>
  </div>
</div>
</div>
		<?php
		endwhile;

		get_template_part( 'loop-nav', get_post_type() );

	else :

		get_template_part( 'loop-no-posts', get_post_type() );

	endif;
	?>
</div>

<?php get_footer(); ?>
