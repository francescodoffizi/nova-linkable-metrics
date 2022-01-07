<?php

namespace SaintSystems\Nova\LinkableMetrics;

use Illuminate\Database\Eloquent\Builder;

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
    public function route($urls)
    {
        $routes = [];
        foreach ($urls as $url) {
            $route = [
                'name' => $url['routeName'],
                'params' => $url['params'],
                'query' => $url['query']
            ];
            $routes[] = $route;
        }
        return $this->urls(json_encode($routes));
    }

    /**
     * Which url should the metric link to
     */
    public function urls($urls)
    {
        return $this->withMetza(['urls' => $urls]);
    }

}