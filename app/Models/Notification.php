<?php
namespace App\Models;

use Illuminate\Notifications\DatabaseNotification as BaseDatabaseNotification;

class Notification extends BaseDatabaseNotification
{
	protected $connection = 'mysql3';
	protected $table = 'notifications';

	public function getConnectionName()
	{
		return 'mysql3'; // Replace with your desired connection name
	}
}
