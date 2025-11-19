<?php

namespace App\Enums;

enum TaskStatus: string
{
	case Pending = 'pending';
	case InProgress = 'in_progress';
	case Completed = 'completed';
	case Archived = 'archived';

	public function label(): string
	{
		return match ($this) {
			self::Pending => 'Pending',
			self::InProgress => 'In Progress',
			self::Completed => 'Completed',
			self::Archived => 'Archived',
		};
	}

	public static function isValid(string $status): bool
	{
		return in_array($status, self::getValues(), true);
	}

	public static function getValues(): array
	{
		return array_map(fn($status) => $status->value, self::cases());
	}

}
