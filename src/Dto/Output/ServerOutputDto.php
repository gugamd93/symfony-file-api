<?php

namespace App\Dto\Output;

use JMS\Serializer\Annotation as Serialization;

/**
 * DTO for output Server data
 */
class ServerOutputDto
{
    /**
     * @Serialization\Type("string")
     */
    public string $Model;

    /**
     * @Serialization\Type("string")
     */
    public string $RAM;

    /**
     * @Serialization\Type("string")
     */
    public string $HDD;

    /**
     * @Serialization\Type("string")
     */
    public string $Location;

    /**
     * @Serialization\Type("string")
     */
    public string $Price;
}
