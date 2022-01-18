<?php

namespace TwentyTwentyChild;

defined('ABSPATH') || exit;

use TwentyTwentyChild\Modules\Product_Controller;

class Api
{
    /**
     * REST API namespaces and endpoints.
     *
     * @var array
     */
    protected $controllers = [];

    /**
     * Hook into WordPress ready to init the REST API as needed.
     */
    public function init()
    {
        add_action('rest_api_init', [$this, 'register_rest_routes'], 10);
    }

    /**
     * Register REST API routes.
     */
    public function register_rest_routes()
    {
        $this->controllers['products']['products_controller'] = (new Product_Controller())->register_routes();
    }
}
