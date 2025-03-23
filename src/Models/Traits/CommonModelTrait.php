<?php

namespace Sharenjoy\NoahCms\Models\Traits;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use RalphJSmit\Laravel\SEO\Support\AlternateTag;
use Spatie\Activitylog\LogOptions;

trait CommonModelTrait
{
    public function getFormFields(): array
    {
        return $this->formFields;
    }

    public function getTableFields(): array
    {
        return $this->tableFields;
    }

    protected function getAlternateTag(string $path)
    {
        $items = [];
        $locales = array_keys(config('noah.locale'));

        foreach ($locales as $locale) {
            $items[] = new AlternateTag(
                hreflang: $locale,
                href: LaravelLocalization::getLocalizedURL($locale, $path),
            );
        }

        return $items;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*']);
        // Chain fluent methods for configuration options
    }
}
