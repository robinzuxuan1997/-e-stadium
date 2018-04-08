<?php
/**
 * GT Baseball Player_model class
 * @package   CodeIgniter
 * @subpackage  Libraries
 * 
 */
class Player_model extends CI_Model {

    private $number   = '';
    private $name = '';
    private $school_id = '';
    private $position = '';
    private $award = '';
    private $story = '';
    private $dob = '';
    /** 
    *Overloaded CI model  constructor: __construct()
    *
    */
    function __construct()
    {
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
    }
    /**
   *get_all
   * Run the selection query to retrieve all data from all players in database.
   * 
   */
    function get_all()
    {
        $query = $this->db->get('players');
        return $query->result();
    }
    /**
     *get_last_ten__entries
     *Run the selection query to retrive datas from the last ten entries in database.
     *@param string:
     *@param int: limit of entries to retrieve data. 
     */
    function get_last_ten_entries()
    {
        $query = $this->db->get('entries', 10);
        return $query->result();
    }
    /**
     * login
     **/

    function login()
    {
        //$query
    }
    /**
     *generate_token
     *Create a random token which acts as a temporary id.
     */

    function generate_token() {
        return md5(time() * rand() * rand() * microtime() + 'AWEQX#EQEqc3cqc1E212X');
    }
    /**
     *insert
     *Import data from class' object to database user's object.
     *
     */

    function insert()
    {
        $this->token = generate_token();
        $this->db->insert('users',
                          array(
                            'email' => $this->email,
                            'password' => md5($this->password),
                            'name' => $this->name,
                            'token' => generate_token()
                          )
                         );

    }
}
