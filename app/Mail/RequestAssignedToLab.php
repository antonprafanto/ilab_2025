<?php

namespace App\Mail;

use App\Models\ServiceRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RequestAssignedToLab extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public ServiceRequest $serviceRequest
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Permohonan Ditugaskan ke Lab Anda - ' . $this->serviceRequest->request_number,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.request-assigned-to-lab',
            with: [
                'serviceRequest' => $this->serviceRequest,
                'assignUrl' => route('service-requests.show', $this->serviceRequest),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
