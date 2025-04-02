<?php

namespace Sharenjoy\NoahCms\Utils\Tables;

abstract class TableAbstract
{
    public function __construct(
        protected string $fieldName,
        protected array $content
    ) {}
}
