<?php
/**
 * Theme functions and definitions
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (!isset($content_width)) {
    $content_width = 800; // pixels
}

/*
 * Set up theme support
 */
if (!function_exists('damteq_theme_setup')) {
    function damteq_theme_setup()
    {
        if (apply_filters('damteq_theme_load_textdomain', true)) {
            load_theme_textdomain('damteq-theme', get_template_directory() . '/languages');
        }

        if (apply_filters('damteq_theme_register_menus', true)) {
            register_nav_menus(array('menu-1' => __('Primary', 'damteq')));
        }

        if (apply_filters('damteq_theme_add_theme_support', true)) {
            add_theme_support('post-thumbnails');
            add_theme_support('automatic-feed-links');
            add_theme_support('title-tag');
            add_theme_support('custom-logo');
            add_theme_support('html5', array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
            ));
            add_theme_support('custom-logo', array(
                'height' => 100,
                'width' => 350,
                'flex-height' => true,
                'flex-width' => true,
            ));

            /*
             * Editor Style
             */
            add_editor_style('editor-style.css');

            /*
             * WooCommerce
             */
            if (apply_filters('damteq_theme_add_woocommerce_support', true)) {
                // WooCommerce in general:
                add_theme_support('woocommerce');
                // Enabling WooCommerce product gallery features (are off by default since WC 3.0.0):
                // zoom:
                add_theme_support('wc-product-gallery-zoom');
                // lightbox:
                add_theme_support('wc-product-gallery-lightbox');
                // swipe:
                add_theme_support('wc-product-gallery-slider');
            }
        }
    }
}
add_action('after_setup_theme', 'damteq_theme_setup');

/*
 * Theme Scripts & Styles
 */
if (!function_exists('damteq_theme_scripts_styles')) {
    function damteq_theme_scripts_styles()
    {
        $min_suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

        if (apply_filters('damteq_theme_enqueue_style', true)) {
            wp_enqueue_style('damteq_theme-style', get_stylesheet_uri());
            wp_enqueue_style('damteq-styles', get_template_directory_uri() . '/assets/scss/style' . $min_suffix . '.css');
            wp_enqueue_style('theme-styles', get_template_directory_uri() . '/theme' . $min_suffix . '.css');

            wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js', '', '3.3.1', true);
            wp_enqueue_script('damteq-js', get_template_directory_uri() . '/assets/javascript/custom' . $min_suffix . '.js');
        }
    }
}
add_action('wp_enqueue_scripts', 'damteq_theme_scripts_styles');

/*
 * Register damteq Locations
 */
if (!function_exists('damteq_theme_register_damteq_locations')) {
    function damteq_theme_register_damteq_locations($damteq_theme_manager)
    {
        if (apply_filters('damteq_theme_register_damteq_locations', true)) {
            $damteq_theme_manager->register_all_core_location();
        }
    }
}
add_action('damteq/theme/register_locations', 'damteq_theme_register_damteq_locations');

/**
 * Adds acf theme options.
 *
 */
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => 'Theme Options',
        'icon_url' => 'dashicons-art',
        'position' => 3
    ));
}

/**
 * Acf theme options enqueue to wp_head()
 *
 */
function damteq_theme_head_script()
{ ?>
    <?php if (get_field('tracking_id', 'options')) : ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async
            src="https://www.googletagmanager.com/gtag/js?id=<?php the_field('tracking_id', 'options'); ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', '<?php the_field('tracking_id', 'options'); ?>'<?php if (get_field('google_optimise', 'options') ) : ?>, {'optimize_id': '<?php the_field('gtm_id', 'options'); ?>'}<?php endif; ?>);
    </script>
    <!-- End Global site tag (gtag.js) - Google Analytics -->
<?php endif; ?>

    <?php if (get_field('adwords_id', 'options')) : ?>
    <!-- Global site tag (gtag.js) - Google Ads -->
    <script async
            src="https://www.googletagmanager.com/gtag/js?id=<?php the_field('adwords_id', 'options'); ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', '<?php the_field('adwords_id', 'options'); ?>');
    </script>
    <!-- End Global site tag (gtag.js) - Google Ads -->
<?php endif; ?>

    <?php if (get_field('gtm_id', 'options')) : ?>
    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', '<?php the_field('gtm_id', 'options'); ?>');
    </script>
    <!-- End Google Tag Manager -->
<?php endif; ?>
    <!-- Google Phone Tracking -->
    <?php if (get_field('google_phone_conversion_id', 'options')) : ?>
    <script>
        gtag('config', '<?php the_field('adwords_id', 'options'); ?>/<?php the_field('google_phone_conversion_id', 'options'); ?>', {
            'phone_conversion_number': '<?php the_field('google_phone_conversion_number', 'options'); ?>'
        });
    </script>
    <!-- End Google Phone Tracking -->
<?php endif; ?>

    <!-- Header Script-->
    <?php
    the_field('header_scripts', 'options');
}

