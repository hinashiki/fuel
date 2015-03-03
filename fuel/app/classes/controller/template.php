<?php
/**
 * controller_template wrapper
 *
 */
class Controller_Template extends \Fuel\Core\Controller_Template {

	protected $_css = array();
	protected $_js = array();
	protected $_title = null;
	protected $_crumbs = array();

	/**
	 * @overwrap
	 */
	public function after($response)
	{
		$this->template->title = $this->_title;
		$this->template->css = $this->_css;
		$this->template->js = $this->_js;
		$this->template->bread_crumb = \View::forge('elements/bread_crumb');
		$this->template->bread_crumb->crumbs = $this->_crumbs;
		return parent::after($response);
	}
}
