<?php

// Delete the old nicename from the cache.
//wp_cache_delete( "shahid-tahir", 'userslugs' );
// Add the new nicename to the cache.
//wp_cache_add( $new_nicename, $user_id, 'userslugs' );
// replace old user url with new one.
//wp_cache_replace( "sss", 4, 'userslugs' );
//Clears all cached data.
wp_cache_flush();
/*
add_filter('author_link', 'my_author_url_with_id', 1000, 2);
function my_author_url_with_id($link, $author_id) {
  $link_base = trailingslashit(get_option('home'));
  $link = "authors/$author_id";
  return $link_base . $link;
}*/

/* author urls wit ids
add_filter('author_rewrite_rules', 'my_author_url_with_id_rewrite_rules');
function my_author_url_with_id_rewrite_rules($author_rewrite) {
  $author_rewrite = array();
  $author_rewrite["author/([0-9]+)/page/?([0-9]+)/?$"] = 'index.php?author=$matches[1]&paged=$matches[2]';
  $author_rewrite["author/([0-9]+)/?$"] = 'index.php?author=$matches[1]';
  return $author_rewrite;
}
*/

/* The following will alter your author rewrite rules to point to yoursite.com/contributor/name for author archives.
add_filter( 'author_rewrite_rules', 'wpdocs_contributors_rewrites' );
function wpdocs_contributors_rewrites( $author_rewrite ) {
	$contributors = array(
		'contributor/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?author_name=$matches[1]&feed=$matches[2]',
		'contributor/([^/]+)/(feed|rdf|rss|rss2|atom)/?$'      => 'index.php?author_name=$matches[1]&feed=$matches[2]',
		'contributor/([^/]+)/page/?([0-9]{1,})/?$'             => 'index.php?author_name=$matches[1]&paged=$matches[2]',
		'contributor/([^/]+)/?$'                               => 'index.php?author_name=$matches[1]'
	);

	$old = array();
	// This relies on you registering a 'redirect' query var and handler.
	// The handler would check for 'redirect' and apply a wp_redirect call where necessary.
	foreach ( $author_rewrite as $endpoint => $query )
		$old[$endpoint] = $query . '&redirect=1';

	return array_merge( $old, $contributors );
}
*/

/*Example functions for adding a ‘redirect’ query var and parsing redirects for the old author permastruct.

function wpdocs_add_redirect_var( $query_vars ) {
	$query_vars[] = 'redirect';
	return $query_vars;
}
add_filter( 'query_vars', 'wpdocs_add_redirect_var' );


function wpdocs_redirect_old_author_links( $request ) {
	if ( isset( $request->public_query_vars['redirect'] )
		&& $request->public_query_vars['redirect']
		&& isset( $request->public_query_vars['author_name'] ) ) {
			wp_redirect( get_author_posts_url( 0, $request->public_query_vars['author_name'] ) );
			exit;
	}
	return $request;
}
add_action( 'parse_request', 'wpdocs_redirect_old_author_links' ); */


/* old exapmple
add_filter('author_rewrite_rules', 'my_author_url_with_custom_url_rewrite_rules');
function my_author_url_with_custom_url_rewrite_rules($author_rewrite) {
  global $wpdb;
  $author_rewrite = array();
  $authors = $wpdb->get_results("SELECT ID, user_nicename AS nicename, meta_value as profile_name
                                    from $wpdb->users
                                    LEFT JOIN wp_usermeta ON wp_usermeta.user_id = $wpdb->users.ID
                                    WHERE  meta_key = 'profile_name'");

  foreach ($authors as $author) {
    $author_rewrite["{$author->profile_name}/page/?([0-9]+)/?$"] = 'index.php?author_name=' . $author->nicename . '&paged=$matches[1]';
    $author_rewrite["{$author->profile_name}/?$"] = "index.php?author_name={$author->nicename}";
  }
  return $author_rewrite;
}
flush_rewrite_rules(false);
*/






/*
// The first part //
add_filter('author_rewrite_rules', 'no_author_base_rewrite_rules');
function no_author_base_rewrite_rules($author_rewrite) {
    global $wpdb;
    $author_rewrite = array();
    $authors = $wpdb->get_results("SELECT user_nicename AS nicename from $wpdb->users");
    foreach($authors as $author) {
        $author_rewrite["({$author->nicename})/page/?([0-9]+)/?$"] = 'index.php?author_name=$matches[1]&paged=$matches[2]';
        $author_rewrite["({$author->nicename})/?$"] = 'index.php?author_name=$matches[1]';
    }
    return $author_rewrite;
}

// The second part //
add_filter('author_link', 'no_author_base', 1000, 2);
function no_author_base($link, $author_id) {
    $link_base = trailingslashit(get_option('home'));
    $link = preg_replace("|^{$link_base}author/|", '', $link);
    return $link_base . $link;
}*/
