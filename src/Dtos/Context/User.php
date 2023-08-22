<?php

namespace Onuruslu\TiktokPixelEventNotifier\Dtos\Context;

use Onuruslu\TiktokPixelEventNotifier\Dtos\AbstractDto;

class User extends AbstractDto
{
    protected ?string $externalId = null;

    protected ?string $email = null;

    protected ?string $phoneNumber = null;

    protected ?string $ttp = null;

    public function setExternalId(string $externalId): User
    {
        $this->externalId = hash('sha256', trim($externalId));

        return $this;
    }

    public function setEmail(string $email): User
    {
        $this->email = hash('sha256', trim($email));

        return $this;
    }

    public function setPhoneNumber(string $phoneNumber): User
    {
        $phoneNumber = preg_replace('~\D~', '', $phoneNumber);

        $this->phoneNumber = hash('sha256', '+'.$phoneNumber);

        return $this;
    }

    public function setTtp(string $ttp): User
    {
        $this->ttp = $ttp;

        return $this;
    }

    protected function payload(): array
    {
        return [
            'external_id' => $this->externalId,
            'email' => $this->email,
            'phone_number' => $this->phoneNumber,
            'ttp' => $this->ttp,
        ];
    }
}
