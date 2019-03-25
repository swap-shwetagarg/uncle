<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Single Posts Template
 *
 *
 * @file           single.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2014 CyberChimps
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/responsive/single.php
 * @link           http://codex.wordpress.org/Theme_Development#Single_Post_.28single.php.29
 * @since          available since Release 1.0
 */

get_header(); ?>

	<?php if ( have_posts() ) : ?>

		<?php while( have_posts() ) : the_post(); ?>
 
               <div class="page-head">
		            <div class="center-wr clearfix">
					   <a href="https://www.unclefitter.com">Home > </a><a href="<?php echo home_url( '/' ); ?>">Blog ></a> <h1><?php the_title(); ?></h1>
					</div>
				</div>

			<?php responsive_entry_before(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php responsive_entry_top(); ?>
				<div class="post-entry post-content-mainwrap">
				   <div class="center-wr clearfix">
					<div class="blog-single-content-sec">
					  <div class="blog-single-content-sec-inner">
					        <?php if ( has_post_thumbnail() ) : 
						         $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'resize-856x380'); ?>
						        
					           	<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
					           	<div class="singlpost-img-block">
							     <img class="slide-image-single" src="<?php echo $large_image_url[0];?>" alt="<?php the_title(); ?>" />
							       <div class="post-imgoverlayer"></div>
							    </div>
						       </a>
						      
					         <?php endif; ?>
						       <h2> 
						         <?php the_title(); ?>
						      </h2>
						        <div class="singlpost-admin-date-bar">
						          <span class="post-author"><i class="fa fa-user" aria-hidden="true"></i> <?php the_author(); ?></span>
						          <span class="singlepost-date"><i class="fa fa-calendar-o" aria-hidden="true"></i> <?php echo get_the_date(); ?></span>
						          <span class="postcolor-line"></span>       
						        </div>
		                        <div class="post-data-s"><?php the_content(); ?></div>
		                        </div>
		                       <?php /* ?> <div class="comment-section">
			                        <?php responsive_comments_before(); ?>
				                    <?php comments_template( '', true ); ?>
				                    <?php responsive_comments_after(); ?>  
			                   </div>
			                   <?php */ ?>
                       </div>
                        <div class="blog-sidebar">
						    <?php get_sidebar(); ?> 
						</div>
                      </div>
				

					<?php //wp_link_pages( array( 'before' => '<div class="pagination">' . __( 'Pages:', 'responsive' ), 'after' => '</div>' ) ); ?>
				</div><!-- end of .post-entry -->

				<?php //get_template_part( 'post-data', get_post_type() ); ?>

				<?php responsive_entry_bottom(); ?>
			</div><!-- end of #post-<?php the_ID(); ?> -->
			<?php responsive_entry_after(); ?>

			

		<?php
		endwhile;

	endif;
	?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
