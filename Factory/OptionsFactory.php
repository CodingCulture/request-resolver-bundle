<?php

namespace CodingCulture\RequestResolverBundle\Factory;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class OptionsFactory
 * @package App\CodingCulture\RequestResolverBundle\Factory
 */
class OptionsFactory
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public static function createFromFormData(Request $request): array
    {
        $options = [];

        if ($request->query->count()) {
            $options = array_replace_recursive($options, $request->query->all());
        }

        if ($request->request->count()) {
            $options = array_replace_recursive($options, $request->request->all());
        }

        if ($request->files->count()) {
            $options = array_replace_recursive($options, $request->files->all());
        }

        $options = array_replace_recursive($options, $request->attributes->get('_route_params'));

        return $options;
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public static function createFromJSON(Request $request): array
    {
        $options = [];

        $body = json_decode($request->getContent(), true);

        if (is_null($body)) {
            throw new HttpException(Response::HTTP_BAD_REQUEST, 'You cannot send an empty body');
        }

        if ($request->query->count()) {
            $options = array_replace_recursive($options, $request->query->all());
        }

        if ($request->files->count()) {
            $options = array_replace_recursive($options, $request->files->all());
        }

        $options = array_replace_recursive($options, $body);

        return array_replace_recursive($options, $request->attributes->get('_route_params'));
    }
}
