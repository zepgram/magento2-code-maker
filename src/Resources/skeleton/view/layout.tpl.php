<?= "<?xml version=\"1.0\"?>\n" ?>
<page xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:View/Layout/etc/page_configuration.xsd">
    <body>
    <referenceContainer name="content">
        <block name="<?= $lower_namespace ?>.<?= $lower_module ?>.<?= $name_snake_case_view_model ?>"
               template="<?= $module_namespace ?>_<?= $module_name ?>::<?= $name_snake_case_view_model ?>.phtml">
            <arguments>
                <argument name="view_model" xsi:type="object"><?= $use_view_model ?></argument>
            </arguments>
        </block>
    </referenceContainer>
    </body>
</page>
