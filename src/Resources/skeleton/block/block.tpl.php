<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace_block ?>;

<?php foreach ($dependencies as $dependency): ?>
use <?= "$dependency;\r\n" ?>
<?php endforeach; ?>

class <?= $name_block ?> extends Template
{
    public function __construct(Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }
}
