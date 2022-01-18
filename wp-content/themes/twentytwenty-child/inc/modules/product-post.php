<?php

namespace TwentyTwentyChild\Modules;

use TwentyTwentyChild\Modules\Product_Taxanomy;
use TwentyTwentyChild\Admin\Metaboxes\Gallery as Gallery_Meta_Box;
use TwentyTwentyChild\Admin\Metaboxes\Settings as Settings_Meta_Box;

class Product_Post
{
    protected $labels = null;

    public function __construct()
    {
        new Product_Taxanomy();

        add_action('init', [$this, 'create_cpt']);
        $this->add_meta_boxes();
    }

    public function add_meta_boxes()
    {
        new Gallery_Meta_Box('product_gallery', 'Product Image Gallery (6 images)', 'products', 'side');
        new Settings_Meta_Box('product_settings', 'Product Settings', 'products');
    }

    public function create_cpt()
    {
        $labels = array(
            'name'                  => _x('Products', 'Post Type General Name', THEME_SLUG),
            'singular_name'         => _x('Product', 'Post Type Singular Name', THEME_SLUG),
            'menu_name'             => __('Products', THEME_SLUG),
            'all_items'             => __('All Products', THEME_SLUG),
            'view_item'             => __('View Product', THEME_SLUG),
            'add_new_item'          => __('Add New Product', THEME_SLUG),
            'add_new'               => __('Add New', THEME_SLUG),
            'edit_item'             => __('Edit Product', THEME_SLUG),
            'update_item'           => __('Update Product', THEME_SLUG),
            'search_items'          => __('Search Product', THEME_SLUG),
            'not_found'             => __('Not Found', THEME_SLUG),
            'not_found_in_trash'    => __('Not found in Trash', THEME_SLUG),
            'featured_image'        => __('Main Image', THEME_SLUG),
            'set_featured_image'    => __('Set main image', THEME_SLUG),
            'remove_featured_image' => _x('Remove main image', 'textdomain'),
            'use_featured_image'    => _x('User main image', 'textdomain'),
        );

        $args = array(
            'label'               => __('product', THEME_SLUG),
            'description'         => __('Products', THEME_SLUG),
            'labels'              => $labels,
            'supports'            => array(
                'title',
                'editor',
                'thumbnail',
                'revisions',
                'custom-fields'
            ),
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'post',
            'show_in_rest'        => true,

            'taxonomies'          => array('product_category'),
        );

        register_post_type('products', $args);
    }
}
