<?php

const RULE_SEPARATOR = '|';
const INSTRUCTION_SEPARATOR = ',';

$content = getFileContent("files/t1.txt");

$steps = $content[0];
$instructions = $content[1];

$steps = array_map(fn($sub) => array_map(fn($mem) => (int)$mem, $sub), $steps);
$instructions = array_map(fn($sub) => array_map(fn($mem) => (int)$mem, $sub), $instructions);


$validator = new Validator($steps, $instructions);
$validator->validate();

$validator->sumMiddles();
print_r($validator->sumTotals .PHP_EOL);

// die(var_dump($validator->validInstructions, $validator->invalidInstructions));

class Validator
{
    public array $validInstructions = [];
    public array $invalidInstructions = [];

    private array $ruleSet = [];
    public int $sumTotals = 0;

    public function __construct(public array $steps, public array $instructions) {}

    public function sumMiddles(): void
    {
        foreach ($this->validInstructions as $validInstruction) {
            $middleIndex = (count($validInstruction) - 1) / 2;
            $this->sumTotals += $validInstruction[$middleIndex];
        };
    }

    public function validate(): void
    {
        $this->prepareRuleSet();

        foreach ($this->instructions as $instruction) {
            foreach ($instruction as $number) {

                $valid = $this->checkIfInPlace($number, $instruction);
                // var_dump([$number, $valid]);

                if (!$valid) {
                    $this->invalidInstructions[] = $instruction;
                    continue 2;
                }
            }
            $this->validInstructions[] = $instruction;
        }
    }

    private function checkIfInPlace(int $number, array $instruction)
    {


        if (isset($this->ruleSet[$number])) {
            $indexOfSubject = array_search($number, $instruction);
            $arrayBefore = array_slice($instruction, 0, $indexOfSubject);

            foreach ($this->ruleSet[$number] as $suspect) {
                if (in_array($suspect, $arrayBefore)) {
                    return false;
                }
            }
        }
        return true;
    }

    private function prepareRuleSet(): void
    {
        foreach ($this->steps as $step) {
            $this->ruleSet[$step[0]][] = $step[1];
        }
    }
}


function getFileContent($path): array
{
    $lines = file($path);

    $sequences = [];
    $instructions = [];

    foreach ($lines as $lineContent) {
        if (!empty($lineContent)) {
            if (strpos($lineContent, RULE_SEPARATOR)) {
                $sequences[] = explode(RULE_SEPARATOR, $lineContent);
            } elseif (strpos($lineContent, INSTRUCTION_SEPARATOR)) {
                $instructions[] = explode(INSTRUCTION_SEPARATOR, $lineContent);
            }
        }
    }

    return [$sequences, $instructions];
}
