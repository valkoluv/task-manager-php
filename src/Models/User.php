<?php

namespace App\Models;

use App\Database;
use PDO;

class User
{
	private int $id;
	private string $username;
	private string $email;
	private string $password;

	public function __construct(
		int $id = 0,
		string $username = '',
		string $email = '',
		string $password = ''
	) {
		$this->id = $id;
		$this->username = $username;
		$this->email = $email;
		$this->password = $password;
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function getUsername(): string
	{
		return $this->username;
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function getPassword(): string
	{
		return $this->password;
	}

	public function setUsername(string $username): void
	{
		$this->username = $username;
	}

	public function setEmail(string $email): void
	{
		$this->email = $email;
	}

	public function setPassword(string $password): void
	{
		$this->password = $password;
	}

	public function save(): bool
	{
		$pdo = Database::getConnection();

		if ($this->id) {
			$stmt = $pdo->prepare(
				'UPDATE users SET username = :username, email = :email, password = :password WHERE id = :id'
			);
			$stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
		} else {
			$stmt = $pdo->prepare(
				'INSERT INTO users (username, email, password) VALUES (:username, :email, :password)'
			);
		}

		$stmt->bindParam(':username', $this->username, PDO::PARAM_STR);
		$stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
		$stmt->bindParam(':password', $this->password, PDO::PARAM_STR);

		return $stmt->execute();
	}

	public static function findByEmail(string $email): ?User
	{
		$pdo = Database::getConnection();
		$stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		$stmt->execute();

		$userData = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($userData) {
			return new self(
				$userData['id'],
				$userData['username'],
				$userData['email'],
				$userData['password']
			);
		}

		return null;
	}

	public static function findById(int $id): ?User
	{
		$pdo = Database::getConnection();
		$stmt = $pdo->prepare('SELECT * FROM users WHERE id = :id');
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();

		$userData = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($userData) {
			return new self(
				$userData['id'],
				$userData['username'],
				$userData['email'],
				$userData['password']
			);
		}

		return null;
	}

	public static function all()
	{
		$db = Database::getConnection();
		$query = $db->query("SELECT * FROM users");

		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

}
