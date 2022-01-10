<?php

namespace SaintSystems\Nova\LinkableMetrics;

use Laravel\Nova\Metrics\TrendResult;

class LinkableCountPartitionResult extends TrendResult
{
    use LinkableCount;
}
