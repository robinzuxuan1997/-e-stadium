<?php
    /**
    * GT Baseball User_model class
    * @package   CodeIgniter
    * @subpackage  Libraries
    * 
    */
class User_model extends CI_Model {

    private $email   = '';
    private $password = '';
    private $name = '';
    private $token = '';
    private $hashed_password = '';
    /** 
    *Overloaded CI model  constructor: __construct()
    *
    */
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    /**
    * initialize
    * Set the value for the object's data member $email, $password, $name
    * @param string 
    */


    function initialize($email, $password, $name)
    {
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->hashed_password = md5($this->password);
    }
    /**
     *login
     */

    function login()
    {
        //$query
    }
    /**
     *get_by_email
     *Get data from "user" object that has the specified $email value
     *@param string
     */

    function get_by_email($email)
    {
      $query = $this->db->get_where('users', array('email' => $email));
      return $query->row();
    }
    /**
     *    /**
     *generate_token
     *Create a random token which acts as a temporary id.
     */

    function generate_token() {
        $entropy = time() * rand() * rand() * microtime();
        $salt = 'ADADADQW$Edaq30ci-0q3icrqe';
        $token = md5($salt.$entropy);
        return $token;
    }
    /**
     *insert
     *Import data from class' object to database user's object.
     *
     */

    function insert()
    {
        $this->token = $this::generate_token();

        $user_data = array(
                            'email' => $this->email,
                            'password' => $this->hashed_password,
                            'name' => $this->name,
                            'token' => $this->token
                          );

        $this->db->insert('users',$user_data);
        return $this->db->insert_id();

    }
}
