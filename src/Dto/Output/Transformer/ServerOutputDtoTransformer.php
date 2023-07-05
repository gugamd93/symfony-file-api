<?php

namespace App\Dto\Output\Transformer;

use App\Dto\Exception\UnexpectedTypeException;
use App\Dto\Output\ServerOutputDto;
use App\Model\ServerRow;

class ServerOutputDtoTransformer extends AbstractOutputDtoTransformer
{

    /**
     * @param ServerRow $object
     * @return ServerOutputDto
     * @throws UnexpectedTypeException
     */
    public function transformObject($object): ServerOutputDto
    {
        if (!$object instanceof ServerRow) {
            throw new UnexpectedTypeException('Expected type of ServerRow but got ' . \get_class($object));
        }

        $dto = new ServerOutputDto();
        $dto->Model = $object->getModel();
        $dto->RAM = $object->getFullRamDescription();
        $dto->HDD = $object->getFullStorageDescription();
        $dto->Location = $object->getLocation();
        $dto->Price = $object->getPrice();

        return $dto;
    }
}