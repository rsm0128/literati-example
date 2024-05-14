<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

$swiper_attr = array(
	'autoplay' => array(
		'delay' => $attributes['autoplaySpeed'],
	)
);
$swiper_attr = htmlspecialchars( wp_json_encode( $swiper_attr ) );

$slides = $attributes['slides'];
?>
<div <?php echo get_block_wrapper_attributes(); ?> >
	<div class="carousel-items swiper" data-swiper="<?php echo esc_attr( $swiper_attr ); ?>">
		<div class="swiper-wrapper carousel-items__wrapper">
			<?php for ( $i = 0; $i < 2; $i++ ) : ?>
				<?php foreach ( $slides as $item ) : ?>
					<div class="carousel-item swiper-slide">
						<?php if ( $item['image']['url'] ) : ?>
							<div class="carousel-item__img">
								<img src="<?php echo esc_url( $item['image']['url'] ); ?>" alt="<?php echo esc_attr( $item['image']['alt'] ); ?>">
							</div>
						<?php endif; ?>
						<div class="carousel-item__content">
							<?php if ( $item['heading'] ) : ?>
								<h3 class="carousel-item__heading"><?php echo esc_html($item['heading']); ?></h3>
							<?php endif; ?>

							<?php if ( $item['content'] ) : ?>
								<p class="carousel-item__text"><?php echo esc_html($item['content']); ?></p>
							<?php endif; ?>

							<?php if ( $item['link']['url'] ) : ?>
								<a href="<?php echo esc_attr($item['link']['url']); ?>" class="btn btn--read-more carousel-item__link"><?php echo esc_html($item['link']['text']); ?></a>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			<?php endfor; ?>
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
