<?php
/**
 * GT Baseball Team_model class
 * @package   CodeIgniter
 * @subpackage  Libraries
 * 
 */

class Team_model extends CI_Model {

    private $team_id   = '';
    private $name = '';
    private $school = '';
    private $coach = '';
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
    * Set the value for the object's data member $game_id, $player_id, $user_id
    * @param int: The id number of the game 
    * @param int: The id number of the player
    * @param int: The id number of the user.
    */

    function initialize($game_id, $player_id, $user_id)
    {
    }
    /**
   *get_all
   * Run the selection query to retrieve all data from all teams in database.
   * 
   */

    function get_all()
    {
        $query = $this->db->get('teams');
        return $query->result();
    }
    /**
     *get_by_id
     *Retrieve data of the team member that has the specified team id
     *param int
     */
    function get_by_id($team_id) {
        $query = $this->db->get_where('teams', array('team_id' => $team_id));
        return $query->row();
    }
    /**
    *get_all
    * Import data from Team_model class object to database's team objects.
    * 
    */

    function insert()
    {
        $this->db->insert('teams',
                          array(
                            'name' => $this->name,
                            'school' => $this->school,
                            'coach' => $this->coach
                          )
                         );

    }
}
