<?php
/**
 * This file is part of Zepgram\CodeMaker\Generator for Caudalie
 *
 * @package    Zepgram\CodeMaker\Generator
 * @file       ClassGenerator.php
 * @date       02 09 2019 11:31
 * @author     bcalef <benjamin.calef@caudalie.com>
 * @copyright  2019 Caudalie Copyright (c) (https://caudalie.com)
 * @license    proprietary
 */

namespace Zepgram\CodeMaker\Generator;

use Zepgram\CodeMaker\Format;

class ClassGenerator
{
    /**
     * @var string|null
     */
    private $className;

    /**
     * @var string
     */
    private $baseNamespace;

    /**
     * ClassGenerator constructor.
     *
     * @param string $className
     * @param string $baseNamespace
     */
    public function __construct(string $className, string $baseNamespace)
    {
        $this->className     = $this->formatClassName($className);
        $this->baseNamespace = $baseNamespace;
    }

    /**
     * @param $className
     *
     * @return string
     */
    private function formatClassName($className)
    {
        $className = explode('/', $className);
        $subDirectories = [];
        foreach ($className as $string) {
            $subDirectories[] = ucwords($string);
        }

        return implode('/', $subDirectories);
    }

    /**
     * @return string|null
     */
    public function setNamespaceForType()
    {
        $namespaces = null;
        if (strpos($this->className, '/') !== false) {
            $namespace = explode('/', $this->className);
            array_pop($namespace);
            foreach ($namespace as $item) {
                $namespaces.= "\\$item";
            }
        }

        return $namespaces;
    }

    /**
     * @return mixed
     */
    public function getClassName()
    {
        $namespace = explode('/', $this->className);

        return array_pop($namespace);
    }

    /**
     * @return string
     */
    public function getClassNamespace()
    {
        return $this->baseNamespace . $this->setNamespaceForType();
    }

    /**
     * @return string
     */
    public function getPathForNamespace()
    {
        $beforeClassName = explode('\\', $this->baseNamespace);
        unset($beforeClassName[0], $beforeClassName[1]);

        return str_replace('\\', '/', implode('\\', $beforeClassName));
    }

    /**
     * @param $routerName
     *
     * @return string
     */
    public function getControllerRouteId($routerName)
    {
        $router_base = explode('\\', $this->baseNamespace)[1];

        return Format::asSnakeCase($router_base.'_'.$routerName);
    }

    /**
     * @param $routerName
     *
     * @return string
     */
    public function getControllerRoute($routerName)
    {
        $string = str_replace('.php', '', $this->getClassFile());
        $controllerPath = explode('/', $string);
        unset($controllerPath[0]);
        $route = implode('/', $controllerPath);

        return $this->getControllerRouteId($routerName).'_'.Format::asSnakeCase($route);
    }

    /**
     * @return string
     */
    public function getClassFile()
    {
        return $this->getPathForNamespace() . DIRECTORY_SEPARATOR . $this->className . '.php';
    }
}