<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * GT Baseball Team_model class
 * @package   CodeIgniter
 * @subpackage  Libraries
 * 
 */
class Team extends CI_Controller {

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
	 */
        
        /**
         *index
         *Load all of the teams' data in json format
         */
	public function index()
	{
		$this->load->model('team_model');
    	echo json_encode($this->team_model->get_all());
	}
        /**
         *get_by_id
         *Load the data of the team with the specified id in json format.
         */
	public function get_by_id() {
		$team_id = $this->input->post('team_id', TRUE);
		$this->load->model('team_model');
		$team = $this->team_model->get_by_id($team_id);
    	echo json_encode($team);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
