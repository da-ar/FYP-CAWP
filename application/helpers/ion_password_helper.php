<?php
/**
 * password_help
 * 
 * takes a password and returns its hashed
 * returns the hash and salt used
 * 
 * @param type String
 * @return type Array
 * 
 * 
 */

function password_help($password){
     $ci=& get_instance();
     $ci->config->load('ion_auth', true);

     $length = $ci->config->item("salt_length", "ion_auth");
     $salt = substr(md5(uniqid(rand(), true)), 0, $length);

     $hash_pass = sha1($password . $salt);

     $pw["hash"] = $hash_pass;
     $pw["salt"] = $salt;

     return $pw;         
}


/* End of file ion_password.php */
/* Location: ./application/helpers/ion_password.php */