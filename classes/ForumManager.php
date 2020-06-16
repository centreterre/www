<?php
include 'classes/ForumTopic.php';
include 'classes/ForumPost.php';
include 'classes/ForumUser.php';
class ForumManager {
	public function searchTopics($search) {
		$topics = array ();
		$dbClient = new DBClient ();
		try {
			$dbClient->open ();
			$sql = "select id";
			$sql .= ",last_name";
			$sql .= ",first_name";
			$sql .= ",subject";
			$sql .= ",date";
			$sql .= " from forum_topic";
			$sql .= " where lower(subject) like lower('%" . $dbClient->escape ( $search ) . "%')";
			$sql .= " or lower(last_name) like lower('%" . $dbClient->escape ( $search ) . "%')";
			$sql .= " or lower(first_name) like lower('%" . $dbClient->escape ( $search ) . "%')";
			$sql .= " order by date desc";
			Utils::info ( $sql );
			$result = $dbClient->query ( $sql );
			if ($result->num_rows > 0) {
				while ( $row = $result->fetch_assoc () ) {
					$topic = new ForumTopic ();
					$topic->id = $row ["id"];
					$topic->last_name = $row ["last_name"];
					$topic->first_name = $row ["first_name"];
					$topic->subject = $row ["subject"];
					$topic->date = $row ["date"];
					array_push ( $topics, $topic );
				}
			}
		} catch ( Error $e ) {
			Utils::error ( $e->getMessage () );
		} finally {
			$dbClient->close ();
		}
		return $topics;
	}
	public function getTopics() {
		$topics = array ();
		$dbClient = new DBClient ();
		try {
			$dbClient->open ();
			$sql = "select id";
			$sql .= ",enabled";
			$sql .= ",last_name";
			$sql .= ",first_name";
			$sql .= ",subject";
			$sql .= ",date";
			$sql .= " from forum_topic";
			if (! $this->isSuperAdmin ()) {
				$sql .= " where enabled = 1";
			}
			$sql .= " order by date desc";
			Utils::info ( $sql );
			$result = $dbClient->query ( $sql );
			if ($result->num_rows > 0) {
				while ( $row = $result->fetch_assoc () ) {
					$topic = new ForumTopic ();
					$topic->id = $row ["id"];
					$topic->enabled = $row ["enabled"];
					$topic->last_name = $row ["last_name"];
					$topic->first_name = $row ["first_name"];
					$topic->subject = $row ["subject"];
					$topic->date = $row ["date"];
					array_push ( $topics, $topic );
				}
			}
		} catch ( Error $e ) {
			Utils::error ( $e->getMessage () );
		} finally {
			$dbClient->close ();
		}
		return $topics;
	}
	public function getTopic($id) {
		$topic = new ForumTopic ();
		$dbClient = new DBClient ();
		try {
			$dbClient->open ();
			$sql = "select id";
			$sql .= ",last_name";
			$sql .= ",first_name";
			$sql .= ",subject";
			$sql .= ",date";
			$sql .= " from forum_topic";
			$sql .= " where id = '" . $id . "'";
			Utils::info ( $sql );
			$result = $dbClient->query ( $sql );
			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc ();
				$topic->id = $row ["id"];
				$topic->last_name = $row ["last_name"];
				$topic->first_name = $row ["first_name"];
				$topic->subject = $row ["subject"];
				$topic->date = $row ["date"];
			}
		} catch ( Error $e ) {
			Utils::error ( $e->getMessage () );
		} finally {
			$dbClient->close ();
		}
		return $topic;
	}
	public function addTopic($topic) {
		$dbClient = new DBClient ();
		try {
			$dbClient->open ();
			$sql = "insert into forum_topic (";
			$sql .= "last_name";
			$sql .= ",first_name";
			$sql .= ",subject";
			$sql .= ",date) values (";
			$sql .= "'" . $dbClient->escape ( $topic->last_name ) . "'";
			$sql .= ",'" . $dbClient->escape ( $topic->first_name ) . "'";
			$sql .= ",'" . $dbClient->escape ( $topic->subject ) . "'";
			$sql .= ",now()";
			$sql .= ")";
			Utils::info ( $sql );
			$result = $dbClient->query ( $sql );
			$topic_id = $dbClient->lastInsertId ();
			Utils::info ( 'lastInsertId=' . $topic_id );
			$topic = $this->getTopic ( $topic_id );
			$email = 'david.meunier@si4g.fr';
			$message = "From : " . $topic->last_name . " " . $topic->first_name . "\r\n\r\n";
			$message = $message . "Subject : " . $topic->subject . "\r\n\r\n";
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'From:' . $email . "\r\n" . 'Reply-To:' . $email . "\r\n" . 'Content-Type: text/plain; charset="utf-8"; DelSp="Yes"; format=flowed ' . "\r\n" . 'Content-Disposition: inline' . "\r\n" . 'Content-Transfer-Encoding: 7bit' . " \r\n" . 'X-Mailer:PHP/' . phpversion ();
			mail ( $email, 'Nouveau sujet sur le forum scolaire', $message, $headers );
		} catch ( Error $e ) {
			Utils::error ( $e->getMessage () );
		} finally {
			$dbClient->close ();
		}
		return $topic;
	}
	public function deleteTopic($id) {
		$dbClient = new DBClient ();
		try {
			$dbClient->open ();
			$sql = "delete from forum_topic where id = '" . $id . "'";
			Utils::info ( $sql );
			$result = $dbClient->query ( $sql );
		} catch ( Error $e ) {
			Utils::error ( $e->getMessage () );
		} finally {
			$dbClient->close ();
		}
	}
	public function enableTopic($id) {
		$dbClient = new DBClient ();
		try {
			$dbClient->open ();
			$sql = "update forum_topic set enabled = 1 where id = '" . $id . "'";
			Utils::info ( $sql );
			$result = $dbClient->query ( $sql );
		} catch ( Error $e ) {
			Utils::error ( $e->getMessage () );
		} finally {
			$dbClient->close ();
		}
	}
	public function disableTopic($id) {
		$dbClient = new DBClient ();
		try {
			$dbClient->open ();
			$sql = "update forum_topic set enabled = 0 where id = '" . $id . "'";
			Utils::info ( $sql );
			$result = $dbClient->query ( $sql );
		} catch ( Error $e ) {
			Utils::error ( $e->getMessage () );
		} finally {
			$dbClient->close ();
		}
	}
	public function updateTopic($topic) {
		$dbClient = new DBClient ();
		try {
			$dbClient->open ();
			$sql = "update forum_topic set ";
			$sql .= "subject = '" . $topic->subject . "'";
			$sql .= " where id = '" . $topic->id . "'";
			Utils::info ( $sql );
			$dbClient->query ( $sql );
		} catch ( Error $e ) {
			Utils::error ( $e->getMessage () );
		} finally {
			$dbClient->close ();
		}
	}
	public function getPosts($id) {
		$posts = array ();
		$dbClient = new DBClient ();
		$dbClient->open ();
		try {
			$sql = "select id";
			$sql .= ",topic_id";
			$sql .= ",last_name";
			$sql .= ",first_name";
			$sql .= ",message";
			$sql .= ",date";
			$sql .= " from forum_post";
			$sql .= " where topic_id = '" . $id . "'";
			$sql .= " order by date desc";
			Utils::info ( $sql );
			$result = $dbClient->query ( $sql );
			if ($result->num_rows > 0) {
				while ( $row = $result->fetch_assoc () ) {
					$post = new ForumPost ();
					$post->id = $row ["id"];
					$post->topic_id = $row ["topic_id"];
					$post->last_name = $row ["last_name"];
					$post->first_name = $row ["first_name"];
					$post->message = $row ["message"];
					$post->date = $row ["date"];
					array_push ( $posts, $post );
				}
			}
		} catch ( Error $e ) {
			Utils::error ( $e->getMessage () );
		} finally {
			$dbClient->close ();
		}
		return $posts;
	}
	public function addPost($post) {
		$posts = array ();
		$dbClient = new DBClient ();
		try {
			$dbClient->open ();
			$sql = "insert into forum_post (";
			$sql .= "topic_id";
			$sql .= ",last_name";
			$sql .= ",first_name";
			$sql .= ",message";
			$sql .= ",date) values (";
			$sql .= "'" . $dbClient->escape ( $post->topic_id ) . "'";
			$sql .= ",'" . $dbClient->escape ( $post->last_name ) . "'";
			$sql .= ",'" . $dbClient->escape ( $post->first_name ) . "'";
			$sql .= ",'" . $dbClient->escape ( $post->message ) . "'";
			$sql .= ",now()";
			$sql .= ")";
			Utils::info ( $sql );
			$result = $dbClient->query ( $sql );
			$posts = $this->getPosts ( $post->topic_id );
		} catch ( Error $e ) {
			Utils::error ( $e->getMessage () );
		} finally {
			$dbClient->close ();
		}
		return $posts;
	}
	public function getPost($id) {
		$post = new ForumPost ();
		$dbClient = new DBClient ();
		try {
			$dbClient->open ();
			$sql = "select id";
			$sql .= ",topic_id";
			$sql .= ",last_name";
			$sql .= ",first_name";
			$sql .= ",message";
			$sql .= ",date";
			$sql .= " from forum_post";
			$sql .= " where id = '" . $id . "'";
			Utils::info ( $sql );
			$result = $dbClient->query ( $sql );
			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc ();
				$post->id = $row ["id"];
				$post->topic_id = $row ["topic_id"];
				$post->last_name = $row ["last_name"];
				$post->first_name = $row ["first_name"];
				$post->message = $row ["message"];
				$post->date = $row ["date"];
			}
		} catch ( Error $e ) {
			Utils::error ( $e->getMessage () );
		} finally {
			$dbClient->close ();
		}
		return $post;
	}
	public function updatePost($post) {
		$dbClient = new DBClient ();
		try {
			$dbClient->open ();
			$sql = "update forum_post set ";
			$sql .= "last_name = '" . $post->last_name . "'";
			$sql .= ",first_name = '" . $post->first_name . "'";
			$sql .= ",message = '" . $post->message . "'";
			$sql .= " where id = '" . $post->id . "'";
			Utils::info ( $sql );
			$dbClient->query ( $sql );
		} catch ( Error $e ) {
			Utils::error ( $e->getMessage () );
		} finally {
			$dbClient->close ();
		}
	}
	public function deletePost($id) {
		$dbClient = new DBClient ();
		try {
			$dbClient->open ();
			$sql = "delete from forum_post where id = '" . $id . "'";
			Utils::info ( $sql );
			$result = $dbClient->query ( $sql );
		} catch ( Error $e ) {
			Utils::error ( $e->getMessage () );
		} finally {
			$dbClient->close ();
		}
	}
	public function getUser($username) {
		$user = new ForumUser ();
		$dbClient = new DBClient ();
		try {
			$dbClient->open ();
			$sql = "select id";
			$sql .= ",username";
			$sql .= ",password";
			$sql .= ",role";
			$sql .= " from forum_user";
			$sql .= " where username = '" . $dbClient->escape ( $username ) . "'";
			Utils::info ( $sql );
			$result = $dbClient->query ( $sql );
			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc ();
				$user->id = $row ["id"];
				$user->username = $row ["username"];
				$user->password = $row ["password"];
				$user->role = $row ["role"];
				Utils::info ( 'role:' . $user->role );
			}
		} catch ( Error $e ) {
			Utils::error ( $e->getMessage () );
		} finally {
			$dbClient->close ();
		}
		return $user;
	}
	public function authenticateUser() {
		if (isset ( $_GET ['login'] ) && isset ( $_GET ['password'] )) {
			$login = $_GET ['login'];
			$password = $_GET ['password'];
			$user = $this->getUser ( $login );
			if ($user->password == $password) {
				$_SESSION ['forum_user_role'] = $user->role;
			} else {
				$_SESSION ['forum_user_role'] = null;
			}
		}
	}
	public function checkNotRobot() {
		$robot = true;
		if (isset ( $_POST ['iamnotarobottoken'] )) {
			$token = $_POST ['iamnotarobottoken'];
			if ($token == 'fr54uygsqdrf546xc5vf54q6sd5f4') {
				$robot = false;
			}
		}
		if ($robot) {
			die ( 'Naughty robot.' );
		}
	}
	public function isAdmin() {
		$admin = false;
		if (isset ( $_SESSION ['forum_user_role'] )) {
			$role = $_SESSION ['forum_user_role'];
			if ($role == 'admin' || $role == 'superadmin') {
				$admin = true;
			}
		}
		return $admin;
	}
	public function isSuperAdmin() {
		$admin = false;
		if (isset ( $_SESSION ['forum_user_role'] )) {
			$role = $_SESSION ['forum_user_role'];
			if ($role == 'superadmin') {
				$admin = true;
			}
		}
		return $admin;
	}
}