add_action('wp_head', 'damteq_theme_head_script');

/**
 * Acf theme options enqueue to wp_footer()
 *
 */
function damteq_theme_footer_script()
{
    the_field('footer_scripts', 'options');
}

add_action('wp_footer', 'damteq_theme_footer_script');

/**
 * Add Scripts to Elementor body (full width layout)
 *
 * @since 0.4.0
 */
function damteq_elementor_body_scripts()
{
    if (get_field('gtm_id', 'options')) :
        ?>
        <!-- Google Tag Manager (noscript) -->
        <noscript>
            <iframe src="https://www.googletagmanager.com/ns.html?id=<?php the_field('gtm_id', 'options') ?>"
                    height="0" width="0" style="display:none;visibility:hidden"></iframe>
        </noscript>
        <!-- End Google Tag Manager (noscript) -->
    <?php
    endif;

    the_field('conversion_tracking');
}

add_action('elementor/page_templates/header-footer/before_content', 'damteq_elementor_body_scripts', 0);

/**
 * Add Scripts to Elementor body (canvas width layout)
 *
 * @since 0.4.1
 */
function damteq_elementorcanvas_body_scripts()
{
    if (get_field('gtm_id', 'options')) :
        ?>
        <!-- Google Tag Manager (noscript) -->
        <noscript>
            <iframe src="https://www.googletagmanager.com/ns.html?id=<?php the_field('gtm_id', 'options') ?>"
                    height="0" width="0" style="display:none;visibility:hidden"></iframe>
        </noscript>
        <!-- End Google Tag Manager (noscript) -->
    <?php
    endif;

    the_field('conversion_tracking');
}

add_action('elementor/page_templates/canvas/before_content', 'damteq_elementorcanvas_body_scripts', 0);

