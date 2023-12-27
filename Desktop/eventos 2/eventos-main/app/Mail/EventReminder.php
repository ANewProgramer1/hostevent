<?php

namespace App\Mail;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;

class EventReminder extends Mailable
{
    use Queueable, SerializesModels;
    private $event;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('Lembrete de evento: ' . $this->event->title);
        $this->to($this->event->organizer_email, $this->event->organizer_name);

        $eventId = Hash::make($this->event->id);
        while (strstr($eventId, '/', true)) {
            $eventId = Hash::make($this->event->id);
        }

        return $this->view('mailReset.eventReminder', ['event' => $this->event, 'eventId' => $eventId]);
    }
}
