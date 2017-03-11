<?php

class User {
	private $db;
	private $_errors = array();

	function __construct($DBCONN) {
		$this->db = $DBCONN;
	}

	public function clean($content) {
		// removed whitespaces and others shits and bitches
		$string = str_replace("'", '', $content);
		$string = preg_replace('/(\s)+[^+@._\p{L}\p{N}]/u', ' ', $string);
		// $string = preg_replace('/(\s)+/', ' ', $string); this is just for testing fk
		return $string;
	}

	public function addCheckEmail($user_email) {
		try {
			$stmt = $this->db->prepare("SELECT * FROM users WHERE user_email = :user_email");
			$stmt->bindParam(':user_email', $user_email);
			$stmt->execute();
			return (($stmt->rowCount() > 0) ? false : true);
		} catch (Exception $e) {
			$errors = $e->getMessage();
			return $errors;
		}
	}

	public function editCheckEmail($user_id,$user_email) {
		try {
			$stmt = $this->db->prepare("SELECT * FROM users WHERE user_email = :user_email");
			$stmt->bindParam(':user_email', $user_email);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if($row['user_id'] == $user_id && $row['user_email'] == $user_email) {
				return true;
			} else {
				return (($stmt->rowCount() >= 1) ? false : true);
			}
		} catch (Exception $e) {
			$errors = $e->getMessage();
			return $errors;
		}
	}

	public function viewCount($search) {
		try {
			if($search == 'all' || empty($search)) {
				$search = $this->clean($search);
				$stmt = $this->db->prepare("SELECT * FROM users");
				$stmt->execute();
				return $stmt->rowCount();
			} else {
				$search = $this->clean($search);
				$stmt = $this->db->prepare("SELECT * FROM users WHERE CONCAT(user_firstname, ' ',user_lastname) LIKE '%$search%' OR user_firstname LIKE '%$search%' OR user_lastname LIKE '%$search%'");
				$stmt->execute();
				return $stmt->rowCount();
			}

		} catch(PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	} // viewCount()

	public function viewDataTemplate($user_id, $user_firstname, $user_lastname, $user_email, $user_phonenumber) { ?>

		<tr>
			<td>
				<a href="<?=HTTPHOST;?>edit/<?=$user_id;?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i></a>
				<a href="#" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
			</td>
			<td><?=$user_id;?></td>
			<td><?=$user_firstname;?></td>
			<td><?=$user_lastname;?></td>
			<td><?=$user_email;?></td>
			<td><?=$user_phonenumber;?></td>
		</tr>

	<?php return true; } // dataTemplate()

	public function view($search = 'all') {
		try {
			if($search == 'all' || empty($search)) {
				$stmt = $this->db->prepare("SELECT * FROM users ORDER BY user_id DESC");
				$stmt->execute();
				
				if($stmt->rowCount() > 0) {
					while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
						$this->viewDataTemplate(
							$row['user_id'],
							$row['user_firstname'],
							$row['user_lastname'],
							$row['user_email'],
							$row['user_phonenumber']);
					}
				} else { ?>
					<tr>
						<td colspan="6" class="text-center">
							<h3 class="text-warning">No Data Found! <a href="<?=HTTPHOST?>add.php" class="btn btn-success">ADD NOW!</a></h3>
						</td>
					</tr>
				<?php }

			} else {
				$search = $this->clean($search);
				$stmt = $this->db->prepare("SELECT * FROM users WHERE CONCAT(user_firstname, ' ',user_lastname) LIKE '%$search%' OR user_firstname LIKE '%$search%' OR user_lastname LIKE '%$search%' ORDER BY user_id DESC");
				$stmt->execute();
				
				if($stmt->rowCount() > 0) {
					while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 

						$this->viewDataTemplate(
							$row['user_id'],
							$row['user_firstname'],
							$row['user_lastname'],
							$row['user_email'],
							$row['user_phonenumber']);
					}
				} else { ?>
					<tr>
						<td colspan="6" class="text-center">
							<h3 class="text-warning">No Data Found! <a href="<?=HTTPHOST?>add.php" class="btn btn-success">ADD NOW!</a></h3>
						</td>
					</tr>
				<?php }

			}
		} catch(PDOException $e) {
			$errors[] = $e->getMessage();
			return false;
		}
	} // view()

	public function edit($user_id,$user_firstname,$user_lastname,$user_email,$user_phonenumber) {
		try {
			if($this->editCheckEmail($user_id,$user_email)) {
				$stmt = $this->db->prepare("UPDATE users SET 
					user_firstname		= :user_firstname,
					user_lastname		= :user_lastname,
					user_email			= :user_email,
					user_phonenumber	= :user_phonenumber
					WHERE user_id		= :user_id ");
				$stmt->bindParam(':user_firstname', $user_firstname);
				$stmt->bindParam(':user_lastname', $user_lastname);
				$stmt->bindParam(':user_email', $user_email);
				$stmt->bindParam(':user_phonenumber', $user_phonenumber);
				$stmt->bindParam(':user_id', $user_id);
				$stmt->execute();
				return true;
			} else {
				$this->_errors[] = 'Email already exists';
				return false;
			}
		} catch(PDOException $e) {
			$errors = $e->getMessage();
			return false;
		}
	} // edit()

	public function editView($user_id) {
		try {
			$user_id = $this->clean($user_id);
			$stmt = $this->db->prepare("SELECT * FROM users WHERE user_id = :user_id LIMIT 1");
			$stmt->bindParam(':user_id', $user_id);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				return $row;
			} else {
				return false;
			}
		} catch(PDOException $e) {
			$errors = $e->getMessage();
			return false;
		}
	} // editView()

	public function add($user_firstname,$user_lastname,$user_email,$user_phonenumber) {
		try {
			if($this->addCheckEmail($user_email)) {
				$stmt = $this->db->prepare("INSERT INTO users (user_firstname,user_lastname,user_email,user_phonenumber) 
					VALUES (:user_firstname,:user_lastname,:user_email,:user_phonenumber)");
				$stmt->execute(array(
					':user_firstname'	=> $user_firstname,
					':user_lastname'	=> $user_lastname,
					':user_email'		=> $user_email,
					':user_phonenumber'	=> $user_phonenumber
					));
				return true;
			} else {
				$this->_errors[] = 'Email already exists';
				return false;
			}
		} catch (Exception $e) {
			$errors = $e->getMessage();
			return false;
		}
	} // add()

	// will update this shit.
	public function errors() {
		// return $this->_errors;
		// echo '<ul>';
		// foreach ($this->_errors as $key => $value) { echo '<li>'.$value.'</li>'; }
		// echo '</ul>';
		return $this->_errors;
	} // errors() 
} 

?>