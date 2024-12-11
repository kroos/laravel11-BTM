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

class ToApproverEmail extends Mailable
{
	use Queueable, SerializesModels;

		public $data1;
		public $data2;

	/**
	 * Create a new message instance.
	 */
	public function __construct($data1, $data2)
	{
		// dd($data1->nostaf, $this->data1);
		$this->data1 = $data1;
		$this->data2 = $data2;
		// dd($this->data2->first()->nama);
	}

	/**
	 * Get the message envelope.
	 */
	public function envelope(): Envelope
	{
		return new Envelope(
			from: new Address(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME')),
			subject: 'Approval Request for New Reistration Email Application',
		);
	}

	/**
	 * Get the message content definition.
	 */
	public function content(): Content
	{
		return new Content(
			markdown: 'mail.EmailApplicationFormToApprove',
			with: [
				'apprv' =>$this->data2->first()->nama,
				'name' => Staff::find($this->data1->nostaf)->nama,
				'link' => route('emailaccapp.show', $this->data1->id),
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
			Attachment::fromPath(storage_path('app/public/pdf/').'BTM-ER-'.Carbon::parse($this->data1->created_at)->format('ym').str_pad( $this->data1->id, 3, "0", STR_PAD_LEFT).'.pdf'),
		];
	}
}
