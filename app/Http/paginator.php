<?php


namespace App\Http;

use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Validation\Validator;
use League\Fractal\Resource\Collection;

abstract class Paginator
{
    /**
     * @param array $array
     * @param array $headers
     * @return ResponseFactory
     */
    public function withArray(array $array, array $headers = [])
    {
        return response()->json($array, $this->statusCode, $headers);
    }

    /**
     * Respond with a paginator, and a transformer.
     *
     * @param LengthAwarePaginator $paginator
     * @param callable|\League\Fractal\TransformerAbstract $transformer
     * @param string $resourceKey
     * @param array $meta
     * @return ResponseFactory
     */
    public function withPaginator(LengthAwarePaginator $paginator, $transformer, $resourceKey = null, $meta = [])
    {
        $queryParams = array_diff_key($_GET, array_flip(['page']));
        $paginator->appends($queryParams);

        $resource = new Collection($paginator->items(), $transformer, $resourceKey);
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        foreach ($meta as $metaKey => $metaValue) {
            $resource->setMetaValue($metaKey, $metaValue);
        }

        $rootScope = $this->manager->createData($resource);

        return $this->withArray($rootScope->toArray());
    }

    /**
     * Generates a Response with a 400 HTTP header and a given message from validator
     *
     * @param Validator $validator
     * @return ResponseFactory
     */
    public function errorWrongArgsValidator(Validator $validator)
    {
        return $this->errorWrongArgs($validator->getMessageBag()->toArray());
    }
}
