<?php

namespace Sharenjoy\NoahCms\Utils\Forms;

use Filament\Forms\Set;
use Overtrue\Pinyin\Pinyin;

abstract class FormAbstract
{
    protected $field;

    public function __construct(
        protected string $fieldName,
        protected array $content,
        protected array $translatable,
        protected string $model,
        protected $ownerRecord = null,
    ) {
        // dd($fieldName, $content, $translatable, $model);
    }

    protected function resolve()
    {
        $this->rules();
        $this->translatable();
        $this->slug();
        $this->disable();
        $this->live();
        $this->span();
    }

    protected function rules()
    {
        if ($this->content['required'] ?? false) {
            $this->field = $this->field->required();
        }

        if ($this->content['rules'] ?? false) {
            $this->field = $this->field->rules($this->content['rules']);
        }
    }

    protected function translatable()
    {
        if (in_array($this->fieldName, $this->translatable)) {
            $localeRules = [];
            if ($this->content['localeRules'] ?? false) {
                $localeRules = $this->content['localeRules'];
            } elseif ($this->content['rules'] ?? false) {
                $localeRules = config('noah-cms.locale');
                foreach ($localeRules ?? [] as $locale => $value) {
                    $localeRules[$locale] = $this->content['rules'];
                }
            }

            $this->field = $this->field->translatable(true, null, $localeRules);
        }
    }

    protected function slug()
    {
        if ($this->content['slug'] ?? false) {
            $this->field = $this->field->live(onBlur: true)
                ->afterStateUpdated(function (string $operation, $state, Set $set) {
                    if (in_array($this->fieldName, $this->translatable)) {
                        if (empty($state[$this->fieldName]['zh_TW']) && empty($state[$this->fieldName]['en'])) {
                            return;
                        }
                        $convertStr = $state[$this->fieldName]['en'] ?: $state[$this->fieldName]['zh_TW'];
                    } else {
                        if (empty($state)) return;
                        $convertStr = $state;
                    }

                    $operation === 'create' ? $set('slug', str()->slug(Pinyin::convert($convertStr))) : null;
                });
        }
    }

    protected function span()
    {
        $this->field = $this->field->columnSpanFull();
    }

    protected function disable()
    {
        if ($this->content['disable'] ?? false) {
            $this->field = $this->field->disabled(function (string $operation) {
                return $operation === $this->content['disable'] ? true : false;
            });
        }
    }

    protected function live()
    {
        if ($this->content['live'] ?? false) {
            $this->field = $this->field->live();
        }
    }
}
