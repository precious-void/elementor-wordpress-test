<?php

namespace TwentyTwentyChild\Modules;

use TwentyTwentyChild\Modules\Product;

if (!defined('ABSPATH')) {
    exit;
}

class Product_Controller
{
    /**
     * Endpoint namespace.
     *
     * @var string
     */
    protected $namespace = 'products';

    /**
     * Register routes.
     */
    public function register_routes()
    {
        register_rest_route(
            $this->namespace,
            '/get_product_by_category',
            [
                [
                    'methods'             => \WP_REST_Server::READABLE,
                    'callback'            => [$this, 'get_product_by_category'],
                    'permission_callback' => '__return_true',
                    'args'                 => array(
                        'type'    => array(
                            'type'              => 'string',
                            'sanitize_callback' => 'sanitize_text_field',
                            'enum'              => array('id', 'name'),
                            'required'          => true,
                            'validate_callback' => [$this, 'enum_validate_callback'],
                        ),
                        'value' => array(
                            'required' => true

                        ),
                    ),
                ],
            ],
        );
    }

    public function enum_validate_callback($value, $request, $param)
    {
        if (!is_string($value)) {
            return new \WP_Error('rest_invalid_param', esc_html__('The filter argument must be a string.', THEME_SLUG), array('status' => 400));
        }
        $attributes = $request->get_attributes();
        $args = $attributes['args'][$param];
        if (!in_array($value, $args['enum'], true)) {
            return new \WP_Error('rest_invalid_param', sprintf(__('%s is not one of %s'), $param, implode(', ', $args['enum'])), array('status' => 400));
        }
    }

    /**
     * Get product by category name/id via API     
     * @param \WP_REST_Request $request
     */
    public function get_product_by_category(\WP_REST_Request $request)
    {
        $data = $request->get_params();
        $key = $data['type'];
        $value = $data['value'];

        $product_posts = new \WP_Query(array(
            'post_type' => 'products',
            'order' => 'ASC',
            'posts_per_page' => -1,
            'post__not_in' => array($this->id),
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_category',
                    'field' => $key,
                    'terms' => [$value]
                )
            )
        ));

        $products = array_map(function ($post_id) {
            return (new Product($post_id))->get_as_array();
        }, wp_list_pluck($product_posts->posts, 'ID'));

        return rest_ensure_response($products);
    }
}
