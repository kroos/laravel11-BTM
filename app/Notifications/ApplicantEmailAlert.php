<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicantEmailAlert extends Notification
{
	use Queueable;

	public $data;

	/**
	 * Create a new notification instance.
	 */
	public function __construct($data)
	{
		$this->data = $data;
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @return array<int, string>
	 */
	public function via(object $notifiable): array
	{
		// return ['mail'];
		return ['database'];
	}

	/**
	 * Get the mail representation of the notification.
	 */
	public function toMail(object $notifiable): MailMessage
	{
		return (new MailMessage)
					->line('The introduction to the notification.')
					->action('Notification Action', url('/'))
					->line('Thank you for using our application!');
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(object $notifiable): array
	{
		return [
			'data' => 'Your have notifications to look into'
		];
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @return database<string, mixed>
	 */
	public function toDatabase(object $notifiable): array
	{
		return [
			'data' => 'New email registration application',
			'link' => route('emailaccapp.show', $this->data),
		];
	}

	/**
	 * Get the notification's database type.
	 *
	 * @return string
	 */
	// public function databaseType(object $notifiable): string
	// {
	// 	return [
	// 		//
	// 	];
	// }

}