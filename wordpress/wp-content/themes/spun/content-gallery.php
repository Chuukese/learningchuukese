<?php
/**
 * @package Spun
 * @since Spun 1.0
 */

global $post;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="single-gallery">
		<?php echo do_shortcode( '[gallery type="rectangular" captiontag="0" columns="4"]' ); ?>
	</div>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->
	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
			<span class="comments-link">
				<a href="#comments-toggle">
					<span class="tail"></span>
					<?php echo comments_number( __( '+', 'spun' ), __( '1', 'spun' ), __( '%', 'spun' ) ); ?>
				</a>
			</span>
		<?php endif; ?>
		<span class="post-date">
			<?php spun_posted_on(); ?>
		</span>
		<?php
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( __( ', ', 'spun' ) );
			if ( $categories_list && spun_categorized_blog() ) :
		?>
		<span class="cat-links">
			<?php printf( __( '%1$s', 'spun' ), $categories_list ); ?>
		</span>
		<?php endif; // End if categories ?>

		<?php
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', __( ', ', 'spun' ) );
			if ( $tags_list ) :
		?>

		<span class="tags-links">
			<?php printf( __( '%1$s', 'spun' ), $tags_list ); ?>
		</span>
		<?php endif; // End if $tags_list ?>

		<?php edit_post_link( __( 'Edit', 'spun' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->
