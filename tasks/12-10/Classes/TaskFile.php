<?php

declare(strict_types=1);

class TaskFile
{
    private int $numberOfLines;
    private array $content = [];
    public function __construct(private readonly string $path) {}


    function getContent(): array
    {
        return $this->content;
    }

    function readFileToArray(): void
    {
        $content = [];

        $lines = file($this->path);

        $this->numberOfLines = count($lines);

        foreach ($lines as $lineNumber => $lineContent) {
            $lineContent = trim($lineContent);
            $lineLettersArray = str_split($lineContent);
            foreach ($lineLettersArray as $letter) {
                $this->content[$lineNumber][] = $letter;
            }
        }
    }

    function printContent(): void
    {
        if (empty($this->content)) {
            return;
        }

        print_r($this->content) . PHP_EOL;
    }
}
