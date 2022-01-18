<?

namespace TwentyTwentyChild\Admin;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Admin_Bar
{
    public function __construct()
    {
        add_filter('show_admin_bar', [$this, 'hide_bar_for_wp_test_user']);
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
