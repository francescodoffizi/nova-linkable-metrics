<?php

namespace SaintSystems\Nova\LinkableMetrics;

trait LinkableMultiple
{
    public $urls = [''];

    public function component()
    {
        return 'linkable-'.$this->component;
    }

    /**
     * Set a link to a route
     */
    public function route($routeName, array $params = [], array $query = [])
    {
        $route = [
            'name' => $routeName,
            'params' => $params,
            'query' => $query
        ];
        $urls[] = $this->url(json_encode($route));
        return $urls;
    }

    /**
     * Which url should the metric link to
     */
    public function url($url)
    {
        return $this->withMeta(['url' => $url]);
    }

}