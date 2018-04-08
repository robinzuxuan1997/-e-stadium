<?php
    /**
 * GT Baseball Vote_model class
 * @package   CodeIgniter
 * @subpackage  Libraries
 * 
 */
class Vote_model extends CI_Model {

    private $vote_id   = '';
    private $game_id = '';
    private $player_id = '';
    private $user_id = '';
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
    * @param int
    */
    function initialize($game_id, $player_id, $user_id)
    {
        $this->game_id = $game_id;
        $this->player_id = $player_id;
        $this->user_id = $user_id;
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
     *Get all data from the players that has the specified game id
     *@param int
     */
    
    function get_all_by_game($game_id) {
        $query = $this->db->get_where('players', array('game_id' => $game_id));
        return $query->result();
    }
    /**
     *insert
     *Import data from class' object to database user's object.
     *
     */
    function insert()
    {
        $this->db->insert('votes',
                          array(
                            'game_id' => $this->game_id,
                            'player_id' => $this->player_id,
                            'user_id' => $this->user_id
                          )
                         );

    }
}
