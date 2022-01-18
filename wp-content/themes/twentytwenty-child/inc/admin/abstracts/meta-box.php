<?php

namespace TwentyTwentyChild\Admin\Abstracts;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

abstract class Meta_Box
{
    /**
     * id of the meta box
     * @var string
     */
    protected $id;

    /**
     * title of the meta box
     * @var string
     */
    protected $title;

    /**
     * Post type the meta box is for
     * @var string
     */
    protected $post_type;

    /**
     * Position of the meta box would be displayed at
     * ex: advanced, side, normal
     * @var string
     */
    protected $context;

    /**
     * Priority of the meta box 
     * @var string
     */
    protected $priority;

    /**
     * Array of initialized fields
     * @var array
     */
    protected $fields = [];

    /**
     * Callback arguments for the meta box
     * @var null|array
     */
    protected $callback_args = null;

    /**
     * Constructor
     * 
     * @param string $id        - id
     * @param string $title     - title
     * @param string $post_type - post type
     * @param string $context   - context
     * @return void
     */
    public function __construct($id, $title, $post_type, $context = 'advanced', $priority = 'default', $callback_args = null)
    {
        $this->id               = $id;
        $this->title            = $title;
        $this->post_type        = $post_type;
        $this->context          = $context;
        $this->priority         = $priority;
        $this->callback_args    = $callback_args;

        $this->init();
    }

    /**
     * Initiate the meta box
     * @return void
     */
    private function init()
    {
        add_action('admin_init', [$this, 'set_fields']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_meta_box_scripts']);
        add_action('add_meta_boxes', [$this, 'create_meta_box']);
    }

    /**
     * Set fields controlls
     * @return void
     */
    abstract public function set_fields();

    /**
     * Get fields controlls
     * @return array
     */
    public function get_fields()
    {
        return $this->fields;
    }

    /**
     * Meta box injection
     * @param array|null $args
     * @return void
     */
    abstract public function meta_box_injection($args);


    /**
     * Enqueues scripts and styles for the meta box
     * @return void
     */
    public function enqueue_meta_box_scripts()
    {
    }

    /**
     * Enqueues scripts and styles for the meta box
     * @return void
     */
    public function create_meta_box()
    {
        add_meta_box(
            $this->id,
            $this->title,
            [$this, 'meta_box_injection'],
            $this->post_type,
            $this->context,
            $this->priority,
            $this->callback_args
        );
    }
}
