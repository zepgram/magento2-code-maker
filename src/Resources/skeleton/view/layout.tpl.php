<?= "<?xml version=\"1.0\"?>\n" ?>
<page xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" layout="1column" xsi:noNamespaceSchemaLocation="urn:magento:framework:View/Layout/etc/page_configuration.xsd">
    <body>
        <referenceContainer name="content">
            <block name="<?= $lower_namespace ?>.<?= $lower_module ?>.<?= $template ?>" template="<?= $module_namespace ?>_<?= $module_name ?>::<?= $template ?>.phtml">
                <arguments>
                    <argument name="view_model" xsi:type="object"><?= $view_model_class ?></argument>
                </arguments>
            </block>
        </referenceContainer>
    </body>
</page>