// Register Custom Post Type Project
function create_project_cpt()
{

    $labels = array(
        'name' => _x('Projects', 'Post Type General Name', 'textdomain'),
        'singular_name' => _x('Project', 'Post Type Singular Name', 'textdomain'),
        'menu_name' => _x('Projects', 'Admin Menu text', 'textdomain'),
        'name_admin_bar' => _x('Project', 'Add New on Toolbar', 'textdomain'),
        'archives' => __('Project Archives', 'textdomain'),
        'attributes' => __('Project Attributes', 'textdomain'),
        'parent_item_colon' => __('Parent Project:', 'textdomain'),
        'all_items' => __('All Projects', 'textdomain'),
        'add_new_item' => __('Add New Project', 'textdomain'),
        'add_new' => __('Add New', 'textdomain'),
        'new_item' => __('New Project', 'textdomain'),
        'edit_item' => __('Edit Project', 'textdomain'),
        'update_item' => __('Update Project', 'textdomain'),
        'view_item' => __('View Project', 'textdomain'),
        'view_items' => __('View Projects', 'textdomain'),
        'search_items' => __('Search Project', 'textdomain'),
        'not_found' => __('Not found', 'textdomain'),
        'not_found_in_trash' => __('Not found in Trash', 'textdomain'),
        'featured_image' => __('Featured Image', 'textdomain'),
        'set_featured_image' => __('Set featured image', 'textdomain'),
        'remove_featured_image' => __('Remove featured image', 'textdomain'),
        'use_featured_image' => __('Use as featured image', 'textdomain'),
        'insert_into_item' => __('Insert into Project', 'textdomain'),
        'uploaded_to_this_item' => __('Uploaded to this Project', 'textdomain'),
        'items_list' => __('Projects list', 'textdomain'),
        'items_list_navigation' => __('Projects list navigation', 'textdomain'),
        'filter_items_list' => __('Filter Projects list', 'textdomain'),
    );
    $args = array(
        'label' => __('Project', 'textdomain'),
        'description' => __('', 'textdomain'),
        'labels' => $labels,
        'menu_icon' => 'dashicons-admin-generic',
        'supports' => array('title', 'editor', 'thumbnail', 'revisions'),
        'taxonomies' => array('projectcategory'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'hierarchical' => false,
        'exclude_from_search' => false,
        'show_in_rest' => true,
        'publicly_queryable' => true,
        'capability_type' => 'post',
    );
    register_post_type('project', $args);

}

add_action('init', 'create_project_cpt', 0);

// Register Taxonomy Project Category
function create_projectcategory_tax()
{

    $labels = array(
        'name' => _x('Project Categories', 'taxonomy general name', 'textdomain'),
        'singular_name' => _x('Project Category', 'taxonomy singular name', 'textdomain'),
        'search_items' => __('Search Project Categories', 'textdomain'),
        'all_items' => __('All Project Categories', 'textdomain'),
        'parent_item' => __('Parent Project Category', 'textdomain'),
        'parent_item_colon' => __('Parent Project Category:', 'textdomain'),
        'edit_item' => __('Edit Project Category', 'textdomain'),
        'update_item' => __('Update Project Category', 'textdomain'),
        'add_new_item' => __('Add New Project Category', 'textdomain'),
        'new_item_name' => __('New Project Category Name', 'textdomain'),
        'menu_name' => __('Project Category', 'textdomain'),
    );
    $args = array(
        'labels' => $labels,
        'description' => __('', 'textdomain'),
        'hierarchical' => false,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
        'show_in_quick_edit' => true,
        'show_admin_column' => false,
        'show_in_rest' => true,
    );
    register_taxonomy('projectcategory', array('project'), $args);

}

add_action('init', 'create_projectcategory_tax');

// Adds widget: ColtProjects
class Coltprojects_Widget extends WP_Widget
{

    function __construct()
    {
        parent::__construct(
            'coltprojects_widget',
            esc_html__('ColtProjects', 'damteq')
        );
    }

    private $widget_fields = array();

    public function widget($args, $instance)
    {
        echo $args['before_widget'];
        global $post;
        $args_office_query = array(
            'post_type' => 'project',
            'posts_per_page' => -1,
            'order' => 'ASC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'projectcategory',
                    'field' => 'ID',
                    'terms' => 6,
                    'operator' => 'NOT IN'
                ),
            ),
        );
        $office_query = new WP_Query($args_office_query); ?>

        <div class="project-card-container">
            <?php if ($office_query->have_posts()) : while ($office_query->have_posts()) : $office_query->the_post();
                $location = get_field('location', $post->ID);
                $info = get_field('info', $post->ID);
                $date = get_field('date', $post->ID);
                $cost = get_field('cost', $post->ID);
                ?>
                <div class="project-card">
                    <?php the_title('<h1>', '</h1>');
                    echo '<hr>';
                    echo '<span>' . $location . '</span>';
                    echo '<span>' . $info . '</span>';
                    if ($date) : echo '<span class="meta">' . $date . '</span>'; endif;
                    /*if ($cost) : echo '<span class="meta">' . '£' . number_format($cost, 0, '.', ',') . '</span>'; endif; */ ?>
                </div>

            <?php endwhile; endif; ?>
        </div>
        <?php echo $args['after_widget'];
    }

    public function field_generator($instance)
    {
        $output = '';
        foreach ($this->widget_fields as $widget_field) {
            $default = '';
            if (isset($widget_field['default'])) {
                $default = $widget_field['default'];
            }
            $widget_value = !empty($instance[$widget_field['id']]) ? $instance[$widget_field['id']] : esc_html__($default, 'damteq');
            switch ($widget_field['type']) {
                default:
                    $output .= '<p>';
                    $output .= '<label for="' . esc_attr($this->get_field_id($widget_field['id'])) . '">' . esc_attr($widget_field['label'], 'damteq') . ':</label> ';
                    $output .= '<input class="widefat" id="' . esc_attr($this->get_field_id($widget_field['id'])) . '" name="' . esc_attr($this->get_field_name($widget_field['id'])) . '" type="' . $widget_field['type'] . '" value="' . esc_attr($widget_value) . '">';
                    $output .= '</p>';
            }
        }
        echo $output;
    }

    public function form($instance)
    {
        $this->field_generator($instance);
    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        foreach ($this->widget_fields as $widget_field) {
            switch ($widget_field['type']) {
                default:
                    $instance[$widget_field['id']] = (!empty($new_instance[$widget_field['id']])) ? strip_tags($new_instance[$widget_field['id']]) : '';
            }
        }
        return $instance;
    }
}

