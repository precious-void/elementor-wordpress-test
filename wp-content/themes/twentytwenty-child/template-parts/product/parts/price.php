<?php
$product = $args['product'];
?>

<p class="product__price">
    Price:
    <?php if ($product->is_on_sale()) : ?>
        <span class="product__price-sale"><?php echo $product->get_sale_price(); ?></span>
        <span class="product__price-regular"><?php echo $product->get_price(); ?></span>
    <?php else : ?>
        <?php echo $product->get_price(); ?>
    <?php endif; ?>
</p>