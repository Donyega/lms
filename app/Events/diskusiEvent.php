<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class diskusiEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $idtopik,$iduser,$pesan,$nama,$foto,$diskusi,$balas;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($idtopik,$iduser,$pesan,$nama,$foto,$diskusi,$balas)
    {
        $this->idtopik = $idtopik;
        $this->iduser = $iduser;
        $this->pesan = $pesan;
        $this->nama = $nama;
        $this->foto = $foto;
        $this->diskusi = $diskusi;
        $this->balas = $balas;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('diskusi.'.$this->idtopik);
    }
}