function register_coltprojects_widget()
{
    register_widget('Coltprojects_Widget');
}

add_action('widgets_init', 'register_coltprojects_widget');

// Adds widget: Past Projects
class Pastprojects_Widget extends WP_Widget
{

    function __construct()
    {
        parent::__construct(
            'pastprojects_widget',
            esc_html__('Past Projects', 'damteq')
        );
    }

    private $widget_fields = array();

    public function widget($args, $instance)
    {
        echo $args['before_widget'];

        global $post;
        $args_office_query = array(
            'post_type' => 'project',
            'posts_per_page' => -1,
            'order' => 'ASC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'projectcategory',
                    'field' => 'ID',
                    'terms' => 6,
                    'operator' => 'IN'
                ),
            ),
        );
        $office_query = new WP_Query($args_office_query); ?>

        <div class="project-card-container">
            <?php if ($office_query->have_posts()) : while ($office_query->have_posts()) : $office_query->the_post();
                $location = get_field('location', $post->ID);
                $info = get_field('info', $post->ID);
                $date = get_field('date', $post->ID);
                $cost = get_field('cost', $post->ID);
                ?>
                <div class="project-card">
                    <?php the_title('<h1>', '</h1>');
                    echo '<hr>';
                    echo '<span>' . $location . '</span>';
                    echo '<span>' . $info . '</span>';
                    if ($date) : echo '<span class="meta">' . $date . '</span>'; endif;
                    /* if ($cost) : echo '<span class="meta">' . '£' . number_format($cost, 0, '.', ',') . '</span>'; endif; */ ?>
                </div>

            <?php endwhile; endif; ?>
        </div>

        <?php echo $args['after_widget'];
    }

    public function field_generator($instance)
    {
        $output = '';
        foreach ($this->widget_fields as $widget_field) {
            $default = '';
            if (isset($widget_field['default'])) {
                $default = $widget_field['default'];
            }
            $widget_value = !empty($instance[$widget_field['id']]) ? $instance[$widget_field['id']] : esc_html__($default, 'damteq');
            switch ($widget_field['type']) {
                default:
                    $output .= '<p>';
                    $output .= '<label for="' . esc_attr($this->get_field_id($widget_field['id'])) . '">' . esc_attr($widget_field['label'], 'damteq') . ':</label> ';
                    $output .= '<input class="widefat" id="' . esc_attr($this->get_field_id($widget_field['id'])) . '" name="' . esc_attr($this->get_field_name($widget_field['id'])) . '" type="' . $widget_field['type'] . '" value="' . esc_attr($widget_value) . '">';
                    $output .= '</p>';
            }
        }
        echo $output;
    }

    public function form($instance)
    {
        $this->field_generator($instance);
    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        foreach ($this->widget_fields as $widget_field) {
            switch ($widget_field['type']) {
                default:
                    $instance[$widget_field['id']] = (!empty($new_instance[$widget_field['id']])) ? strip_tags($new_instance[$widget_field['id']]) : '';
            }
        }
        return $instance;
    }
}

