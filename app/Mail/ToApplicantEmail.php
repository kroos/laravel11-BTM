<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

// mailer
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Address;

// load model
use App\Models\Staff;

// load Carbon
use \Carbon\Carbon;
use \Carbon\CarbonPeriod;
use \Carbon\CarbonInterval;

class ToApplicantEmail extends Mailable
{
	use Queueable, SerializesModels;

		public $data;

	/**
	 * Create a new message instance.
	 */
	public function __construct($data)
	{
		// dd($data->nostaf, $this->data);
		$this->data = $data;
		// dd($this->data);
	}

	/**
	 * Get the message envelope.
	 */
	public function envelope(): Envelope
	{
		return new Envelope(
			from: new Address(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME')),
			subject: 'BTM Email Registering Application Form : Processing Update',
		);
	}

	/**
	 * Get the message content definition.
	 */
	public function content(): Content
	{
		return new Content(
			markdown: 'mail.EmailApplicationForm',
			with: [
				'name' => Staff::find($this->data->nostaf)->nama,
				'link' => route('emailaccapp.show', $this->data->id),
			]
		);
	}

	/**
	 * Get the attachments for the message.
	 *
	 * @return array<int, \Illuminate\Mail\Mailables\Attachment>
	 */
	public function attachments(): array
	{
		return [
			Attachment::fromPath(storage_path('app/public/pdf/').'BTM-ER-'.Carbon::parse($this->data->created_at)->format('ym').str_pad( $this->data->id, 3, "0", STR_PAD_LEFT).'.pdf'),
		];
	}
}
