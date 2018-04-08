<?
class User{
	private $fname;
	private $lname;
	private $age;
	private $username;

	// string, string, array of comma delimited permission strings (admin, read, write)
	function User($fname, $lname, $age, $usernm){
		$this->fname = $fname;
		$this->lname = $lname;
		$this->age = $age;
		$this->username = $usernm;
	}
	public function getFirstName(){
		return $this->fname;
	}
	public function getLastName(){
		return $this->lname;
	}
	public function getAge(){
		return $this->age;
	}
	public function getUsr(){
		return $this->username;
	}
	public function setUsr($username){
		$this->username = $username;
	}
}
?>