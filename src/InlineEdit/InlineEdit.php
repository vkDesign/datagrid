<?php

/**
 * @copyright   Copyright (c) 2015 ublaboo <ublaboo@paveljanda.com>
 * @author      Pavel Janda <me@paveljanda.com>
 * @package     Ublaboo
 */

namespace Ublaboo\DataGrid\InlineEdit;

use Nette;
use Nette\Application\UI\Form;
use Ublaboo\DataGrid\DataGrid;
use Nette\Utils\Html;
use Ublaboo\DataGrid\Traits;

/**
 * @method onSubmit($id, Nette\Utils\ArrayHash $values)
 * @method onSubmit(Nette\Utils\ArrayHash $values)
 * @method onControlAdd(Nette\Forms\Container $container)
 * @method onSetDefaults(Nette\Forms\Container $container, $item)
 */
class InlineEdit extends Nette\Object
{

	use Traits\ButtonIconTrait;

	/**
	 * @var callable[]
	 */
	public $onSubmit;

	/**
	 * @var callable[]
	 */
	public $onControlAdd;

	/**
	 * @var callable[]
	 */
	public $onSetDefaults;

	/**
	 * @var callable[]
	 */
	public $onCustomRedraw;

	/**
	 * @var mixed
	 */
	protected $item_id;

	/**
	 * @var string
	 */
	protected $title = 'edit';

	/**
	 * @var string
	 */
	protected $class = 'btn btn-xs btn-default ajax';

	/**
	 * @var string
	 */
	protected $icon = 'pencil';

	/**
	 * @var string
	 */
	protected $text = '';

	/**
	 * @var DataGrid
	 */
	protected $grid;

	/**
	 * @var string|NULL
	 */
	protected $primary_where_column;

	/**
	 * Inline adding - render on the top or in the bottom?
	 * @var bool
	 */
	protected $position_top = FALSE;


	/**
	 * @param DataGrid $grid
	 * @param string|NULL   $primary_where_column
	 */
	public function __construct(DataGrid $grid, $primary_where_column = NULL)
	{
		$this->grid = $grid;
		$this->primary_where_column = $primary_where_column;
	}


	/**
	 * @param mixed $id
	 */
	public function setItemId($id)
	{
		$this->item_id = $id;
	}


	/**
	 * @return mixed
	 */
	public function getItemId()
	{
		return $this->item_id;
	}


	/**
	 * @return string
	 */
	public function getPrimaryWhereColumn()
	{
		return $this->primary_where_column;
	}


	/**
	 * Render row item detail button
	 * @param  Row $row
	 * @return Html
	 */
	public function renderButton($row)
	{
		$a = Html::el('a')
			->href($this->grid->link('inlineEdit!', ['id' => $row->getId()]));

		$this->tryAddIcon($a, $this->getIcon(), $this->getText());

		$a->add($this->text);

		if ($this->title) { $a->title($this->title); }
		if ($this->class) { $a->class[] = $this->class; }

		$a->class[] = 'datagrid-inline-edit-trigger';

		return $a;
	}


	/**
	 * Render row item detail button
	 * @return Html
	 */
	public function renderButtonAdd()
	{
		$a = Html::el('a')->data('datagrid-toggle-inline-add', TRUE);

		$this->tryAddIcon($a, $this->getIcon(), $this->getText());

		$a->add($this->text);

		if ($this->title) { $a->title($this->title); }
		if ($this->class) { $a->class($this->class); }

		return $a;
	}


	/**
	 * Set attribute title
	 * @param string $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;

		return $this;
	}


	/**
	 * Get attribute title
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}


	/**
	 * Set attribute class
	 * @param string $class
	 */
	public function setClass($class)
	{
		$this->class = $class;

		return $this;
	}


	/**
	 * Get attribute class
	 * @return string
	 */
	public function getClass()
	{
		return $this->class;
	}


	/**
	 * Set icon
	 * @param string $icon
	 */
	public function setIcon($icon)
	{
		$this->icon = $icon;

		return $this;
	}


	/**
	 * Get icon
	 * @return string
	 */
	public function getIcon()
	{
		return $this->icon;
	}


	/**
	 * Set text
	 * @param string $text
	 */
	public function setText($text)
	{
		$this->text = $text;

		return $this;
	}


	/**
	 * Get text
	 * @return string
	 */
	public function getText()
	{
		return $this->text;
	}


	/**
	 * Setter for inline adding position
	 * @param bool $position_top
	 * @return static
	 */
	public function setPositionTop($position_top = TRUE)
	{
		$this->position_top = (bool) $position_top;

		return $this;
	}


	/**
	 * Getter for inline adding
	 * @return bool
	 */
	public function isPositionTop()
	{
		return $this->position_top;
	}


	/**
	 * @return bool
	 */
	public function isPositionBottom()
	{
		return !$this->position_top;
	}

}
