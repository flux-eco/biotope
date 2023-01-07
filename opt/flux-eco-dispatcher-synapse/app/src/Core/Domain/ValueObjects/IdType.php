<?php

namespace FluxEco\MessageDispatcherSidecar\Core\Domain\ValueObjects;

use Exception;

enum IdType: string
{
    case UUID4 = "uuid4";

    /**
     * @throws Exception
     */
    public function generateId() : string
    {
        return match ($this) {
            self::UUID4 => $this->generateUuid4()
        };
    }

    /**
     * @throws Exception
     */
    private function generateUuid4() : string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6])&0x0f|0x40); // set version to 0100
        $data[8] = chr(ord($data[8])&0x3f|0x80); // set bits 6-7 to 10
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}