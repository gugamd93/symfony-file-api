<?php

namespace App\Dto\Output\Transformer\Contract;

interface OutputDtoTransformerInterface
{
    public function transformObject($object);
    public function transformObjects(iterable $objects): iterable;
}