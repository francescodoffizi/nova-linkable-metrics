<?php

namespace SaintSystems\Nova\LinkableMetrics;

use Laravel\Nova\Metrics\PartitionResult;

class LinkableCountPartitionResult extends PartitionResult
{
    use LinkableCount;
}
