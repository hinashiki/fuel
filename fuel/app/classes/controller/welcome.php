<?php
/**
 * The Welcome Controller.
 *
 * A basic controller example.  Has examples of how to set the
 * response body and status.
 *
 * @package  app
 * @extends  Controller
 */
class Controller_Welcome extends \Controller_Template
{

	private $__404 = false;

	/**
	 * @overwrap
	 */
	public function after($response){
		$response = parent::after($response);
		if($this->__404 === true)
		{
			$response->set_status(404);
		}
		return $response;
	}

	/**
	 * The basic welcome message
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_index()
	{
		$this->template->content = \View::forge('welcome/index');
	}

	/**
	 * A typical "Hello, Bob!" type example.  This uses a Presenter to
	 * show how to use them.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_hello()
	{
		$this->_title = 'Hello, ' .$this->request->route->named_params['name'];
		$this->_crumbs = array(
			array(
				'url' => 'hello/' . $this->request->route->named_params['name'],
				'label' => $this->request->route->named_params['name']
			)
		);
		$this->template->content = \Presenter::forge('welcome/hello');
	}

	/**
	 * The 404 action for the application.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_404()
	{
		$this->__404 = true;
		$this->template->content = \Presenter::forge('welcome/404');
	}
}
