<?php

namespace SaintSystems\Nova\LinkableMetrics;

trait LinkableCount
{
    /**
     * The metric value url.
     *
     * @var array
     */
    public $urls = [];

    /**
     * Set the metric value url.
     *
     * @param  string  $url
     * @return $this
     */
    public function urls($urls)
    {
        $this->urls = $urls;

        return $this;
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
     * Prepare the metric for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), [
            'urls' => $this->urls,
        ]);
    }
}