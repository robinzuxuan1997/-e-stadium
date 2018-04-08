<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * GT Baseball Game class
 * @package   CodeIgniter
 * @subpackage  Libraries
 * 
 */

class Game extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html

        
        /**
         *vote
         *Store the data of a vote: $user_id, $game_id, $player_id in a vote model
         *@access public
         */
	public function vote()
	{
		$game_id = $this->input->post('game_id', TRUE);
        $user_id = $this->input->post('user_id', TRUE);
        $player_id = $this->input->post('player_id', TRUE);

        $this->load->model('vote_model');

        $this->vote_model->initialize($game_id, $player_id, $user_id);
        $this->vote_model->insert();
	}

        /**
         *index
         *display all games' datas (hometeam_id and awayteam_id) in a json format.
         *@access public
         */
    
    public function index()
    {
        // load models
        $this->load->model('game_model');
        $this->load->model('team_model');

        // initialize arrays
        $games = array();
        $teams = array();


        $all_teams = $this->team_model->get_all();
        foreach ($all_teams as $team) {
            $teams[$team->team_id] = $team->name;
        }

        $all_games = $this->game_model->get_all();

        foreach ($all_games as $game) {
            $game->hometeam = $teams[$game->hometeam_id];
            $game->awayteam = $teams[$game->awayteam_id];
            array_push($games, $game);
        }


        echo json_encode($games);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
