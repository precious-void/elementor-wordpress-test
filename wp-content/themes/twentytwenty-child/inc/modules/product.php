<?php

namespace TwentyTwentyChild\Modules;

use WP_Post;

class Product
{
    /**
     * Product title
     * @var int
     */
    private $title = '';

    /**
     * Product description
     * @var int
     */
    private $description = '';

    /**
     * Product price
     * @var int
     */
    private $price = 0;

    /**
     * Product image url
     * @var int
     */
    private $image_url = '';

    /**
     * Product price
     * @var int
     */
    private $sale_price = 0;

    /**
     * Gallery images
     * @var array[WP_Attachment]
     */
    private $gallery = [];

    /**
     * Is product on sale
     * @var bool
     */
    private $on_sale = false;

    /**
     * Youtube link
     * @var youtube_link
     */
    private $youtube_link = '';

    /**
     * Post ID
     * @var int
     */
    protected $id = 0;

    /**
     * Post Object
     * @var null|WP_Post
     */
    protected $post = null;

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
        $this->title = get_the_title($this->id);
        $this->description = get_the_content(null, false, $this->id);
        $this->image_url = $this->post->post_content;

        $this->price = intval(get_post_meta($this->id, 'product_price', true)) ?: 0;
        $this->sale_price = intval(get_post_meta($this->id, 'product_sale_price', true)) ?: 0;
        $this->on_sale = boolval(get_post_meta($this->id, 'product_is_on_sale', true)) ?: false;

        $this->youtube_link = get_post_meta($this->id, 'product_youtube_link', true) ?: '';
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

    public function get_id()
    {
        return $this->id;
    }

    public function get_title()
    {
        return $this->title;
    }

    public function get_description()
    {
        return $this->description;
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

    public function get_as_array()
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'image' => $this->image_url,
            'price' => $this->price,
            'sale_price' => $this->sale_price,
            'is_on_sale' => $this->on_sale,
        ];
    }
}
