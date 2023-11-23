<?php

namespace App\Controller;

use App\Dto\Output\Transformer\ServerOutputDtoTransformer;
use App\Repository\Contract\CustomRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\CacheInterface;


class ServerController extends AbstractController
{

    // Dependency Injection
    public function __construct(
        private readonly CustomRepositoryInterface $repository,
        private readonly CacheInterface            $cache,
        private readonly ServerOutputDtoTransformer $transformer,
    )
    {
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Psr\Cache\InvalidArgumentException
     */
    #[Route('/server', name: 'app_server')]
    public function index(Request $request): JsonResponse
    {
        // Loads the repository. This is based on CacheInterface, so as the
        // data is static in a file, we don't need dynamic keys for this cache.
        // This is cached because loading a repository implies that the database file
        // will be load and transformed
        $repository = $this->cache->get('ServerRepositoryLoad', function (ItemInterface $item): CustomRepositoryInterface
        {
            $item->expiresAfter(3600);

            return $this->repository->load();
        });

        // Getting filter values form request
        $filterValues = $request->query->all('filter');

        // Here I decided to use a hash as the cache key. So I hash the filter values
        // extracted from queryString and cache it. Thus, future requests with the same
        // filtering conditions should be cached
        $filteredData = $this->cache->get(md5(json_encode($filterValues)),
            function (ItemInterface $item) use ($repository, $filterValues): array
            {
                $item->expiresAfter(3600);

                return $repository->filter($filterValues);
            }
        );

        $dto = $this->transformer->transformObjects($filteredData);

        return $this->json($dto);
    }
}
