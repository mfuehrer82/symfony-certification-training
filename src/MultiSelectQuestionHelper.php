<?php

namespace Workout;

use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * @package Workout
 */
class MultiSelectQuestionHelper
{
    /**
     * @var mixed
     */
    private $answer;

    /**
     * @var InputInterface
     */
    private $input;

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var Helper
     */
    private $helper;

    /**
     * @var SymfonyStyle
     */
    private $io;

    /**
     * SimpleQuestion constructor.
     */
    public function __construct(InputInterface $input, OutputInterface $output, Helper $helper)
    {
        $this->input = $input;
        $this->output = $output;
        $this->helper = $helper;
        $this->io = new SymfonyStyle($input, $output);
    }

    /**
     * @param string $question
     * @param array  $choices
     * @param array  $solution
     */
    public function ask($question, $choices, $solution = null)
    {
        $choiceQuestion = $this->getQuestion($question, $choices, $solution);
        $this->answer = $this->helper->ask($this->input, $this->output, $choiceQuestion);
    }

    /**
     * @param array $solution
     */
    public function handleAnswer($solution)
    {
        if ($this->isAnswerCorrect($solution)) {
            $this->io->success(sprintf('Your answer %s is correct.',  implode(', ', $this->answer)));
        } else {
            $this->io->error(sprintf('Your answer %s is wrong.',  implode(', ', $this->answer)));
            $this->io->note(sprintf('The correct answer is %s',  implode(', ', $solution)));
        }
    }

    /**
     * @param array $solution
     *
     * @return bool
     */
    private function isAnswerCorrect($solution)
    {
        return array_values($this->answer) == array_values($solution);
    }

    /**
     * @param string $question
     * @param array  $choices
     * @param array  $solution
     *
     * @return ChoiceQuestion
     */
    private function getQuestion($question, $choices, $solution)
    {
        $question = new ChoiceQuestion(
            $question,
            $choices,
            implode(", ", array_keys($solution))
        );

        $question->setMultiselect(true);

        return $question;
    }
}
