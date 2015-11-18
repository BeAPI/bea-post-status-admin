Bea post status Admin
==

Registering post_status on WordPress does not display an interface for it.
With this plugin you can display the new Post status to the admin interface and interact with it !

Usage 
==
```
// Add post status
add_action( 'bea/psa/register', 'init_post_status' );
function init_post_status( $class ) {
	register_post_status( 'refused', array(
			'label'                     => 'Refused',
			'public'                    => true,
			'exclude_from_search'       => true,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop( 'Refused <span class="count">(%s)</span>', 'Refused <span class="count">(%s)</span>' ),
		) );

		// Add the post_status admin interface
		/**
			Here you can add the post status to a post type and choose the submit button text if you choose the 
			post_status on the select.
		*/
		$class::register_status( 'refused', array( "post" ), 'Refuse the post' );
	
}```

Caution
==
In this plugin version, there is no checks on the user role or capabilities, so this just add the interface and that's it !