<?= "<?xml version=\"1.0\"?>\n" ?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:module:Magento_Cron:etc/crontab.xsd">
    <group id="<?= $cron_group ?>">
        <job name="<?= $use_snake_case_cron ?>" instance="<?= $use_cron ?>" method="execute">
            <schedule><?= $schedule ?></schedule>
        </job>
    </group>
</config>
