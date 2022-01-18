<?php

$product = $args['product'];
?>
<div <?php post_class(['single-product', 'product']); ?> id="post-<?php the_ID(); ?>">
    <div class="single-product__media">
        <?php get_template_part('template-parts/product/parts/image', 'gallery', ['product' => $product]); ?>
    </div>
    <div class="single-product__content">
        <?php

        if ($product->is_on_sale()) echo '<div class="product__badge">ON SALE!!!</div>';
        get_template_part('template-parts/product/parts/title', null, ['product' => $product]);
        get_template_part('template-parts/product/parts/price', null, ['product' => $product]);
        get_template_part('template-parts/product/parts/description', null, ['product' => $product]);
        ?>
    </div>
</div>