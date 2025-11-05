<?php

namespace App\Mail;

use App\Models\ServiceRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RequestApproved extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public ServiceRequest $serviceRequest
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Permohonan Disetujui - Menunggu Penugasan - ' . $this->serviceRequest->request_number,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.request-approved',
            with: [
                'serviceRequest' => $this->serviceRequest,
                'assignmentUrl' => route('service-requests.show', $this->serviceRequest),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
