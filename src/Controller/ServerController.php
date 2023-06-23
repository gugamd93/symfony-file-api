<?php

namespace App\Controller;

use App\Repository\Contract\CustomRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\CacheInterface;


class ServerController extends AbstractController
{

    public function __construct(
        private readonly CustomRepositoryInterface $repository,
        private readonly CacheInterface            $cache,
    )
    {
    }

    #[Route('/server', name: 'app_server')]
    public function index(Request $request): JsonResponse
    {
        $repository = $this->cache->get('ServerRepositoryLoad', function (ItemInterface $item): CustomRepositoryInterface
        {
            $item->expiresAfter(3600);

            return $this->repository->load();
        });

        $filterValues = $request->query->all('filter');

        $filteredData = $this->cache->get(md5(implode($filterValues)),
            function (ItemInterface $item) use ($repository, $filterValues): array
            {
                $item->expiresAfter(3600);

                return $repository->filter($filterValues);
            }
        );
        
        return $this->json($filteredData);
    }
}
