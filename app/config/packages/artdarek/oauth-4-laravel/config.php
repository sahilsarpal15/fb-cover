<?php 

return array( 
	
	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session', 

	/**
	 * Consumers
	 */
	'consumers' => array(

		/**
		 * Facebook
		 */
        'Facebook' => array(
            'client_id'     => '813415875352774',
            'client_secret' => '458fc500bf2072b44f3a8af1792e5f4f',
            'scope'         => array('publish_actions','email','manage_pages','read_stream','user_likes','publish_stream','user_photos','create_event'),
        ),		

	)

);