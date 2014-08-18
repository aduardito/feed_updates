<?php

    class Connection
    {

        // this data suppose to be store in the database, but I want to make thing easy.
        // other security function to consider will be to encode the password in javascript to send it 
        // through the website, and keep it more safety than send it in plain text 
        /**
         *	@var contains the name of the user to access to the website
         */
        private $access_user = 'root';

        /**
         *	@var contains the name of the user to access to the website
         */
        private $access_password = 'root';

        public $message;

        /**
        *	
        */
        public function __construct()
        {

        }	

        /**
        *	validate user
        */
        public function validateUser( $user=null, $password=null )
        {
            if ( $user == null || $password == null )
            {
                    return false;
            }
            else
            {
                $this->securityBariers( $user, $password );
                
                if ( $user === $this->access_user && $password === $this->access_password )
                {
                    return true;
                }
                else
                {
                    return false;
                }

            }
        }

        /**
         * Check html entitites for sql injections.
         */
        private function securityBariers( &$user, &$password )
        {
            $user = htmlentities($user);
            $password = htmlentities($password);		
        }


    }

?>