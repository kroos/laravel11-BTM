<?php

namespace App\Notifications\RegAccICMS;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

// load database and mail notifications
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

// load model
use App\Models\Staff;

// load Carbon
use \Carbon\Carbon;
use \Carbon\CarbonPeriod;
use \Carbon\CarbonInterval;

class ICMSApprover extends Notification
{
	use Queueable;

	protected $data;

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
		return ['database', 'mail'];
	}

	/**
	 * Get the mail representation of the notification.
	 */
	public function toMail(object $notifiable): MailMessage
	{
		return (new MailMessage)
					->subject('BTM : Pendaftaran Akaun & Modul ICMS (Sokongan)')
					// ->line('The introduction to the notification.')
					// ->action('Notification Action', url('/'))
					// ->line('Thank you for using our application!');
					->markdown('mail.regaccicms.users.createtoapproveform', [
							'apprv' => $notifiable->name,
							'name' => Staff::find($this->data->nostaf)->nama,
							'link' => route('regaccicms.show', $this->data->id),
					])
					->attach(storage_path('app/public/pdf/').'BTM-RAICMS-'.Carbon::parse($this->data->created_at)->format('ym').str_pad( $this->data->id, 3, "0", STR_PAD_LEFT).'.pdf');
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(object $notifiable): array
	{
		return [
			'data' => 'You have notifications to look into'
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
			'data' => 'New ICMS Account And Module Registration For Approval',
			'link' => route('regaccicms.show', $this->data->id),
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
