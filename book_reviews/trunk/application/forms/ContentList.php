<?php

class Application_Form_ContentList extends Zend_Form
{
    public function init()
    {
        $options = array(
                        '0'           => '-',
                        'pageTitle'  => 'Titolo pagina',
        				'createdOn'  => 'Data'
                   );

        $sort = $this->createElement('select', 'sort');
        $sort->setLabel('Order by:');
        $sort->addMultiOptions($options);
        $this->addElement($sort);

        $filterField = $this->createElement('select', 'filter_field');
        $filterField->setLabel('Filter by:');
        $filterField->addMultiOptions($options);
        $this->addElement($filterField);

        $filter = $this->createElement('text', 'filter');
        $filter->setLabel('Value:');
        $filter->setAttrib('size',40);
        $filter->addValidator(new Zend_Validate_Alnum(array('allowWhiteSpace' => true)));
        $this->addElement($filter);

        $this->addElement('submit', 'submit', array('label' => 'Filter list'));
    }
}

?>