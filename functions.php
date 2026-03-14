<?php
/**
 * Flavor Child - Team Dynamic
 *
 * Registers the "team_member" Custom Post Type, enqueues styles,
 * and adds custom image sizes used by the team archive grid.
 *
 * @package Flavor_Child_Team_Dynamic
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the Team Member custom post type.
 */
function flavor_team_register_cpt() {

	$labels = array(
		'name'                  => __( 'Team Members', 'flavor-child-team' ),
		'singular_name'         => __( 'Team Member', 'flavor-child-team' ),
		'add_new'               => __( 'Add New Member', 'flavor-child-team' ),
		'add_new_item'          => __( 'Add New Team Member', 'flavor-child-team' ),
		'edit_item'             => __( 'Edit Team Member', 'flavor-child-team' ),
		'new_item'              => __( 'New Team Member', 'flavor-child-team' ),
		'view_item'             => __( 'View Team Member', 'flavor-child-team' ),
		'search_items'          => __( 'Search Team Members', 'flavor-child-team' ),
		'not_found'             => __( 'No team members found.', 'flavor-child-team' ),
		'not_found_in_trash'    => __( 'No team members found in Trash.', 'flavor-child-team' ),
		'all_items'             => __( 'All Team Members', 'flavor-child-team' ),
		'archives'              => __( 'Team Archives', 'flavor-child-team' ),
		'insert_into_item'      => __( 'Insert into member profile', 'flavor-child-team' ),
		'uploaded_to_this_item' => __( 'Uploaded to this member', 'flavor-child-team' ),
		'menu_name'             => __( 'Team', 'flavor-child-team' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'has_archive'        => true,
		'rewrite'            => array( 'slug' => 'team' ),
		'menu_icon'          => 'dashicons-groups',
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'show_in_rest'       => true,
		'publicly_queryable' => true,
	);

	register_post_type( 'team_member', $args );
}
add_action( 'init', 'flavor_team_register_cpt' );

/**
 * Enqueue the child theme stylesheet after the parent theme.
 */
function flavor_team_enqueue_styles() {

	wp_enqueue_style(
		'flavor-parent-style',
		get_template_directory_uri() . '/style.css',
		array(),
		wp_get_theme( 'flavor' )->get( 'Version' )
	);

	wp_enqueue_style(
		'flavor-child-team-style',
		get_stylesheet_uri(),
		array( 'flavor-parent-style' ),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'flavor_team_enqueue_styles' );

/**
 * Add custom image sizes for team member cards.
 */
function flavor_team_image_sizes() {
	add_image_size( 'team-card', 400, 400, true );
	add_image_size( 'team-single', 800, 600, true );
}
add_action( 'after_setup_theme', 'flavor_team_image_sizes' );

/**
 * Make custom image sizes selectable in the Media Library.
 *
 * @param array $sizes Existing image size labels.
 * @return array
 */
function flavor_team_image_size_names( $sizes ) {

	return array_merge( $sizes, array(
		'team-card'   => __( 'Team Card (400x400)', 'flavor-child-team' ),
		'team-single' => __( 'Team Single (800x600)', 'flavor-child-team' ),
	) );
}
add_filter( 'image_size_names_choose', 'flavor_team_image_size_names' );

/**
 * Adjust the main query for the team_member archive so pagination works.
 *
 * @param WP_Query $query The main WP_Query instance.
 */
function flavor_team_archive_query( $query ) {

	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( is_post_type_archive( 'team_member' ) ) {
		$query->set( 'posts_per_page', 9 );
		$query->set( 'orderby', 'menu_order title' );
		$query->set( 'order', 'ASC' );
	}
}
add_action( 'pre_get_posts', 'flavor_team_archive_query' );

/**
 * Flush rewrite rules once after theme activation so the CPT
 * archive and single URLs work without a manual Settings > Permalinks save.
 */
function flavor_team_flush_rewrites() {
	flavor_team_register_cpt();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'flavor_team_flush_rewrites' );
add_action( 'after_switch_theme', 'flavor_team_flush_rewrites' );
