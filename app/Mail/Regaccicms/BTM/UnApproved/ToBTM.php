<?php

namespace App\Mail\Regaccicms\Users;

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
use App\Models\Login;

// load Carbon
use \Carbon\Carbon;
use \Carbon\CarbonPeriod;
use \Carbon\CarbonInterval;

class ToBTM extends Mailable
{
	use Queueable, SerializesModels;

	public $data1;
	public $data2;

	/**
	 * Create a new message instance.
	 */
	public function __construct($data1, $data2)
	{
		$this->data1 = $data1;
		$this->data2 = $data2;
		// dd($this->data1,
		// 	$this->data2,
		// 	$this->data2->nostaf,
		// 	Login::where('nostaf', $this->data2->nostaf)->where('is_active', 1)->first()->name,
		// 	$this->data2->id,
		// 	Carbon::parse($this->data2->created_at)->format('ym'),
		// 	storage_path('app/public/pdf/').'BTM-ER-'.Carbon::parse($this->data2->created_at)->format('ym').str_pad($this->data2->id, 3, "0", STR_PAD_LEFT).'.pdf'
		// );
	}

	/**
	 * Get the message envelope.
	 */
	public function envelope(): Envelope
	{
		return new Envelope(
			from: new Address(config('mail.from.address'), config('mail.from.name')),
			subject: 'BTM : Pendaftaran Akaun & Modul ICMS (Admin)',
		);
	}

	/**
	 * Get the message content definition.
	 */
	public function content(): Content
	{
		return new Content(
			view: 'mail.regaccicms.users.createtobtmform',
			with: [
				'admin' =>$this->data1->name,
				'name' => Login::where('nostaf', $this->data2->nostaf)->where('is_active', 1)->first()->name,
				// 'name' => $this->data2->nostaf,
				'link' => route('regaccicms.show', $this->data2->id),
				// 'link' => route('regaccicms.show', $this->data1->id),
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
			Attachment::fromPath(storage_path('app/public/pdf/').'BTM-RAICMS-'.Carbon::parse($this->data2->created_at)->format('ym').str_pad($this->data2->id, 3, "0", STR_PAD_LEFT).'.pdf'),
		];
	}
}
