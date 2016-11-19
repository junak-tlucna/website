<?php
/**
 * @package		Goldpicasa
 * @subpackage	Content Plugin
 * @license		GNU General Public License version 2 or later; see LICENSE
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

/**
 * Goldpicasa Content Plugin
 *
 * @package		Goldpicasa
 * @subpackage	Content Plugin
 * @since		1.0
 */
class plgContentGoldpicasa extends JPlugin
{

	private $config=array();
	private static $albumRenderCount=1; 
	
	public function __construct(&$subject, $config = array()) {
		parent::__construct($subject, $config);
	}
	
	
	/**
	 * Render album universal
	 * @param array $attribs
	 * @param string $position
	 * @return boolean|string
	 */
	private function renderAlbumForArticle($attribs, $position) {
		
		if ( JRequest::getCmd('view')!=='article' && JRequest::getCmd('view')!=='category' && JRequest::getCmd('featured') ) {
			return false;
		}
		if (JRequest::getCmd('view')==='category' && JRequest::getCmd('layout')!=='blog') {
			return false;
		}
		jimport('joomla.html.parameter');
		self::$albumRenderCount++;
		$art_attribs = new JRegistry($attribs);
		$art_attribs_array = $art_attribs->toArray();
		
		if ( !isset($art_attribs_array['goldpicasa'])) {
			return false;
		}
		$art_attribs_array = $art_attribs_array['goldpicasa'];
		
		//Featured/Blog
		if ( JRequest::getCmd('view')==='category' || JRequest::getCmd('view') === 'featured' ) {
			if ( !isset($art_attribs_array['goldGalleryShowOnFeaturedList']) || intval($art_attribs_array['goldGalleryShowOnFeaturedList']) < 1 ) {
				return false;
			}
		}

		if ( isset($art_attribs_array['goldGalleryTopOrBottom']) && $art_attribs_array['goldGalleryTopOrBottom'] == $position ) {
			require_once JPATH_SITE . '/components/com_goldpicasa/helpers/goldpicasa.php';
			
			if ( !isset($art_attribs_array['goldGalleryAlbumId'][10]) ) return '';
			$albumAndUser = explode(',', $art_attribs_array['goldGalleryAlbumId']);
			
			if ( !isset($albumAndUser[1]) || !is_numeric( $albumAndUser[0] ) )
			{
				JError::raiseWarning('com_goldpicasa', 'Album not found');
				return false;
			}
			
			$p = GoldpicasaHelper::renderAlbum( $art_attribs_array );

			// AfterTitle HACK :)
			if ($position==='bottomtop') { 
				echo GoldpicasaHelper::renderPlugin($p, $albumAndUser[0]);
			} else {
				return GoldpicasaHelper::renderPlugin($p, $albumAndUser[0]);
			}
			
		}
		
	}
	


	/**
	 * AfterTitle HACK :)
	 * @param unknown_type $context
	 * @param unknown_type $row
	 * @param unknown_type $params
	 * @param unknown_type $page
	 */
	public function onContentAfterTitle($context, &$row, &$params, $page = 0)
	{
		if (!isset($row->attribs)) return false;
		return $this->renderAlbumForArticle($row->attribs, 'bottomtop');
	}
	
	public function onContentBeforeDisplay($context, &$row, &$params, $page = 0)
	{	
		if (!isset($row->attribs)) return false;
		return $this->renderAlbumForArticle($row->attribs, 'top');
	}
	
	public function onContentAfterDisplay($context, &$row, &$params, $page = 0)
	{
		if (!isset($row->attribs)) return false;
		
		return $this->renderAlbumForArticle($row->attribs, 'bottom');
	}

	public function onContentPrepareForm($form, $data)
	{
		if ($form->getName() != 'com_content.article') return;

		$this->loadLanguage('com_goldpicasa');
		$form->loadFile(dirname(__FILE__).'/goldpicasa_form.xml');
	}

}