function register_pastprojects_widget()
{
    register_widget('Pastprojects_Widget');
}

add_action('widgets_init', 'register_pastprojects_widget');

/**
 *
 * @author Damteq®
 * @shortcode [colt_events]
 */
function create_coltevents_shortcode()
{
    ?>
    <style type="text/css">
        table.the_table {
            width: 100%;
            display: block;
        }

        table.the_table tbody {
            display: block;
            padding: 10px;
        }

        table.the_table tbody tr {
            background: #1E202D;
            color: white;
        }

        table.the_table tbody tr td {
            background-color: #1E202D !important;
        }

        table.the_table tbody tr td.meta {
            width: 220px;
            font-weight: 600;
            background-color: #1E202D !important;
        }

        table.the_table tbody tr::nth-child(odd) td {
            width: 220px;
            font-weight: 600;
            background-color: #1E202D !important;
        }

        table.the_table tbody tr::nth-child(even) td {
            width: 220px;
            font-weight: 600;
            background-color: #1E202D !important;
        }

        @media only screen and (max-width: 600px) {
            table.the_table tbody tr {
                margin-bottom: 30px;
                display: block;
            }

            table.the_table tbody tr td {
                display: block;
                width: 100%;
                border: none !important;
                padding: 0 0 0 15px;
            }

            table.the_table tbody tr td.meta {
                display: block;
                width: 100%;
            }
        }
    </style>
    <table class="the_table">
        <tbody>
        <?php
        global $post;
        $dateargs = array(
            'post_type' => 'post',
            'posts_per_page' => -1,
            'meta_key' => 'start',
            'meta_value' => get_field('start', $post->ID),
            'orderby' => 'meta_value',
            'order' => 'ASC'
        );
        $date_loop = new WP_Query($dateargs);
        $i = 0;
        $today = date_i18n('jS F Y');

        if ($date_loop->have_posts()) :

            while ($date_loop->have_posts()) : $i++;
                $date_loop->the_post();
                $start = get_field('start', $post->ID);
                $end = get_field('end', $post->ID);
                $link = get_field('event_link', $post->ID);
                $tbc = get_field('tbc', $post->ID);
                $page_title = get_the_title();
                ?>
                <tr class="thesend" id="the_section-<?php echo $i; ?>">
                    <?php
                    switch ($today) {
                        default:
                        if ($tbc) :
                            echo '<td class="meta meta2" style="">TBC</td>';
                        else :
                        if ($end) :
                            echo '<td class="meta meta2" style="">' . date("jS F", strtotime($start)) . ' - ' . $end . '</td>';
                        else :
                            echo '<td class="meta meta2" style="">' . $start . '</td>';
                        endif;

                        endif;
                        break;
                    }
                    if ($link) :
                        echo '<td><a href="'.$link.'">'.$page_title .'</a></td>';
                    else :
                        echo '<td>'.$page_title.'</td>';
                    endif;
                    ?>
                </tr>
                <?php
                wp_reset_query();
            endwhile;
        endif;
        ?>

        </tbody>
    </table>


    <?php
}

add_shortcode('colt_events', 'create_coltevents_shortcode');



// Register Custom Post Type
function ourworkcpt() {

	$labels = array(
		'name'                  => _x( 'Work Items', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Work Item', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Our Work', 'text_domain' ),
		'name_admin_bar'        => __( 'Our Work', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'attributes'            => __( 'Item Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Items', 'text_domain' ),
		'add_new_item'          => __( 'Add New Item', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Edit Item', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
		'view_items'            => __( 'View Items', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$rewrite = array(
		'slug'                  => 'our-work',
		'with_front'            => true,
		'pages'                 => true,
		'feeds'                 => true,
	);
	$args = array(
		'label'                 => __( 'Work Item', 'text_domain' ),
		'description'           => __( 'Our Work Custom Post Type', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-excerpt-view',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => 'our-work',
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'page',
	);
	register_post_type( 'our_work', $args );

}
add_action( 'init', 'ourworkcpt', 0 );