<?php

namespace App\Dto\Output\Transformer;

use App\Dto\Output\Transformer\Contract\OutputDtoTransformerInterface;

abstract class AbstractOutputDtoTransformer implements OutputDtoTransformerInterface
{
    public function transformObjects(iterable $objects): iterable
    {
        $dto = [];

        foreach ($objects as $object) {
            $dto[] = $this->transformObject($object);
        }

        return $dto;
    }

}