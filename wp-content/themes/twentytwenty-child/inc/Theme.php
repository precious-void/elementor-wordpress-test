<?

namespace TwentyTwentyChild;

class Theme
{

    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        $this->init_actions();
        $this->init_filters();
    }

    private function init_actions()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_parent_styles']);
    }

    private function init_filters()
    {
        add_filter('show_admin_bar', [$this, 'hide_bar_for_wp_test_user']);
    }

    public function enqueue_parent_styles()
    {
        wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    }

    public function hide_bar_for_wp_test_user()
    {
        $user = wp_get_current_user();
        if ($user->user_login === "wp-test") {
            return false;
        }
        return true;
    }
}

new Theme();
