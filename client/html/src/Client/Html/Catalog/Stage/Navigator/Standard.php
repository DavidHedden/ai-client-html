<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2014
 * @copyright Aimeos (aimeos.org), 2015-2018
 * @package Client
 * @subpackage Html
 */


namespace Aimeos\Client\Html\Catalog\Stage\Navigator;


/**
 * Default implementation of catalog stage navigator section for HTML clients.
 *
 * @package Client
 * @subpackage Html
 */
class Standard
	extends \Aimeos\Client\Html\Catalog\Base
	implements \Aimeos\Client\Html\Common\Client\Factory\Iface
{
	/** client/html/catalog/stage/navigator/standard/subparts
	 * List of HTML sub-clients rendered within the catalog stage navigator section
	 *
	 * The output of the frontend is composed of the code generated by the HTML
	 * clients. Each HTML client can consist of serveral (or none) sub-clients
	 * that are responsible for rendering certain sub-parts of the output. The
	 * sub-clients can contain HTML clients themselves and therefore a
	 * hierarchical tree of HTML clients is composed. Each HTML client creates
	 * the output that is placed inside the container of its parent.
	 *
	 * At first, always the HTML code generated by the parent is printed, then
	 * the HTML code of its sub-clients. The order of the HTML sub-clients
	 * determines the order of the output of these sub-clients inside the parent
	 * container. If the configured list of clients is
	 *
	 *  array( "subclient1", "subclient2" )
	 *
	 * you can easily change the order of the output by reordering the subparts:
	 *
	 *  client/html/<clients>/subparts = array( "subclient1", "subclient2" )
	 *
	 * You can also remove one or more parts if they shouldn't be rendered:
	 *
	 *  client/html/<clients>/subparts = array( "subclient1" )
	 *
	 * As the clients only generates structural HTML, the layout defined via CSS
	 * should support adding, removing or reordering content by a fluid like
	 * design.
	 *
	 * @param array List of sub-client names
	 * @since 2014.03
	 * @category Developer
	 */
	private $subPartPath = 'client/html/catalog/stage/navigator/standard/subparts';
	private $subPartNames = [];


	/**
	 * Returns the HTML code for insertion into the body.
	 *
	 * @param string $uid Unique identifier for the output if the content is placed more than once on the same page
	 * @return string HTML code
	 */
	public function getBody( $uid = '' )
	{
		$view = $this->getView();

		$html = '';
		foreach( $this->getSubClients() as $subclient ) {
			$html .= $subclient->setView( $view )->getBody( $uid );
		}
		$view->navigatorBody = $html;

		/** client/html/catalog/stage/navigator/standard/template-body
		 * Relative path to the HTML body template of the catalog stage navigator client.
		 *
		 * The template file contains the HTML code and processing instructions
		 * to generate the result shown in the body of the frontend. The
		 * configuration string is the path to the template file relative
		 * to the templates directory (usually in client/html/templates).
		 *
		 * You can overwrite the template file configuration in extensions and
		 * provide alternative templates. These alternative templates should be
		 * named like the default one but with the string "standard" replaced by
		 * an unique name. You may use the name of your project for this. If
		 * you've implemented an alternative client class as well, "standard"
		 * should be replaced by the name of the new class.
		 *
		 * @param string Relative path to the template creating code for the HTML page body
		 * @since 2014.03
		 * @category Developer
		 * @see client/html/catalog/stage/navigator/standard/template-header
		 */
		$tplconf = 'client/html/catalog/stage/navigator/standard/template-body';
		$default = 'catalog/stage/navigator-body-standard';

		return $view->render( $view->config( $tplconf, $default ) );
	}


	/**
	 * Returns the sub-client given by its name.
	 *
	 * @param string $type Name of the client type
	 * @param string|null $name Name of the sub-client (Default if null)
	 * @return \Aimeos\Client\Html\Iface Sub-client object
	 */
	public function getSubClient( $type, $name = null )
	{
		/** client/html/catalog/stage/navigator/decorators/excludes
		 * Excludes decorators added by the "common" option from the catalog stage navigator html client
		 *
		 * Decorators extend the functionality of a class by adding new aspects
		 * (e.g. log what is currently done), executing the methods of the underlying
		 * class only in certain conditions (e.g. only for logged in users) or
		 * modify what is returned to the caller.
		 *
		 * This option allows you to remove a decorator added via
		 * "client/html/common/decorators/default" before they are wrapped
		 * around the html client.
		 *
		 *  client/html/catalog/stage/navigator/decorators/excludes = array( 'decorator1' )
		 *
		 * This would remove the decorator named "decorator1" from the list of
		 * common decorators ("\Aimeos\Client\Html\Common\Decorator\*") added via
		 * "client/html/common/decorators/default" to the html client.
		 *
		 * @param array List of decorator names
		 * @since 2014.05
		 * @category Developer
		 * @see client/html/common/decorators/default
		 * @see client/html/catalog/stage/navigator/decorators/global
		 * @see client/html/catalog/stage/navigator/decorators/local
		 */

		/** client/html/catalog/stage/navigator/decorators/global
		 * Adds a list of globally available decorators only to the catalog stage navigator html client
		 *
		 * Decorators extend the functionality of a class by adding new aspects
		 * (e.g. log what is currently done), executing the methods of the underlying
		 * class only in certain conditions (e.g. only for logged in users) or
		 * modify what is returned to the caller.
		 *
		 * This option allows you to wrap global decorators
		 * ("\Aimeos\Client\Html\Common\Decorator\*") around the html client.
		 *
		 *  client/html/catalog/stage/navigator/decorators/global = array( 'decorator1' )
		 *
		 * This would add the decorator named "decorator1" defined by
		 * "\Aimeos\Client\Html\Common\Decorator\Decorator1" only to the html client.
		 *
		 * @param array List of decorator names
		 * @since 2014.05
		 * @category Developer
		 * @see client/html/common/decorators/default
		 * @see client/html/catalog/stage/navigator/decorators/excludes
		 * @see client/html/catalog/stage/navigator/decorators/local
		 */

		/** client/html/catalog/stage/navigator/decorators/local
		 * Adds a list of local decorators only to the catalog stage navigator html client
		 *
		 * Decorators extend the functionality of a class by adding new aspects
		 * (e.g. log what is currently done), executing the methods of the underlying
		 * class only in certain conditions (e.g. only for logged in users) or
		 * modify what is returned to the caller.
		 *
		 * This option allows you to wrap local decorators
		 * ("\Aimeos\Client\Html\Catalog\Decorator\*") around the html client.
		 *
		 *  client/html/catalog/stage/navigator/decorators/local = array( 'decorator2' )
		 *
		 * This would add the decorator named "decorator2" defined by
		 * "\Aimeos\Client\Html\Catalog\Decorator\Decorator2" only to the html client.
		 *
		 * @param array List of decorator names
		 * @since 2014.05
		 * @category Developer
		 * @see client/html/common/decorators/default
		 * @see client/html/catalog/stage/navigator/decorators/excludes
		 * @see client/html/catalog/stage/navigator/decorators/global
		 */

		return $this->createSubClient( 'catalog/stage/navigator/' . $type, $name );
	}


	/**
	 * Modifies the cached body content to replace content based on sessions or cookies.
	 *
	 * @param string $content Cached content
	 * @param string $uid Unique identifier for the output if the content is placed more than once on the same page
	 * @return string Modified body content
	 */
	public function modifyBody( $content, $uid )
	{
		$this->setView( $this->addData( $this->getView() ) );

		return $this->replaceSection( $content, $this->getBody( $uid ), 'catalog.stage.navigator' );
	}


	/**
	 * Returns the list of sub-client names configured for the client.
	 *
	 * @return array List of HTML client names
	 */
	protected function getSubClientNames()
	{
		return $this->getContext()->getConfig()->get( $this->subPartPath, $this->subPartNames );
	}


	/**
	 * Sets the necessary parameter values in the view.
	 *
	 * @param \Aimeos\MW\View\Iface $view The view object which generates the HTML output
	 * @param array &$tags Result array for the list of tags that are associated to the output
	 * @param string|null &$expire Result variable for the expiration date of the output (null for no expiry)
	 * @return \Aimeos\MW\View\Iface Modified view object
	 */
	public function addData( \Aimeos\MW\View\Iface $view, array &$tags = [], &$expire = null )
	{
		$pos = $view->param( 'd_pos' );

		if( is_numeric( $pos ) && ( $pid = $view->param( 'd_prodid' ) ) !== null )
		{

			if( $pos < 1 ) {
				$start = 0; $size = 2;
			} else {
				$start = $pos - 1; $size = 3;
			}

			$context = $this->getContext();
			$site = $context->getLocale()->getSite()->getCode();
			$params = $context->getSession()->get( 'aimeos/catalog/lists/params/last/' . $site, [] );

			$filter = $this->getProductListFilterByParam( $params );
			$filter->setSlice( $start, $size );
			$total = null;

			$controller = \Aimeos\Controller\Frontend\Factory::createController( $context, 'product' );
			$products = $controller->searchItems( $filter, array( 'text' ), $total );

			if( ( $count = count( $products ) ) > 1 )
			{
				$enc = $view->encoder();
				$listPos = array_search( $pid, array_keys( $products ) );

				$target = $view->config( 'client/html/catalog/detail/url/target' );
				$controller = $view->config( 'client/html/catalog/detail/url/controller', 'catalog' );
				$action = $view->config( 'client/html/catalog/detail/url/action', 'detail' );
				$config = $view->config( 'client/html/catalog/detail/url/config', [] );

				if( $listPos > 0 && ( $product = reset( $products ) ) !== false )
				{
					$param = array(
						'd_prodid' => $product->getId(),
						'd_name' => $enc->url( $product->getName( 'url ' ) ),
						'd_pos' => $pos - 1
					);
					$view->navigationPrev = $view->url( $target, $controller, $action, $param, [], $config );
				}

				if( $listPos < $count - 1 && ( $product = end( $products ) ) !== false )
				{
					$param = array(
						'd_prodid' => $product->getId(),
						'd_name' => $enc->url( $product->getName( 'url' ) ),
						'd_pos' => $pos + 1
					);
					$view->navigationNext = $view->url( $target, $controller, $action, $param, [], $config );
				}
			}
		}

		return parent::addData( $view, $tags, $expire );
	}
}