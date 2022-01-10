<?php

namespace SaintSystems\Nova\LinkableMetrics;

trait LinkableCount
{
    /**
     * The metric value url.
     *
     * @var string
     */
    public $urls = [];

    public function component()
    {
        return 'linkable-'.$this->component;
    }

    /**
     * Set a link to a route
     */
    public function route($routes)
    {
        foreach ($routes as $route) {
            $route = [
                'name' => $route['name'],
                'params' => $route['params'],
                'query' => $route['query']
            ];
            $this->urls[] = json_encode($route);
        }
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