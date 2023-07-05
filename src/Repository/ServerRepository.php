<?php

namespace App\Repository;

use App\Model\Contract\CustomModelInterface;
use App\Model\ServerRow;
use App\Repository\Contract\CustomRepositoryInterface;

class ServerRepository implements CustomRepositoryInterface
{
    public function __construct(
        private readonly CustomModelInterface $model,
    )
    {
    }

    public function get(bool $flushCache = false): array
    {
        return $this->model->getData($flushCache);
    }

    /**
     * @return ServerRow[]
     */
    public function filter(array $filterCondition): array
    {
        return $this->model->filter($filterCondition);
    }

    public function load(): self
    {
        $this->model->load();
        $this->model->buildData();
        return $this;
    }
}
