<?php

const RULE_SEPARATOR = '|';
const INSTRUCTION_SEPARATOR = ',';

$content = getFileContent("files/t2.example.txt");

$steps = $content[0];
$instructions = $content[1];

$steps = array_map(fn($sub) => array_map(fn($mem) => (int)$mem, $sub), $steps);
$instructions = array_map(fn($sub) => array_map(fn($mem) => (int)$mem, $sub), $instructions);


$validator = new Validator($steps, $instructions);
$validator->validate();

$validator->sumMiddles();


// $validator->logInfo();
$validator->correctInvalidInstructionsV2();
die(var_dump($validator->correctedTotals));

// die(var_dump($validator->validInstructions, $validator->invalidInstructions));

class Validator
{
    public array $validInstructions = [];
    public array $invalidInstructions = [];

    public array $correctedInstructions = [];

    private array $ruleSet = [];
    public int $sumTotals = 0;
    public int $correctedTotals = 0;

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


    public function correctInvalidInstructionsV2(): void
    {
        foreach ($this->invalidInstructions as $invalidInstruction) {
            $corrected = $this->correct($invalidInstruction);
            $this->correctedInstructions[] = $corrected;
        }

        $this->sumTotals = 0; // Reset sumTotals for corrected instructions
        foreach ($this->correctedInstructions as $correctedInstruction) {
            $middleIndex = (count($correctedInstruction) - 1) / 2;
            $this->correctedTotals += $correctedInstruction[$middleIndex];
        }
    }

    public function logInfo(): void
    {

        foreach ($this->invalidInstructions as $invalidInstruction) {
            foreach ($invalidInstruction as $number) {
                if (!$this->checkIfInPlace($number, $invalidInstruction)) {
                    $instruction = implode(",", $invalidInstruction);
                    $ruleSet = implode(",", $this->ruleSet[$number]);
                    print_r("_______BEGIN____"
                        . PHP_EOL
                        . "\tIncorrect place for $number"
                        . PHP_EOL
                        . "\tin  $instruction"
                        . PHP_EOL
                        . "\trules $ruleSet");

                    $numbersInWrongPlaces = $this->numbersWrong($invalidInstruction, $this->ruleSet[$number], $number);
                    $strauk = implode(", ", $numbersInWrongPlaces);
                    print_r(
                        PHP_EOL .
                            "\tNumbers in wrong places $strauk"
                            . PHP_EOL  . PHP_EOL
                            . "_______END_______"
                            . PHP_EOL
                    );
                }
                $indexOfNumber = array_search($number, $invalidInstruction);
            }

            $this->correctedInstructions[] = $invalidInstruction;
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

    private function correct(array $invalid): array
    {
        $graph = [];
        $inDegree = [];
        $presentInInstruction = array_flip($invalid);
        die(var_dump($presentInInstruction));

        foreach ($this->steps as $step) {
            [$from, $to] = $step;

            if (isset($presentInInstruction[$from]) && isset($presentInInstruction[$to])) {
                $graph[$from][] = $to;
                $inDegree[$to] = ($inDegree[$to] ?? 0) + 1;
                $inDegree[$from] = $inDegree[$from] ?? 0;
            }
        }

        $queue = [];
        foreach ($invalid as $node) {
            if (($inDegree[$node] ?? 0) === 0) {
                $queue[] = $node;
            }
        }

        $sorted = [];
        while ($queue) {
            $current = array_shift($queue);
            $sorted[] = $current;

            foreach ($graph[$current] ?? [] as $neighbor) {
                $inDegree[$neighbor]--;
                if ($inDegree[$neighbor] === 0) {
                    $queue[] = $neighbor;
                }
            }
        }

        return $sorted;
    }

    private function numbersWrong(array $instruction, array $rules, int $wrongNumber): array
    {
        $wrongIndex = array_search($wrongNumber, $instruction);
        $numbersInWrongPlaces = [];
        foreach (array_slice($instruction, 0, $wrongIndex) as $number) {
            if (array_search($number, $rules)) {
                $numbersInWrongPlaces[] = $number;
            }
        }
        return $numbersInWrongPlaces;
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
