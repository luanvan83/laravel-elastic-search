<?php
namespace App\Libraries;

use Monolog\Formatter\JsonFormatter;
use Monolog\LogRecord;

class CustomJsonFormatter extends JsonFormatter {
    /**
     * @inheritDoc
     */
    public function format(LogRecord $record): string
    {
        if (isset($record['extra']) && $record['extra'] === []) {
            $record['extra']['app'] = config('app.name');
        }
        return parent::format($record);
    }
}
