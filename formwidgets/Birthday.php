<?php

namespace Martin\Birthdays\FormWidgets;

use Carbon\Carbon;
use Backend\Classes\FormField;
use Backend\Classes\FormWidgetBase;
use System\Helpers\DateTime as DateTimeHelper;

class Birthday extends FormWidgetBase {

    public $mode = 'datetime';
    public $format = null;
    public $minDate = null;
    public $maxDate = null;
    public $yearRange = null;
    public $firstDay = 0;
    public $ignoreTimezone = false;

    protected $defaultAlias = 'birthday';

    public function init() {
        $this->fillFromConfig([
            'format',
            'mode',
            'minDate',
            'maxDate',
            'yearRange',
            'firstDay',
            'ignoreTimezone',
        ]);
        $this->mode = strtolower($this->mode);
        if ($this->minDate !== null) {
            $this->minDate = is_integer($this->minDate)
                ? Carbon::createFromTimestamp($this->minDate)
                : Carbon::parse($this->minDate);
        }
        if ($this->maxDate !== null) {
            $this->maxDate = is_integer($this->maxDate)
                ? Carbon::createFromTimestamp($this->maxDate)
                : Carbon::parse($this->maxDate);
        }
    }

    public function render() {
        $this->prepareVars();
        return $this->makePartial('birthday');
    }

    public function prepareVars() {
        if ($value = $this->getLoadValue()) {
            $value = DateTimeHelper::makeCarbon($value, false);
            $value = $value instanceof Carbon ? $value->toDateTimeString() : $value;
        }
        $this->vars['name'] = $this->getFieldName();
        $this->vars['value'] = $value ?: '';
        $this->vars['field'] = $this->formField;
        $this->vars['mode'] = $this->mode;
        $this->vars['minDate'] = $this->minDate;
        $this->vars['maxDate'] = $this->maxDate;
        $this->vars['yearRange'] = $this->yearRange;
        $this->vars['firstDay'] = $this->firstDay;
        $this->vars['ignoreTimezone'] = $this->ignoreTimezone;
        $this->vars['format'] = $this->format;
        $this->vars['formatMoment'] = $this->getDateFormatMoment();
        $this->vars['formatAlias'] = $this->getDateFormatAlias();
    }

    public function getSaveValue($value) {
        if ($this->formField->disabled || $this->formField->hidden) {
            return FormField::NO_SAVE_DATA;
        }
        if (!strlen($value)) {
            return null;
        }
        return $value;
    }

    protected function getDateFormatMoment() {
        if ($this->format) {
            return DateTimeHelper::momentFormat($this->format);
        }
    }

    protected function getDateFormatAlias() {
        if ($this->format) {
            return null;
        }
        if ($this->mode == 'time') {
            return 'time';
        } elseif ($this->mode == 'date') {
            return 'dateLong';
        } else {
            return 'dateTimeLong';
        }
    }

}