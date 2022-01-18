<?

namespace TwentyTwentyChild;

use TwentyTwentyChild\Admin\Admin_Bar;
use TwentyTwentyChild\Modules\Product_Post;
use TwentyTwentyChild\Api;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

define('THEME__FILE__', __FILE__);
define('THEME_SLUG', "twentytwenty-child");
define('THEME_PLUGIN_BASE', plugin_basename(THEME__FILE__));
define('THEME_PATH', plugin_dir_path(THEME__FILE__));
define('THEME_ASSETS', get_stylesheet_directory_uri() . '/assets');

class Theme
{
    public $api = null;

    public function __construct()
    {
        $this->init();
    }

    private function init()
    {
        $this->register_autoloader();

        $this->api = new Api();
        $this->api->init();

        new Admin_Bar();
        new Product_Post();

        add_action('wp_enqueue_scripts', [$this, 'enqueue_theme']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_styles']);
        add_action('pre_get_posts', [$this, 'modify_main_query']);
        add_action('wp_head', [$this, 'custom_color_mobile_address_bar']);
    }

    public function modify_main_query($query)
    {
        if (!is_admin() && $query->is_main_query())
            $query->set('post_type', 'products');
    }

    private function register_autoloader()
    {
        require_once THEME_PATH . '/autoloader.php';
        Autoloader::run();
    }

    public function enqueue_theme()
    {
        wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
        wp_enqueue_script('script', THEME_ASSETS . '/scripts.js', array('jquery'));
    }

    public function enqueue_admin_styles()
    {
        wp_enqueue_style('admin-style', THEME_ASSETS . '/admin.css');
    }

    public function custom_color_mobile_address_bar()
    {
        echo '<meta name="theme-color" content="#ff0000" />';
    }
}

new Theme();
