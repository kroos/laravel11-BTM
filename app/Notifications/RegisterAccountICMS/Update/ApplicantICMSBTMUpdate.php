<?php

namespace App\Notifications\RegisterAccountICMS\Delete;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

// load model
use App\Models\Staff;

// load Carbon
use \Carbon\Carbon;
use \Carbon\CarbonPeriod;
use \Carbon\CarbonInterval;

class ApplicantICMSBTMUpdate extends Notification
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
			->subject('BTM : (BTM03) Updated Application of Account & ICMS Modules For Approval')
			->greeting('BTMgo')
			->line('Dear ' . $notifiable->nama . ',')
			->line('This is to inform you that '.Staff::find($this->data->nostaf)->nama.', has updated a request for account & ICMS modules. The details of the application are available in the system for your review.')
			->line('Please find the attached PDF form for your reference. Kindly log into the system to access the request and provide your approval or rejection based on your discretion. You have the authority to approve or decline this application as you see fit.')
			->line('If you have any questions or require further information regarding the request, feel free to reach out.')
			->action('View Form', route('btmicmsrequester.show', $this->data->id))
			->line('Thank you for your attention to this matter.')
			->line(config('app.name'))
			->attach(storage_path('app/public/pdf/').'BTM-RAICMS-ADM-'.Carbon::parse($this->data->created_at)->format('ym').str_pad( $this->data->id, 3, "0", STR_PAD_LEFT).'.pdf');
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
			'data' => '(BTM02) Updated account & ICMS modules',
			'link' => route('btmicmsrequester.show', $this->data->id),
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
