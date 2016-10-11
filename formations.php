<?php
/*
* Plugin Name: FNMNS_Formations
* Description: Gestion des Formations FNMNS
* GitHub Plugin URI: https://github.com/Aiwings/FNMNS_Formations
* GitHub Plugin URI: Aiwings/FNMNS_Formations
* GitHub Branch: master
* Version: 0.16
* Author: Guillaume Roux
* Text Domain : FNMNS_Formations
*/
class FNMNS_Formations
{
public function __construct()
{
register_activation_hook(__FILE__, array('FNMNS_Formations', 'install'));
register_uninstall_hook(__FILE__, array('FNMNS_Formations', 'uninstall'));
$this->include_views();
$this->include_functions();
$this->include_carte();
$this->include_inscription();
$this->ajax_actions();
$this->shortcodes();
cleanUp();
add_action( 'wp_enqueue_scripts', array($this,'formations_scripts') );
add_action( 'wp_enqueue_scripts', array($this,'map_scripts') );
add_action( 'wp_enqueue_scripts', array($this,'inscription_scripts') );
add_action( 'post_edit_form_tag' ,array($this,'post_edit_form_tag' ));
add_filter('admin_head',array($this,'ShowTinyMCE'));
define("FORMATION_ROOT",plugin_dir_path( __FILE__ ));
define("FORMATION_URL",plugins_url("/",__FILE__ ));
}
public static function install()
{
include_once plugin_dir_path( __FILE__ ).'/functions/install.php';
}
public static function uninstall()
{
global $wpdb;
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}centre_formation;");
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}discipline;");
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}formation;");
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}preinscrits;");
}
private function include_views()
{
include_once plugin_dir_path( __FILE__ ).'/views/normalview.php';
include_once plugin_dir_path( __FILE__ ).'/views/adminview.php';
include_once plugin_dir_path( __FILE__ ).'/views/centres.php';
include_once plugin_dir_path( __FILE__ ).'/views/searchcentres.php';
include_once plugin_dir_path( __FILE__ ).'/views/searchinscrits.php';
include_once plugin_dir_path( __FILE__ ).'views/searchdiscipline.php';
include_once plugin_dir_path( __FILE__ ).'views/form_inscription.php';
include_once plugin_dir_path( __FILE__ ).'views/inscrits.php';
}
private function include_functions()
{
include_once plugin_dir_path( __FILE__ ).'/functions/add.php';
include_once plugin_dir_path( __FILE__ ).'/functions/add_discipline.php';
include_once plugin_dir_path( __FILE__ ).'/functions/delete.php';
include_once plugin_dir_path( __FILE__ ).'/functions/modif.php';
include_once plugin_dir_path( __FILE__ ).'/functions/selectcentre.php';
include_once plugin_dir_path( __FILE__ ).'/functions/addcentre.php';
include_once plugin_dir_path( __FILE__ ).'/functions/modifcentre.php';
include_once plugin_dir_path( __FILE__ ).'/functions/preinscrire.php';
include_once plugin_dir_path( __FILE__ ).'/functions/modifinscrits.php';
include_once plugin_dir_path( __FILE__ ).'/functions/inscription.php';
include_once plugin_dir_path( __FILE__ ).'/functions/export.php';
include_once plugin_dir_path( __FILE__ ).'/functions/deletefile.php';
include_once plugin_dir_path( __FILE__ ).'/functions/cleanUp.php';
include_once plugin_dir_path( __FILE__ ).'/functions/pieces.php';
include_once plugin_dir_path( __FILE__ ).'/functions/fichier.php';
}
private function include_carte(){
include_once plugin_dir_path( __FILE__ ).'/carte/poly.php';
include_once plugin_dir_path( __FILE__ ).'/carte/centres.php';
include_once plugin_dir_path( __FILE__ ).'/carte/infowindow.php';
}
private function include_inscription()
{
include_once plugin_dir_path( __FILE__ ).'/inscription/index.php';
include_once plugin_dir_path( __FILE__ ).'/inscription/update.php';
}
public function inscription_scripts()
{
$page = get_page_by_title( 'Inscription' );
if(is_page($page->ID))
{
wp_enqueue_script( 'inscription_scripts',plugins_url("inscription/js/scripts.js",__FILE__), array( 'jquery') , '1.0' );
wp_localize_script('inscription_scripts', 'ajaxurl', admin_url( 'admin-ajax.php' ) );
wp_enqueue_style( "inscription", plugins_url("inscription/css/styles.css",__FILE__));
}
}
public function inscription()
{
ob_start();
inscription_form();
return ob_get_clean();
}
private function shortcodes()
{
add_shortcode( 'formations', array($this,'formations') );
add_shortcode( 'carte', array($this,'carte' ));
add_shortcode( 'inscription_form', array($this,'inscription' ));
}
private function ajax_actions()
{
add_action( 'wp_ajax_ajout_formation', 'ajout_formation' );
add_action( 'wp_ajax_nopriv_ajout_formation', 'ajout_formation' );
add_action( 'wp_ajax_ajout_discipline', 'ajout_discipline' );
add_action( 'wp_ajax_nopriv_ajout_discipline', 'ajout_discipline' );
add_action( 'wp_ajax_form_delete', 'form_delete' );
add_action( 'wp_ajax_nopriv_form_delete', 'form_delete' );
add_action( 'wp_ajax_modif_formation', 'modif_formation' );
add_action( 'wp_ajax_nopriv_modif_formation', 'modif_formation' );
add_action( 'wp_ajax_select_centres', 'select_centres' );
add_action( 'wp_ajax_nopriv_select_centres', 'select_centres' );
add_action( 'wp_ajax_ajout_centre', 'ajout_centre' );
add_action( 'wp_ajax_nopriv_ajout_centre', 'ajout_centre' );
add_action( 'wp_ajax_modif_centre', 'modif_centre' );
add_action( 'wp_ajax_nopriv_modif_centre', 'modif_centre' );
add_action( 'wp_ajax_preinscrire', 'preinscrire' );
add_action( 'wp_ajax_nopriv_preinscrire', 'preinscrire' );
add_action( 'wp_ajax_form_inscription', 'form_inscription' );
add_action( 'wp_ajax_nopriv_form_inscription', 'form_inscription' );
add_action( 'wp_ajax_inscrits', 'inscrits' );
add_action( 'wp_ajax_nopriv_inscrits', 'inscrits' );
add_action( 'wp_ajax_modif_inscrits', 'modif_inscrits' );
add_action( 'wp_ajax_nopriv_modif_inscrits', 'modif_inscrits' );
add_action( 'wp_ajax_inscription', 'inscription' );
add_action( 'wp_ajax_nopriv_inscription', 'inscription' );
add_action( 'wp_ajax_export', 'export' );
add_action( 'wp_ajax_nopriv_export', 'export' );
add_action( 'wp_ajax_poly', 'poly' );
add_action( 'wp_ajax_nopriv_poly', 'poly' );
add_action( 'wp_ajax_carte_centres', 'carte_centres' );
add_action( 'wp_ajax_nopriv_carte_centres', 'carte_centres' );
add_action( 'wp_ajax_infowindow', 'infowindow' );
add_action( 'wp_ajax_nopriv_infowindow', 'infowindow' );
add_action( 'wp_ajax_update', 'update' );
add_action( 'wp_ajax_nopriv_update', 'update' );
add_action( 'wp_ajax_pieces', 'pieces' );
add_action( 'wp_ajax_nopriv_pieces', 'pieces' );
}
public function post_edit_form_tag( ) {
echo 'enctype="multipart/form-data"';
}
function ShowTinyMCE() {
// conditions here
wp_enqueue_script( 'common' );
wp_enqueue_script( 'jquery-color' );
wp_print_scripts('editor');
if (function_exists('add_thickbox')) add_thickbox();
wp_print_scripts('media-upload');
if (function_exists('wp_tiny_mce')) wp_tiny_mce();
wp_admin_css();
wp_enqueue_script('utils');
do_action("admin_print_styles-post-php");
do_action('admin_print_styles');
}
public function map_scripts()
{
global $wpdb;
$sql_map = 'SELECT ID FROM `wp_posts` WHERE `post_title` = "Centres de Formation" AND post_status="publish" ;';
$mapID = $wpdb->get_var($sql_map);
if(is_single($mapID) && !current_user_can( 'manage_options' )){
wp_enqueue_script( 'GoogleMap','https://maps.googleapis.com/maps/api/js?key=AIzaSyA0goj_KyUSm3Dvl4zAz-S1ebCYOvK8lGY' );
wp_enqueue_script('jquery');
wp_enqueue_script( 'carte_scripts',plugins_url("carte/js/scripts.js",__FILE__), array( 'jquery') , '1.0' );
wp_localize_script('carte_scripts', 'ajaxurl', admin_url( 'admin-ajax.php' ) );
wp_enqueue_script( 'carte_points', plugins_url("carte/js/points.js",__FILE__), array( 'jquery') , '1.0' );
wp_localize_script('carte_points', 'ajaxurl', admin_url( 'admin-ajax.php' ) );
wp_localize_script('carte_points', 'imageurl',  plugins_url('/carte/img/',__FILE__) );
}
}
public function formations_scripts()
{
//wp_enqueue_script( 'Modernizr','http://cdn.jsdelivr.net/webshim/1.12.4/extras/modernizr-custom.js' );
wp_enqueue_script( 'PolyFiller','http://cdn.jsdelivr.net/webshim/1.12.4/polyfiller.js' );
wp_enqueue_script( 'ajout', plugins_url("js/ajout.js",__FILE__), array( 'jquery') , '1.0' );
wp_localize_script('ajout', 'ajaxurl', admin_url( 'admin-ajax.php' ) );
wp_enqueue_script( 'modif', plugins_url("js/modif.js",__FILE__), array( 'jquery') , '1.0' );
wp_localize_script('modif', 'ajaxurl', admin_url( 'admin-ajax.php' ) );
wp_enqueue_script( 'centres', plugins_url("js/centres.js",__FILE__), array( 'jquery') , '1.0' );
wp_localize_script('centres', 'ajaxurl', admin_url( 'admin-ajax.php' ) );
wp_enqueue_script( 'fileinput', plugins_url("js/fileinput.js",__FILE__), array( 'jquery') , '1.0' );
wp_enqueue_script( 'inscription', plugins_url("js/inscription.js",__FILE__), array( 'jquery') , '1.0' );
wp_localize_script('inscription', 'ajaxurl', admin_url( 'admin-ajax.php' ) );
wp_enqueue_style( "formations", plugins_url("css/style.css",__FILE__));
}
public function carte()
{
ob_start();
if ( !current_user_can( 'manage_options' ) )  {
?>
<div id="map" style="width:100%;height:500px;"></div>
<?php }
else {
$centres = new Centres();
}
return ob_get_clean();
}
public function formations()
{
ob_start();
if ( !current_user_can( 'manage_options' ) )
{
$normal = new NormalView();
}
else
{
$admin = new AdminView();
}
return ob_get_clean();
}
}
$formations = new FNMNS_Formations();
?>
