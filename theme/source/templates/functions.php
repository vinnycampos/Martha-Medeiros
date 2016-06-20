<?php

add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 825, 510, true );

function remove_menus(){
  //remove_menu_page( 'index.php' );                  //Dashboard
  //remove_menu_page( 'edit.php' );                   //Posts
 // remove_menu_page( 'upload.php' );                 //Media
 // remove_menu_page( 'edit.php?post_type=page' );    //Pages
 // remove_menu_page( 'edit.php?post_type=feedback' );    //Feedback
//  remove_menu_page( 'edit-comments.php' );          //Comments
// remove_menu_page( 'themes.php' );                 //Appearance
//  remove_menu_page( 'plugins.php' );                //Plugins
  //remove_menu_page( 'users.php' );                  //Users
//   remove_menu_page( 'tools.php' );                  //Tools
// remove_menu_page( 'options-general.php' );        //Settings
//  remove_menu_page( 'link-manager.php' );        //Links
//  remove_menu_page( 'edit.php?post_type=acf-field-group' );        //CustomFields
}
add_action( 'admin_menu', 'remove_menus' );


add_action("login_head", "my_login_head");
function my_login_head() {
  echo "
  <style>
  body.login #login h1 a {
    background: url('".get_stylesheet_directory_uri()."/img/logo_adm.png') no-repeat scroll center top transparent;
    height: 181px;
    width: 222px;
  }
  </style>
  ";
}
add_filter('show_admin_bar', '__return_false');

// Disable support for comments and trackbacks in post types
function df_disable_comments_post_types_support() {
  $post_types = get_post_types();
  foreach ($post_types as $post_type) {
    if(post_type_supports($post_type, 'comments')) {
      remove_post_type_support($post_type, 'comments');
      remove_post_type_support($post_type, 'trackbacks');
    }
  }
}
add_action('admin_init', 'df_disable_comments_post_types_support');

// Close comments on the front-end
function df_disable_comments_status() {
  return false;
}
add_filter('comments_open', 'df_disable_comments_status', 20, 2);
add_filter('pings_open', 'df_disable_comments_status', 20, 2);

// Hide existing comments
function df_disable_comments_hide_existing_comments($comments) {
  $comments = array();
  return $comments;
}
add_filter('comments_array', 'df_disable_comments_hide_existing_comments', 10, 2);

// Remove comments page in menu
function df_disable_comments_admin_menu() {
  remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'df_disable_comments_admin_menu');

// Redirect any user trying to access comments page
function df_disable_comments_admin_menu_redirect() {
  global $pagenow;
  if ($pagenow === 'edit-comments.php') {
    wp_redirect(admin_url()); exit;
  }
}
add_action('admin_init', 'df_disable_comments_admin_menu_redirect');

// Remove comments metabox from dashboard
function df_disable_comments_dashboard() {
  remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}
add_action('admin_init', 'df_disable_comments_dashboard');

// Remove comments links from admin bar
function df_disable_comments_admin_bar() {
  if (is_admin_bar_showing()) {
    remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
  }
}
add_action('init', 'df_disable_comments_admin_bar');


function remove_core_updates(){
global $wp_version;return(object) array('last_checked'=> time(),'version_checked'=> $wp_version,);
}
add_filter('pre_site_transient_update_core','remove_core_updates');
add_filter('pre_site_transient_update_plugins','remove_core_updates');
add_filter('pre_site_transient_update_themes','remove_core_updates');


function remove_admin_bar_links() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');          // Remove the WordPress logo
    $wp_admin_bar->remove_menu('about');            // Remove the about WordPress link
    $wp_admin_bar->remove_menu('wporg');            // Remove the WordPress.org link
    $wp_admin_bar->remove_menu('documentation');    // Remove the WordPress documentation link
    $wp_admin_bar->remove_menu('support-forums');   // Remove the support forums link
    $wp_admin_bar->remove_menu('feedback');         // Remove the feedback link
    $wp_admin_bar->remove_menu('site-name');        // Remove the site name menu
    $wp_admin_bar->remove_menu('view-site');        // Remove the view site link
    $wp_admin_bar->remove_menu('updates');          // Remove the updates link
    $wp_admin_bar->remove_menu('comments');         // Remove the comments link
    $wp_admin_bar->remove_menu('new-content');      // Remove the content link
    $wp_admin_bar->remove_menu('w3tc');             // If you use w3 total cache remove the performance link
    $wp_admin_bar->remove_menu('my-account');       // Remove the user details tab
}
add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );

