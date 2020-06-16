<?php
class ForumUser {
	public $id;
	public $username;
	public $password;
	public $role;
	public function __construct() {
	}
	public function isAdmin() {
		return $this->role == 'admin';
	}
	public function isSuperAdmin() {
		return $this->role == 'superadmin';
	}
}