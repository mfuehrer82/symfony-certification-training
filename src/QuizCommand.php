<?php

namespace Workout;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Yaml\Yaml;

/**
 * @package Workout
 */
class QuizCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('train')
            ->setDescription('Symfony Certification Training')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Welcome to the Symfony Certification Training');
        $helper = $this->getHelper('question');
        $categories = Yaml::parse(file_get_contents('questions.yml'));

        $question = new ChoiceQuestion(
            "Which category would you like to train?",
            array_keys($categories)
        );

        $category = $helper->ask($input, $output, $question);

        $questions = $categories[$category];

        foreach ($questions as $line) {
            $question = $line['question'];
            $choices = $line['choices'];
            $solution = $line['solution'];

            $multiSelectQuestionHelper = new MultiSelectQuestionHelper($input, $output, $helper);
            $multiSelectQuestionHelper->ask($question, $choices, $solution);
            $multiSelectQuestionHelper->handleAnswer($solution);
        }
    }
}
