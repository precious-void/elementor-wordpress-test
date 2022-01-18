<?php

use TwentyTwentyChild\Modules\Product;

$product = new Product($post);

?>
<div class="section-inner medium products-grid">
    <?php
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            $product = new Product($post);
            get_template_part('template-parts/product/item', null, ['product' => $product]);
        }
    }
    ?>
</div>