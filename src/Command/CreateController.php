<?php
/**
 * This file is part of Zepgram\CodeMaker\Command for Caudalie
 *
 * @package    Zepgram\CodeMaker\Command
 * @file       CreateController.php
 * @date       01 09 2019 00:02
 * @author     bcalef <benjamin.calef@caudalie.com>
 * @copyright  2019 Caudalie Copyright (c) (https://caudalie.com)
 * @license    proprietary
 */

namespace Zepgram\CodeMaker\Command;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zepgram\CodeMaker\BaseCommand;
use Zepgram\CodeMaker\Generator\ClassGenerator;

class CreateController extends BaseCommand
{
    protected static $defaultName = 'create:controller';

    protected function configure()
    {
        $this->setName(self::$defaultName)
            ->setDescription('Creates controller');
    }

    protected function getParameters()
    {
        return [
            'scope' => ['choice_question', ['frontend','adminhtml']],
            'class_name' => ['Subscribe', 'ucfirst'],
            'router' => ['subscribe', 'strtolower']
        ];
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $scope = $this->parameters['scope'];
        $isBackend = $scope === 'adminhtml';
        $this->parameters['before_backend'] = $isBackend ? ' before="Magento_Backend"' : '';
        $this->parameters['router_id'] = $isBackend ? 'admin' : 'standard';
        $this->parameters['dependencies'] = [
            'Magento\Framework\App\Action\Action',
            'Magento\Framework\App\Action\Context'
        ];
        $this->parameters['admin_html_namespace'] = '';
        if ($isBackend) {
            $this->parameters['dependencies'] = [
                'Magento\Backend\App\Action',
                'Magento\Backend\App\Action\Context'
            ];
            $this->parameters['admin_html_namespace'] = 'Adminhtml\\';
        }

        $classGenerator = new ClassGenerator(
            $isBackend ? 'Controller/Adminhtml' : 'Controller',
            $this->parameters['class_name'],
            $this->maker->getModuleFullNamespace()
        );

        $this->parameters['class_name'] = $classGenerator->getClassName();
        $this->parameters['name_space'] = $classGenerator->getClassNamespace();
        $filePath = [
            'controller.tpl.php' => $classGenerator->getClassPath(),
            'routes.tpl.php'     => "etc/$scope/routes.xml"
        ];

        $this->maker->setTemplateParameters($this->parameters)
            ->setFilesPath($filePath);

        parent::execute($input, $output);
    }
}