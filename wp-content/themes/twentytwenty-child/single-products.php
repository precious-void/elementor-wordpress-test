<?php

use TwentyTwentyChild\Modules\Product;

$product = new Product($post);

/**
 * The template for displaying single posts and pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

get_header();
?>

<main id="site-content" role="main">
    <div class="section-inner medium">

        <?php
        the_post();
        $product = new Product($post);
        get_template_part('template-parts/product/item', 'single', ['product' => $product]);
        ?>
    </div>
    <?php

    $wp_query = new WP_Query($product->get_related_products_query_args());
    if ($wp_query->have_posts()) {
        echo '<div class="section-inner medium"><hr><h2 style="text-agign: center">Related Products</h2></div>';
        get_template_part('template-parts/content-products', null);
    }
    ?>
</main><!-- #site-content -->

<?php get_template_part('template-parts/footer-menus-widgets'); ?>

<?php get_footer(); ?>