<?php

/*
 * This file is part of Zepgram Code Maker.
 * (c) Benjamin Calef <bcalef.pro@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Zepgram\CodeMaker\Console;

use Symfony\Component\Console\Application;
use Zepgram\CodeMaker\Command\BaseCommand;
use Zepgram\CodeMaker\FileManager;

class Cli extends Application
{
    /** @var string */
    const APPLICATION_NAME = 'Code Maker Magento2';

    /** @var string */
    const APPLICATION_VERSION = '0.0.1';

    /** @var string */
    const COMMAND_NAME_SPACE = 'Zepgram\CodeMaker\Command';

    /** @var string  */
    const CONFIG_FILE = 'app/etc/config.php';

    /** @var string */
    const MODULE_ARRAY_KEY = 'modules';

    /** @var string */
    const MAGENTO_VERSION = '2.3.0';

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct(self::APPLICATION_NAME, self::APPLICATION_VERSION);
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultCommands()
    {
        $this->validateMagentoPath();
        $this->validateMagentoVersion();

        return array_merge(parent::getDefaultCommands(), $this->getApplicationCommands());
    }

    /**
     * @throws \RuntimeException
     */
    private function validateMagentoPath()
    {
        if (!file_exists(self::CONFIG_FILE)) {
            throw new \RuntimeException('You must run this command in magento root directory.');
        }
        if (strpos(file_get_contents(self::CONFIG_FILE), self::MODULE_ARRAY_KEY) === false) {
            throw new \RuntimeException('You are not in magento2 application.');
        }
    }

    /**
     * @throws \RuntimeException
     */
    private function validateMagentoVersion()
    {
        $magentoComposerJson = json_decode(file_get_contents('vendor/magento/magento2-base/composer.json'));
        if (version_compare($magentoComposerJson->version, self::MAGENTO_VERSION, '<')) {
            throw new \RuntimeException(
                'Zepgram code maker is only compatible with magento version >= '. self::MAGENTO_VERSION
            );
        }
    }

    /**
     * @return array
     */
    private function getApplicationCommands()
    {
        $instanceCommand = [];
        $commandDirectory = dirname(__DIR__) . '/' . explode('\\', self::COMMAND_NAME_SPACE)[2];
        $scanDir = array_diff(FileManager::scanDir($commandDirectory), ['BaseCommand.php']);

        foreach ($scanDir as $commandFile) {
            $command = self::COMMAND_NAME_SPACE . '\\' . str_replace('.php', '', $commandFile);
            if (class_exists($command)) {
                $command = new $command;
                if (is_subclass_of($command, BaseCommand::class)) {
                    $instanceCommand[] = $command;
                }
            }
        }

        return $instanceCommand;
    }
}
