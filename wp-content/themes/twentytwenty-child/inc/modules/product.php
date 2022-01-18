<?php

namespace TwentyTwentyChild\Modules;

use WP_Post;

class Product
{
    private $price = 0;
    private $sale_price = 0;

    private $gallery = [];

    private $on_sale = false;
    private $youtube_link = '';


    protected $id = 0;
    protected $post = null;
    protected $data = [];

    public function __construct($args)
    {
        if ($args instanceof WP_Post) {
            $this->post = $args;
            $this->id = $args->ID;

            $this->get_data();
        } else if (is_numeric($args)) {
            $this->post = get_post($args);
            if ($this->post) {
                $this->id = $this->post->ID;
                $this->get_data();
            }
        }
    }

    private function get_data()
    {
        $this->price = floatval(get_post_meta($this->id, 'product_price', true)) || 0;
        $this->sale_price = floatval(get_post_meta($this->id, 'product_sale_price', true)) || 0;
        $this->on_sale = boolval(get_post_meta($this->id, 'product_is_on_sale', true)) || false;
        $this->youtube_link = get_post_meta($this->id, 'product_youtube_link', true) || '';
        $this->gallery = $this->get_gallery_attachments();
    }

    private function get_gallery_attachments()
    {
        $images_ids = explode(',', get_post_meta($this->id, 'product_gallery', true));

        if (!empty($images_ids)) {
            return get_posts(array(
                'post_type' => 'attachment',
                'orderby' => 'post__in',
                'order' => 'ASC',
                'post__in' => $images_ids,
                'numberposts' => -1,
                'post_mime_type' => 'image'
            ));
        }

        return [];
    }

    public function get_price()
    {
        return $this->price;
    }

    public function get_sale_price()
    {
        return $this->sale_price;
    }

    public function get_gallery()
    {
        return $this->gallery;
    }

    public function is_on_sale()
    {
        return $this->on_sale;
    }

    public function get_youtube_link()
    {
        return $this->youtube_link;
    }

    public function get_youtube_link_id()
    {
        $youtube_link = $this->youtube_link;

        if (!empty($youtube_link)) {
            preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user|shorts)\/))([^\?&\"'>]+)/", $youtube_link, $matches);
            $id = $matches[1];
            return $id;
        }

        return false;
    }

    public function get_related_products_query_args()
    {
        $product_categories = wp_get_post_terms($this->id, 'product_category');
        $product_categories_slugs = wp_list_pluck($product_categories, 'slug');

        return array(
            'post_type' => 'products',
            'order' => 'ASC',
            'posts_per_page' => -1,
            'post__not_in' => array($this->id),
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_category',
                    'field' => 'slug',
                    'terms' => $product_categories_slugs
                )
            )
        );
    }
}
