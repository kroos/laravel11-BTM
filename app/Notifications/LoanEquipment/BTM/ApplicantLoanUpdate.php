<?php

namespace App\Notifications\LoanEquipment\BTM;

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

class ApplicantLoanUpdate extends Notification
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
		return [/*'database', */'mail'];
	}

	/**
	 * Get the mail representation of the notification.
	 */
	public function toMail(object $notifiable): MailMessage
	{
		return (new MailMessage)
			->subject('BTM : (BTM03) Approval Application of Loan Equipment')
			->greeting('BTMgo')
			->line('Dear ' . $notifiable->name . ',')
			->line('We hope this email finds you well.')
			->line('We would like to inform that your application is currently been given approval by '.Staff::find($this->data->btm_approver)->nama.'.')
			->line('For your reference, please find the attached copy of your application form.')
			->line('Should you need further assistance, please feel free to reach out Bahagian Teknologi Maklumat, UniSHAMS.')
			->line('Thank you for your attention.')
			// ->action('View Form', route('loanapp.show', $this->data->id))
			->line('Thank you for your attention to this matter.')
			->line(config('app.name'))
			->attach(storage_path('app/public/pdf/').'BTM-LE-ADM-'.Carbon::parse($this->data->created_at)->format('ym').str_pad( $this->data->id, 3, "0", STR_PAD_LEFT).'.pdf');
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
			'data' => '(BTM03) Approval loan equipment',
			'link' => route('loanapp.show', $this->data->id),
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
