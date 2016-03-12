<?php
/**
 * Single Brand
 *
 * @usedby [product_brand]
 */
?>
<a class="brand" href="<?php echo get_term_link( $term,  'product_brand' ); ?>">
	<img src="<?php echo $thumbnail; ?>" alt="<?php echo $term->name; ?>" class="<?php echo $class; ?>" style="width: <?php echo $width; ?>; height: <?php echo $height; ?>;" />
</a>
