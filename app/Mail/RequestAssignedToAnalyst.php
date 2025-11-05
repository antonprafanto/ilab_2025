<?php

namespace App\Mail;

use App\Models\ServiceRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RequestAssignedToAnalyst extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public ServiceRequest $serviceRequest,
        public string $recipientType = 'user'
    ) {}

    public function envelope(): Envelope
    {
        $subject = $this->recipientType === 'analyst'
            ? 'Tugas Baru - Permohonan Layanan - ' . $this->serviceRequest->request_number
            : 'Permohonan Anda Sedang Diproses - ' . $this->serviceRequest->request_number;

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.request-assigned-to-analyst',
            with: [
                'serviceRequest' => $this->serviceRequest,
                'recipientType' => $this->recipientType,
                'detailUrl' => route('service-requests.show', $this->serviceRequest),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
