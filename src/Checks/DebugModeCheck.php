<?php

namespace Spatie\Health\Checks;

use Spatie\Health\Support\Result;

class DebugModeCheck extends Check
{
    protected bool $expected = false;

    public function expectedToBe(bool $bool)
    {
        $this->expected = $bool;

        return $this;
    }

    public function run(): Result
    {
        $actual = config('app.debug');

        $result = Result::make()->meta([
            'actual' => $actual,
            'expected' => $this->expected,
        ]);

        return $this->expected === $actual
            ? $result->ok()
            : $result->failed("The debug mode was expected to be `{$this->convertToWord($this->expected)}`, but actually was `{$this->convertToWord($actual)}`");
    }

    protected function convertToWord(bool $boolean)
    {
        return $boolean ? 'true' : 'false';
    }
}