// REMOVE WIDGETS
function unregister_default_widgets() {     
  unregister_widget('WP_Widget_Pages');     
  unregister_widget('WP_Widget_Calendar');     
  unregister_widget('WP_Widget_Archives');     
  unregister_widget('WP_Widget_Links');     
  unregister_widget('WP_Widget_Meta');     
  unregister_widget('WP_Widget_Search');     
  unregister_widget('WP_Widget_Text');     
  unregister_widget('WP_Widget_Categories');     
  unregister_widget('WP_Widget_Recent_Posts');     
  unregister_widget('WP_Widget_Recent_Comments');     
  unregister_widget('WP_Widget_RSS');     
  unregister_widget('WP_Widget_Tag_Cloud');     
  unregister_widget('WP_Nav_Menu_Widget');
}
add_action('widgets_init', 'unregister_default_widgets', 11);

// REMOVE MENSAGEM DE BOAS-VINDAS
remove_action('welcome_panel', 'wp_welcome_panel');

// REMOVE ITENS DO DASHBOARD DA HOME
function remove_dashboard_widgets() {
  global $wp_meta_boxes;

  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);

}
add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );

update_option('siteurl','http://www.marthamedeiros.com.br');
update_option('home','http://www.marthamedeiros.com.br');

add_action( 'init', 'create_post_type' );
function create_post_type() {
  register_post_type( 'evento',
    array(
      'labels' => array(
        'name' => __( 'Eventos' ),
        'singular_name' => __( 'Evento' )
      ),
      'public' => true,
      'has_archive' => true,
      'capability_type' => 'post',
      'public' => true,
      'has_archive' => false,
      'supports'           => array( 'title', 'thumbnail', 'author', 'editor'),
      'menu_position' => 4,
      'menu_icon'   => 'dashicons-heart',
    )
  );
}

add_action( 'init', 'create_post_type2' );
function create_post_type2() {
  register_post_type( 'lookbook',
    array(
      'labels' => array(
        'name' => __( 'Lookbook' ),
        'singular_name' => __( 'Lookbook' )
      ),
      'public' => true,
      'has_archive' => true,
      'capability_type' => 'post',
      'public' => true,
      'has_archive' => false,
      'supports'           => array( 'title', 'thumbnail', 'author', 'editor'),
      'menu_position' => 4,
      'menu_icon'   => 'dashicons-heart',
    )
  );
}

add_action( 'init', 'create_post_type3' );
function create_post_type3() {
  register_post_type( 'colecao',
    array(
      'labels' => array(
        'name' => __( 'Coleções' ),
        'singular_name' => __( 'Coleção' )
      ),
      'public' => true,
      'has_archive' => true,
      'capability_type' => 'post',
      'public' => true,
      'has_archive' => false,
      'supports'           => array( 'title', 'thumbnail', 'author', 'editor'),
      'menu_position' => 4,
      'menu_icon'   => 'dashicons-heart',
    )
  );
}

add_action( 'init', 'create_post_type4' );
function create_post_type4() {
  register_post_type( 'clipping',
    array(
      'labels' => array(
        'name' => __( 'Clipping' ),
        'singular_name' => __( 'Clipping' )
      ),
      'public' => true,
      'has_archive' => true,
      'capability_type' => 'post',
      'public' => true,
      'has_archive' => false,
      'supports'           => array( 'title', 'thumbnail', 'author', 'editor'),
      'menu_position' => 4,
      'menu_icon'   => 'dashicons-heart',
    )
  );
}

add_action( 'init', 'create_post_type5' );
function create_post_type5() {
  register_post_type( 'campanha',
    array(
      'labels' => array(
        'name' => __( 'Campanha' ),
        'singular_name' => __( 'Campanha' )
      ),
      'public' => true,
      'has_archive' => true,
      'capability_type' => 'post',
      'public' => true,
      'has_archive' => false,
      'supports'           => array( 'title', 'thumbnail', 'author', 'editor'),
      'menu_position' => 4,
      'menu_icon'   => 'dashicons-heart',
    )
  );
}

add_action( 'init', 'create_post_type6' );
function create_post_type6() {
  register_post_type( 'desfile',
    array(
      'labels' => array(
        'name' => __( 'Desfile' ),
        'singular_name' => __( 'Desfile' )
      ),
      'public' => true,
      'has_archive' => true,
      'capability_type' => 'post',
      'public' => true,
      'has_archive' => false,
      'supports'           => array( 'title', 'thumbnail', 'author', 'editor'),
      'menu_position' => 4,
      'menu_icon'   => 'dashicons-heart',
    )
  );
}

update_option( 'siteurl', 'http://localhost/martha_medeiros/site/' );
update_option( 'home', 'http://localhost/martha_medeiros/site/' );