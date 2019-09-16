<?= "<?php\n" ?>

namespace <?= $name_space_command ?>;

use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class <?= $class_command ?>.
 */
class <?= $class_command ?> extends Command
{
    /**
     * Initialization of the command.
     */
    public function configure()
    {
        $this->setName('<?= $command ?>')
            ->setDescription('My description');
        parent::configure();
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Command Line Interface');
        return Cli::RETURN_SUCCESS;
    }
}