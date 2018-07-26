<?php

namespace App\Presenters;

use Nette;
use Ublaboo\DataGrid\DataGrid;

class HomepagePresenter extends BasePresenter
{
	public function renderDefault()
	{
		$this->template->anyVariable = 'any value';
	}
        
        public function createComponentExamplesGrid($name)
    {
	/**
	 * @var Ublaboo\DataGrid\DataGrid
	 */
	$grid = new DataGrid($this, $name);

        $grid->setDataSource([['id' => "1", 'name' => 'John'], ['id' => "2", 'name' => 'Joe']]);
        
        $grid->addColumnText('id', 'ID');
        $grid->addColumnText('name', 'Name*')
		->setSortable();
        
        $grid->addInlineAdd()
	->onControlAdd[] = function($container) {
		$container->addText('id', '')->setAttribute('readonly');;
		$container->addText('name', '');
	};
        
        $grid->addInlineEdit()
	->onControlAdd[] = function($container) {
            $container->addText('id', '')->setAttribute('readonly');;
            $container->addText('name', '');
	};
        
        $grid->getInlineEdit()->onSetDefaults[] = function($container, $item) {
	$container->setDefaults([

            ]);
        };

        $p = $this;

        $grid->getInlineAdd()->onSubmit[] = function($values) use ($p) {
                /**
                 * Save new values
                 */
                $v='';foreach($values as $key=>$value){$v.="$key: $value, ";}$v=trim($v,', ');

                $p->flashMessage("Record with values [$v] was added! (not really)", 'success');

                $p->redrawControl('flashes');
        };
        
    }
}
