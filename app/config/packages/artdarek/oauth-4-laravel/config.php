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
            'client_id'     => 'your client id',
            'client_secret' => 'your client secret',
            'scope'         => array('publish_actions','email','manage_pages','read_stream','user_likes','publish_stream','user_photos','create_event'),
        ),		

	)

);
