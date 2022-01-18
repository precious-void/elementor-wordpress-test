<?

namespace TwentyTwentyChild\Modules;

class Product_Taxanomy
{
    public function __construct()
    {
        add_action('init', [$this, 'create_prouducts_taxonomy']);
    }

    public function create_prouducts_taxonomy()
    {
        $labels = array(
            'name' => _x('Categories', 'Taxonomy General Name', THEME_SLUG),
            'singular_name' => _x('Category', 'Taxonomy Singular Name', THEME_SLUG),
            'search_items' =>  __('Search Categories', THEME_SLUG),
            'all_items' => __('All Categories', THEME_SLUG),
            'edit_item' => __('Edit Category', THEME_SLUG),
            'update_item' => __('Update Category', THEME_SLUG),
            'add_new_item' => __('Add New Category', THEME_SLUG),
            'new_item_name' => __('New Category Name', THEME_SLUG),
            'menu_name' => __('Categories', THEME_SLUG),
        );

        // Now register the taxonomy
        register_taxonomy('product_category', array('products'), array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_in_rest' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'product_category'),
        ));
    }
}
