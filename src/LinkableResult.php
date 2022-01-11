<?php

namespace SaintSystems\Nova\LinkableMetrics;

use Illuminate\Database\Eloquent\Builder;

trait LinkableResult
{
    /**
     * The metric value url.
     *
     * @var string
     */
    public $urls;

    /**
     * Set the metric value url.
     *
     * @param  array  $urls
     * @return $this
     */
    public function urls($urls)
    {
        $this->urls = $urls;

        return $this;
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
