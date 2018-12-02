<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2012
 * @copyright Aimeos (aimeos.org), 2015-2018
 * @package Client
 * @subpackage Html
 */


namespace Aimeos\Client\Html\Catalog\Detail;


/**
 * Default implementation of catalog detail section HTML clients.
 *
 * @package Client
 * @subpackage Html
 */
class Standard
	extends \Aimeos\Client\Html\Catalog\Base
	implements \Aimeos\Client\Html\Common\Client\Factory\Iface
{
	/** client/html/catalog/detail/standard/subparts
	 * List of HTML sub-clients rendered within the catalog detail section
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
	private $subPartPath = 'client/html/catalog/detail/standard/subparts';

	/** client/html/catalog/detail/service/name
	 * Name of the shipping cost part used by the catalog detail client implementation
	 *
	 * Use "Myname" if your class is named "\Aimeos\Client\Html\Catalog\Detail\Service\Myname".
	 * The name is case-sensitive and you should avoid camel case names like "MyName".
	 *
	 * @param string Last part of the client class name
	 * @since 2017.01
	 * @category Developer
	 */

	/** client/html/catalog/detail/seen/name
	 * Name of the seen part used by the catalog detail client implementation
	 *
	 * Use "Myname" if your class is named "\Aimeos\Client\Html\Catalog\Detail\Seen\Myname".
	 * The name is case-sensitive and you should avoid camel case names like "MyName".
	 *
	 * @param string Last part of the client class name
	 * @since 2014.03
	 * @category Developer
	 */
	private $subPartNames = array( 'service', 'seen' );

	private $tags = [];
	private $expire;
	private $view;


	/**
	 * Returns the HTML code for insertion into the body.
	 *
	 * @param string $uid Unique identifier for the output if the content is placed more than once on the same page
	 * @return string HTML code
	 */
	public function getBody( $uid = '' )
	{
		$prefixes = array( 'd' );
		$context = $this->getContext();

		/** client/html/catalog/detail/cache
		 * Enables or disables caching only for the catalog detail component
		 *
		 * Disable caching for components can be useful if you would have too much
		 * entries to cache or if the component contains non-cacheable parts that
		 * can't be replaced using the modifyBody() and modifyHeader() methods.
		 *
		 * @param boolean True to enable caching, false to disable
		 * @category Developer
		 * @category User
		 * @see client/html/catalog/filter/cache
		 * @see client/html/catalog/lists/cache
		 * @see client/html/catalog/stage/cache
		 */

		/** client/html/catalog/detail
		 * All parameters defined for the catalog detail component and its subparts
		 *
		 * This returns all settings related to the detail component.
		 * Please refer to the single settings for details.
		 *
		 * @param array Associative list of name/value settings
		 * @category Developer
		 * @see client/html/catalog#detail
		 */
		$confkey = 'client/html/catalog/detail';

		if( ( $html = $this->getCached( 'body', $uid, $prefixes, $confkey ) ) === null )
		{
			$view = $this->getView();

			/** client/html/catalog/detail/standard/template-body
			 * Relative path to the HTML body template of the catalog detail client.
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
			 * @see client/html/catalog/detail/standard/template-header
			 */
			$tplconf = 'client/html/catalog/detail/standard/template-body';
			$default = 'catalog/detail/body-standard';

			try
			{
				if( !isset( $this->view ) ) {
					$view = $this->view = $this->getObject()->addData( $view, $this->tags, $this->expire );
				}

				$output = '';
				foreach( $this->getSubClients() as $subclient ) {
					$output .= $subclient->setView( $view )->getBody( $uid );
				}
				$view->detailBody = $output;

				$html = $view->render( $view->config( $tplconf, $default ) );
				$this->setCached( 'body', $uid, $prefixes, $confkey, $html, $this->tags, $this->expire );

				return $html;
			}
			catch( \Aimeos\Client\Html\Exception $e )
			{
				$error = array( $context->getI18n()->dt( 'client', $e->getMessage() ) );
				$view->detailErrorList = $view->get( 'detailErrorList', [] ) + $error;
			}
			catch( \Aimeos\Controller\Frontend\Exception $e )
			{
				$error = array( $context->getI18n()->dt( 'controller/frontend', $e->getMessage() ) );
				$view->detailErrorList = $view->get( 'detailErrorList', [] ) + $error;
			}
			catch( \Aimeos\MShop\Exception $e )
			{
				$error = array( $context->getI18n()->dt( 'mshop', $e->getMessage() ) );
				$view->detailErrorList = $view->get( 'detailErrorList', [] ) + $error;
			}
			catch( \Exception $e )
			{
				$error = array( $context->getI18n()->dt( 'client', 'A non-recoverable error occured' ) );
				$view->detailErrorList = $view->get( 'detailErrorList', [] ) + $error;
				$this->logException( $e );
			}

			$html = $view->render( $view->config( $tplconf, $default ) );
		}
		else
		{
			$html = $this->modifyBody( $html, $uid );
		}

		return $html;
	}


	/**
	 * Returns the HTML string for insertion into the header.
	 *
	 * @param string $uid Unique identifier for the output if the content is placed more than once on the same page
	 * @return string|null String including HTML tags for the header on error
	 */
	public function getHeader( $uid = '' )
	{
		$prefixes = array( 'd' );
		$confkey = 'client/html/catalog/detail';


		if( ( $html = $this->getCached( 'header', $uid, $prefixes, $confkey ) ) === null )
		{
			$view = $this->getView();

			/** client/html/catalog/detail/standard/template-header
			 * Relative path to the HTML header template of the catalog detail client.
			 *
			 * The template file contains the HTML code and processing instructions
			 * to generate the HTML code that is inserted into the HTML page header
			 * of the rendered page in the frontend. The configuration string is the
			 * path to the template file relative to the templates directory (usually
			 * in client/html/templates).
			 *
			 * You can overwrite the template file configuration in extensions and
			 * provide alternative templates. These alternative templates should be
			 * named like the default one but with the string "standard" replaced by
			 * an unique name. You may use the name of your project for this. If
			 * you've implemented an alternative client class as well, "standard"
			 * should be replaced by the name of the new class.
			 *
			 * @param string Relative path to the template creating code for the HTML page head
			 * @since 2014.03
			 * @category Developer
			 * @see client/html/catalog/detail/standard/template-body
			 */
			$tplconf = 'client/html/catalog/detail/standard/template-header';
			$default = 'catalog/detail/header-standard';

			try
			{
				if( !isset( $this->view ) ) {
					$view = $this->view = $this->getObject()->addData( $view, $this->tags, $this->expire );
				}

				$output = '';
				foreach( $this->getSubClients() as $subclient ) {
					$output .= $subclient->setView( $view )->getHeader( $uid );
				}
				$view->detailHeader = $output;

				$html = $view->render( $view->config( $tplconf, $default ) );
				$this->setCached( 'header', $uid, $prefixes, $confkey, $html, $this->tags, $this->expire );

				return $html;
			}
			catch( \Exception $e )
			{
				$this->logException( $e );
			}
		}
		else
		{
			$html = $this->modifyHeader( $html, $uid );
		}

		return $html;
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
		/** client/html/catalog/detail/decorators/excludes
		 * Excludes decorators added by the "common" option from the catalog detail html client
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
		 *  client/html/catalog/detail/decorators/excludes = array( 'decorator1' )
		 *
		 * This would remove the decorator named "decorator1" from the list of
		 * common decorators ("\Aimeos\Client\Html\Common\Decorator\*") added via
		 * "client/html/common/decorators/default" to the html client.
		 *
		 * @param array List of decorator names
		 * @since 2014.05
		 * @category Developer
		 * @see client/html/common/decorators/default
		 * @see client/html/catalog/detail/decorators/global
		 * @see client/html/catalog/detail/decorators/local
		 */

		/** client/html/catalog/detail/decorators/global
		 * Adds a list of globally available decorators only to the catalog detail html client
		 *
		 * Decorators extend the functionality of a class by adding new aspects
		 * (e.g. log what is currently done), executing the methods of the underlying
		 * class only in certain conditions (e.g. only for logged in users) or
		 * modify what is returned to the caller.
		 *
		 * This option allows you to wrap global decorators
		 * ("\Aimeos\Client\Html\Common\Decorator\*") around the html client.
		 *
		 *  client/html/catalog/detail/decorators/global = array( 'decorator1' )
		 *
		 * This would add the decorator named "decorator1" defined by
		 * "\Aimeos\Client\Html\Common\Decorator\Decorator1" only to the html client.
		 *
		 * @param array List of decorator names
		 * @since 2014.05
		 * @category Developer
		 * @see client/html/common/decorators/default
		 * @see client/html/catalog/detail/decorators/excludes
		 * @see client/html/catalog/detail/decorators/local
		 */

		/** client/html/catalog/detail/decorators/local
		 * Adds a list of local decorators only to the catalog detail html client
		 *
		 * Decorators extend the functionality of a class by adding new aspects
		 * (e.g. log what is currently done), executing the methods of the underlying
		 * class only in certain conditions (e.g. only for logged in users) or
		 * modify what is returned to the caller.
		 *
		 * This option allows you to wrap local decorators
		 * ("\Aimeos\Client\Html\Catalog\Decorator\*") around the html client.
		 *
		 *  client/html/catalog/detail/decorators/local = array( 'decorator2' )
		 *
		 * This would add the decorator named "decorator2" defined by
		 * "\Aimeos\Client\Html\Catalog\Decorator\Decorator2" only to the html client.
		 *
		 * @param array List of decorator names
		 * @since 2014.05
		 * @category Developer
		 * @see client/html/common/decorators/default
		 * @see client/html/catalog/detail/decorators/excludes
		 * @see client/html/catalog/detail/decorators/global
		 */

		return $this->createSubClient( 'catalog/detail/' . $type, $name );
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
		$content = parent::modifyBody( $content, $uid );

		return $this->replaceSection( $content, $this->getView()->csrf()->formfield(), 'catalog.detail.csrf' );
	}


	/**
	 * Processes the input, e.g. store given values.
	 * A view must be available and this method doesn't generate any output
	 * besides setting view variables.
	 */
	public function process()
	{
		$context = $this->getContext();
		$view = $this->getView();

		try
		{
			$site = $context->getLocale()->getSite()->getCode();
			$params = $this->getClientParams( $view->param() );
			$context->getSession()->set( 'aimeos/catalog/detail/params/last/' . $site, $params );

			parent::process();
		}
		catch( \Aimeos\Client\Html\Exception $e )
		{
			$error = array( $context->getI18n()->dt( 'client', $e->getMessage() ) );
			$view->detailErrorList = $view->get( 'detailErrorList', [] ) + $error;
		}
		catch( \Aimeos\Controller\Frontend\Exception $e )
		{
			$error = array( $context->getI18n()->dt( 'controller/frontend', $e->getMessage() ) );
			$view->detailErrorList = $view->get( 'detailErrorList', [] ) + $error;
		}
		catch( \Aimeos\MShop\Exception $e )
		{
			$error = array( $context->getI18n()->dt( 'mshop', $e->getMessage() ) );
			$view->detailErrorList = $view->get( 'detailErrorList', [] ) + $error;
		}
		catch( \Exception $e )
		{
			$error = array( $context->getI18n()->dt( 'client', 'A non-recoverable error occured' ) );
			$view->detailErrorList = $view->get( 'detailErrorList', [] ) + $error;
			$this->logException( $e );
		}
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
		$context = $this->getContext();
		$config = $context->getConfig();
		$prodid = $view->param( 'd_prodid' );

		if( $prodid == '' )
		{
			/** client/html/catalog/detail/prodid-default
			 * The default product ID used if none is given as parameter
			 *
			 * To display a product detail view or a part of it for a specific
			 * product, you can configure its ID using this setting. This is
			 * most useful in a CMS where the product ID can be configured
			 * separately for each content node.
			 *
			 * @param string Product ID
			 * @since 2016.01
			 * @category User
			 * @category Developer
			 * @see client/html/catalog/lists/catid-default
			 */
			$prodid = $config->get( 'client/html/catalog/detail/prodid-default', '' );
		}


		$domains = array( 'media', 'price', 'text', 'attribute', 'product', 'product/property' );

		/** client/html/catalog/domains
		 * A list of domain names whose items should be available in the catalog view templates
		 *
		 * @see client/html/catalog/detail/domains
		 */
		$domains = $config->get( 'client/html/catalog/domains', $domains );

		/** client/html/catalog/detail/domains
		 * A list of domain names whose items should be available in the product detail view template
		 *
		 * The templates rendering product details usually add the images,
		 * prices, texts, attributes, products, etc. associated to the product
		 * item. If you want to display additional or less content, you can
		 * configure your own list of domains (attribute, media, price, product,
		 * text, etc. are domains) whose items are fetched from the storage.
		 * Please keep in mind that the more domains you add to the configuration,
		 * the more time is required for fetching the content!
		 *
		 * Since version 2014.05 this configuration option overwrites the
		 * "client/html/catalog/domains" option that allows to configure the
		 * domain names of the items fetched for all catalog related data.
		 *
		 * @param array List of domain names
		 * @since 2014.03
		 * @category Developer
		 * @see client/html/catalog/domains
		 * @see client/html/catalog/lists/domains
		 */
		$domains = $config->get( 'client/html/catalog/detail/domains', $domains );


		$controller = \Aimeos\Controller\Frontend\Factory::createController( $context, 'catalog' );
		$prodCntl = \Aimeos\Controller\Frontend\Factory::createController( $context, 'product' );

		$productItem = $prodCntl->getItem( $prodid, $domains );
		$this->addMetaItems( $productItem, $expire, $tags );

		$products = $productItem->getRefItems( 'product' );
		$this->addMetaItems( $products, $expire, $tags );


		/** client/html/catalog/detail/stock/enable
		 * Enables or disables displaying product stock levels in product detail view
		 *
		 * This configuration option allows shop owners to display product
		 * stock levels for each product in the detail views or to disable
		 * fetching product stock information.
		 *
		 * The stock information is fetched via AJAX and inserted via Javascript.
		 * This allows to cache product items by leaving out such highly
		 * dynamic content like stock levels which changes with each order.
		 *
		 * @param boolean Value of "1" to display stock levels, "0" to disable displaying them
		 * @since 2014.03
		 * @category User
		 * @category Developer
		 * @see client/html/catalog/lists/stock/enable
		 * @see client/html/catalog/stock/url/target
		 * @see client/html/catalog/stock/url/controller
		 * @see client/html/catalog/stock/url/action
		 * @see client/html/catalog/stock/url/config
		 */

		if( (bool) $view->config( 'client/html/catalog/detail/stock/enable', true ) === true ) {
			$view->detailStockUrl = $this->getStockUrl( $view, array_merge( $products, array( $productItem ) ) );
		}

		$view->detailProductItems = $products;
		$view->detailProductItem = $productItem;
		$view->detailParams = $this->getClientParams( $view->param() );

		return parent::addData( $view, $tags, $expire );
	}
}
