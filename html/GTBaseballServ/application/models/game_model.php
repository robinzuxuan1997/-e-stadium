<?php
/**
 * GT Baseball Game_model class
 * @package   CodeIgniter
 * @subpackage  Libraries
 * 
 */
class Game_model extends CI_Model {

    private $game_id   = '';
    private $hometeam_id = '';
    private $awayteam_id = '';
    private $date = '';
    private $score = '';
    private $location = '';
    /** 
    *Overloaded CI model  constructor: __construct()
    *
    */
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
     /*get_all
   * Run the selection query to retrieve all data from all games in database.
   * 
   */
    function get_all()
    {
        // Sort game database based on date in ascending order
        $this->db->order_by('date', 'asc');
        // Run the selection query and save all result in variable $query, and return $query
        $query = $this->db->get('games');
        return $query->result();
    }
    /**
     *get_latest
     *Retrieve data from the latest game happened
     */
    function get_latest()
    {
        $query = $this->db->query('
            select *
            from games
            where date < now()
            order by abs(now() - date) desc
            limit 1'
        );
        return $query->row();
    }
    /**
     *get_next
     *Get data from the closest game that is going to happen
     */

    function get_next()
    {
        $query = $this->db->query('
            select *
            from games
            where date >= now()
            order by abs(now() - date) desc
            limit 1'
        );
        return $query->row();
    }
    /**
     *Get data from all of the games that is going to happen, in descending order
     */
    function get_future()
    {
        $query = $this->db->query('
            select *
            from games
            where date > now()
            order by abs(now() - date) desc'
        );
        return $query->result();
    }
    /**
     *Import all of the data from class' object to database 'users' object.
     */
    
    function insert()
    {
        $this->db->insert('games',
                          array(
                            'hometeam_id' => $this->hometeam_id,
                            'awayteam_id' => $this->awayteam_id,
                            'date'        => $this->date,
                            'score'       => $this->score,
                            'location'    => $this->location
                          )
                         );

    }
}
