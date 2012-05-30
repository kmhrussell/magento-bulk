<?php
require_once 'init.php';

$args = getopt('u', array());

echo "List all product attributes\n";
$attrs = Mage::getResourceModel('catalog/product_attribute_collection');
Mage::log('attr-list: '. count($attrs) . ' attributes total');
$attrs_data = $attrs->load();
echo "G=global C=configurable V=visible U=user-defined\n";
foreach ($attrs_data as $attr) {
	if (isset($args['u']) && $attr->getIsUserDefined() == false)
		continue;
// 	$attr->load();
// 	var_dump($attr->getData());
	printf("%3d %-30s %-25s %-10s %-11s %1s%1s%1s%1s %-30s\n", $attr->getId(),
		$attr->getAttributeCode(),
		$attr->getFrontendLabel(),
		$attr->getBackendType(),
		$attr->getFrontendInput(),
		$attr->getIsGlobal() ? 'G' : '-',
		$attr->getIsConfigurable() ? 'C' : '-',
		$attr->getIsVisible() ? 'V' : '-',
		$attr->getIsUserDefined() ? 'U' : '-',
		join(',', $attr->getApplyTo()));
	//var_dump($attr);
	var_dump($attr->getData());
	if ($attr->usesSource()) {
		$source = $attr->getSource();
		$optStrArr = array();
		foreach ($source->getAllOptions() as $optionOrder => $optionValue) {
			if (empty($optionOrder) || empty($optionValue))
				continue;
			$optStrArr[] = $optionValue['value'] . '='. $optionValue['label'];
		}
		echo "    " . join(' ', $optStrArr) ."\n";		
	}
	
}