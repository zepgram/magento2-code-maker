<?php
/**
 * This file is part of Zepgram\CodeMaker\Command
 *
 * @package    Zepgram\CodeMaker\Command
 * @file       CreateView.php
 * @date       02 09 2019 14:59
 * @author     bcalef <zepgram@gmail.com>
 * @license    proprietary
 */

namespace Zepgram\CodeMaker\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zepgram\CodeMaker\BaseCommand;
use Zepgram\CodeMaker\FormatString;
use Zepgram\CodeMaker\FormatClass;

class GenerateControllerView extends BaseCommand
{
    protected static $defaultName = 'generate:controller-view';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(self::$defaultName)
            ->setDescription('Create basic view');
    }

    /**
     * {@inheritdoc}
     */
    protected function getParameters()
    {
        return [
            'area' => ['choice_question', ['frontend','adminhtml']],
            'router' => ['hello', 'asSnakeCase'],
            'controller' => ['Index', 'asSanitizeCamelCase'],
            'action' => ['Index', 'asSanitizeCamelCase']
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $viewModelClass = new FormatClass(
            $this->maker->getModuleNamespace(),
            'ViewModel/'.$this->parameters['action']
        );

        $area = $this->parameters['area'];
        $controller = $this->parameters['controller'];
        $controllerClass = new FormatClass(
            $this->maker->getModuleNamespace(),
            "Controller/$controller/" . $this->parameters['action'],
            $area
        );

        // controller variables
        $this->parameters['controller'] = $controllerClass->getName();
        $this->parameters['name_space_controller'] = $controllerClass->getNamespace();
        $this->parameters['router_id'] = $controllerClass->isBackend() ? 'admin' : 'standard';
        $this->parameters['dependencies'] = $controllerClass->isBackend() ?
            ['Magento\Backend\App\Action', 'Magento\Backend\App\Action\Context'] :
            ['Magento\Framework\App\Action\Action', 'Magento\Framework\App\Action\Context'];
        $this->parameters['route_id'] = $controllerClass->getRouteId($this->parameters['router']);

        // view model variables
        $this->parameters['class_view_model'] = $viewModelClass->getName();
        $this->parameters['name_space_view_model'] = $viewModelClass->getNamespace();
        $this->parameters['use_view_model'] = $viewModelClass->getUse();
        $this->parameters['template'] = FormatString::asSnakeCase($this->parameters['action']);
        $route_action = $controllerClass->getLayoutRoute($this->parameters['router']);
        $template = $this->parameters['template'];

        $filePath = [
            'routes.tpl.php' => "etc/$area/routes.xml",
            'controller.tpl.php' => $controllerClass->getFileName(),
            'view-model.tpl.php' => $viewModelClass->getFileName(),
            'layout.tpl.php' => "view/$area/layout/$route_action.xml",
            'template.tpl.php' => "view/$area/templates/$template.phtml"
        ];

        $this->maker->setTemplateParameters($this->parameters)
            ->setTemplateSkeleton(['controller','view'])
            ->setFilesPath($filePath);

        parent::execute($input, $output);
    }
}
