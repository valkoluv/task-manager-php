<?php

namespace App\Controllers;

use App\Models\User;

class UserController
{
	public function register()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$username = $_POST['username'];
			$email = $_POST['email'];
			$password = $_POST['password'];
			$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

			$user = new User();
			$user->setUsername($username);
			$user->setEmail($email);
			$user->setPassword($hashedPassword);
			$user->save();

			header('Location: /login');
			exit;
		}

		require_once 'views/register.php';
	}

	public function login()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$email = $_POST['email'];
			$password = $_POST['password'];

			$user = User::findByEmail($email);

			if ($user && password_verify($password, $user->getPassword())) {
				session_start();
				$_SESSION['user_id'] = $user->getId();

				header('Location: /task/list');
				exit;
			} else {
				$error = "Invalid email or password.";
			}
		}

		require_once 'views/login.php';
	}

	public function logout()
	{
		session_start();
		session_destroy();

		header('Location: /login');
		exit;
	}

	public function changePassword()
	{
		if (!isset($_SESSION['user_id'])) {
			header('Location: /login');
			exit;
		}

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$userId = $_SESSION['user_id'];
			$oldPassword = $_POST['old_password'];
			$newPassword = $_POST['new_password'];
			$newPasswordConfirm = $_POST['new_password_confirm'];

			$user = User::findById($userId);

			if (password_verify($oldPassword, $user->getPassword())) {
				if ($newPassword === $newPasswordConfirm) {
					$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
					$user->setPassword($hashedPassword);
					$user->save();

					header('Location: /profile');
					exit;
				} else {
					$error = "New passwords do not match.";
				}
			} else {
				$error = "Old password is incorrect.";
			}
		}

		require_once 'views/changePassword.php';
	}
}
