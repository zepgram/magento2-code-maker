<?php
use Zepgram\CodeMaker\Str;

?>
<?= "<?php\n" ?>

namespace <?= $namespace_entity ?>;

<?php if (isset($name_resource)): ?>
use Magento\Framework\Model\AbstractModel;
use <?= $use_resource ?> as <?= $name_entity ?>Resource;
<?php else: ?>
use Magento\Framework\DataObject;
<?php endif; ?>
use <?= $use_entity_interface ?>;

/**
 * Class <?= $name_entity ?>.
 */
class <?= $name_entity ?> extends <?= isset($name_resource) ? 'AbstractModel' : 'DataObject' ?> implements <?= "$name_entity_interface\r\n" ?>
{
<?php if (isset($name_resource)): ?>
    /**
     * {@inheritdoc}
     */
    protected $_eventPrefix = '<?= $name_snake_case_entity ?>';

    /**
     * {@inheritdoc}
     */
    protected $_eventObject = '<?= $name_snake_case_entity ?>';

    /**
     * {@inheritdoc}
     */
    protected $_idFieldName = '<?= $primary_key ?>';

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(<?= $name_entity ?>Resource::class);
    }

<?php endif; ?>
<?php foreach ($option_fields as $field => $option): ?>
<?php $fieldName = Str::asPascaleCase($field); ?>
<?php $fieldConst = Str::asUpperSnakeCase($field); ?>
<?php $fieldParameter = Str::asCamelCase($field); ?>
    /**
     * {@inheritdoc}
     */
    public function get<?= $fieldName ?>()
    {
        return $this->getData(self::<?= $fieldConst ?>);
    }

    /**
     * {@inheritdoc}
     */
    public function set<?= $fieldName ?>(<?= $option['type'] ?> $<?= $fieldParameter ?>)
    {
        $this->setData(self::<?= $fieldConst ?>, $<?= $fieldParameter ?>);

        return $this;
    }
<?php if ($field !== array_key_last($option_fields)):
echo "\n";
endif; ?>
<?php endforeach; ?>
}
