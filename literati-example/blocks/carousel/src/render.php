<?php
/**
 * Carousel block dynamic render markup.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 *
 * @package Literati\Example
 */

$swiper_attr = array(
	'autoplay' => array(
		'delay' => $attributes['autoplaySpeed'],
	),
);
$swiper_attr = htmlspecialchars( wp_json_encode( $swiper_attr ) );

$promotion_query = new WP_Query(
	array(
		'post_type'      => 'promotion',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
	)
);

$slides = $attributes['slides'];
?>
<div <?php echo get_block_wrapper_attributes(); // phpcs:ignore ?> >
	<div class="carousel-items swiper" data-swiper="<?php echo esc_attr( $swiper_attr ); ?>">
		<div class="swiper-wrapper carousel-items__wrapper">
			<?php
			if ( $promotion_query->have_posts() ) :
				while ( $promotion_query->have_posts() ) :
					$promotion_query->the_post();
					$promotion_id = get_the_ID();
					?>
					<div class="carousel-item swiper-slide">
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="carousel-item__img">
								<?php the_post_thumbnail( 'full' ); ?>
							</div>
						<?php endif; ?>
						<div class="carousel-item__content">
							<h3 class="carousel-item__heading"><?php the_title(); ?></h3>
							<p class="carousel-item__text"><?php echo esc_html( get_post_meta( $promotion_id, '_promotion_text', true ) ); ?></p>
							<a href="<?php the_permalink(); ?>" class="btn btn--read-more carousel-item__link"><?php echo esc_html( get_post_meta( $promotion_id, '_promotion_button', true ) ); ?></a>
						</div>
					</div>
					<?php
				endwhile;
			endif;
			wp_reset_postdata();
			?>
		</div>
		<div class="swiper-navigation">
			<div class="swiper-button-prev">
				<svg width="19" height="30" viewBox="0 0 19 30" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M15 26L4.36357 14.9696L14.9937 4.3792" stroke="#F5F5F5" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</div>
			<div class="swiper-button-next">
				<svg width="19" height="30" viewBox="0 0 19 30" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M4 4L14.6364 15.0304L4.00634 25.6208" stroke="#F5F5F5" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</div>
		</div>
	</div>
</div>
