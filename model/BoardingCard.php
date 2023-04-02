<?php

/**
 * Modèle représentant les cartes d'embarquement.
 */
class BoardingCard
{
    protected string $transport;
    protected string $from;
    protected string $to;
    protected ?string $transportNumber = null;
    protected ?string $seat = null;
    protected ?string $gate = null;
    protected ?string $bagageManagement = null;

    public static function fromArray(array $array): self
    {
        if (!array_key_exists('transport', $array)
        || (!array_key_exists('from', $array))
        || (!array_key_exists('to', $array))) {
            throw new \Exception('bad array');
        }

        return new self(
            $array['transport'],
            $array['from'],
            $array['to'],
            array_key_exists('transport-number', $array) ? $array['transport-number'] : null,
            array_key_exists('seat', $array) ? $array['seat'] : null,
            array_key_exists('gate', $array) ? $array['gate'] : null,
            array_key_exists('bagage-management', $array) ? $array['bagage-management'] : null
        );
    }

    public function __construct(
        string $transport,
        string $from,
        string $to,
        ?string $transportNumber = null,
        ?string $seat = null,
        ?string $gate = null,
        ?string $bagageManagement = null,
    ) {
        $this->transport = strtolower(trim($transport));
        $this->from = trim($from);
        $this->to = trim($to);
        $this->transportNumber = ($transportNumber !== null) ? strtoupper(trim($transportNumber)) : null;
        $this->seat = ($seat !== null) ? strtoupper(trim($seat)) : null;
        $this->gate = ($gate !== null) ? strtoupper(trim($gate)) : null;
        $this->bagageManagement = ($bagageManagement !== null) ? trim($bagageManagement) : null;
    }

    /**
     * Indique si cet objet est valide en terme de données selon 
     * un ensemble de règles définies ici.
     * Dans l'idée faudrait mieux faire ça avec des validators 
     * et des enums mais comme c'est un exo on se contente de ça.
     * 
     * @throws \Exception
     */
    public function validate(): void
    {
        if (! in_array($this->transport, ['train', 'airport bus', 'flight'])) {
            throw new \Exception("transport must be in ['train', 'airport bus', 'flight']");
        }
    }

    public function getFromLocation(): string
    {
        return $this->from;
    }

    public function getDestination(): string
    {
        return $this->to;
    }

    /**
     * Renvoie une représentation agréable à lire de cet objet.
     */
    public function stringify(): string
    {
        $string = '* Take ';
        $string .= $this->transport . ' ';
        $string .= ($this->transportNumber !== null) ? $this->transportNumber . ' ' : '';
        $string .= 'from ' . $this->from . ' ';
        $string .= 'to ' . $this->to . '. ';
        $string .= ($this->gate !== null) ? 'Gate ' . $this->gate . ' ' : '';
        $string .= ($this->seat !== null) ? 'seat ' . $this->seat . '. ' : 'No seat assignment. ';
        $string .= ($this->bagageManagement !== null) ? 
            (($this->bagageManagement === 'automatic') ? 
                'Baggage will we automatically transferred from your last leg.' : 
                'Bagage drop at ' . $this->bagageManagement . '. ') 
            : '';

        return trim($string);
    }
}