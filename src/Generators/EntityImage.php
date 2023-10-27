<?php

namespace App\Generators;

use Cycle\Database\TableInterface;
use Spiral\Reactor\ClassDeclaration;
use Spiral\Reactor\FileDeclaration;
use Spiral\Reactor\Partial\PhpNamespace;
use TeamTimer\Pakk\Base\Entity;

class EntityImage
{
    protected ClassDeclaration $class;
    protected FileDeclaration $file;

    public function __construct(
        string $namespace,
        string $entityName,
        TableInterface $table
    ) {
        $namespace = new PhpNamespace($namespace);
        $namespace->addUse(Entity::class);

        $fieldConfig = $this->getFieldConfig($table);

        // todo: this is ugly, refactor
        $fieldsMethodBody = "return [".PHP_EOL;
        foreach($fieldConfig as $fieldName => $fieldType){
            $fieldsMethodBody .= "\t";
            $fieldsMethodBody .= "'{$fieldName}' => '{$fieldType}',".PHP_EOL;
        }
        $fieldsMethodBody .= "];";

        $this->class = $namespace->addClass(ucfirst($entityName));
        $this->class->setExtends(Entity::class);

        foreach ($fieldConfig as $fieldName => $fieldType) {
            $this->class->addProperty($fieldName)->setPublic();
        }

        $this->class->addMethod('tableName')->setPublic()->setStatic()->setReturnType('string')->setBody("return '{$entityName}';");
        $this->class->addMethod('fields')->setPublic()->setStatic()->setReturnType('array')->setBody($fieldsMethodBody);

        $this->file = new FileDeclaration();
        $this->file->addNamespace($namespace);
    }

    public function getClass(): ClassDeclaration
    {
        return $this->class;
    }

    public function getFile(): FileDeclaration
    {
        return $this->file;
    }

    protected function getFieldConfig($table){
        $fields = [];
        foreach($table->getColumns() as $column){
            $fields[$column->getName()] = $this->getFieldType($column);
        }
        return $fields;
    }

    protected function getFieldType($column){
        $abstractType = $column->getAbstractType();
        $type = $column->getType();

        if($abstractType === 'primary'){
            return 'primary';
        }

        $size = $column->getSize();

        if ($size === 0){
            switch ($abstractType) {
                case 'string':
                    $size = 255;
                    break;
                case 'integer':
                    $size = 11;
                    break;
                case 'decimal':
                    $size = 10;
                    break;
                case 'boolean':
                    $size = 1;
                    break;
                case 'text':
                    $size = 32768;
                    break;
                case 'datetime':
                    $size = 255;
                    break;
                default:
                    $size = 255;
                    break;
            }
        }
        return $type . '(' . $size . ')';
    }
}