<?php 
/**
 * Use this file to define customized helper functions, filters or 'hacks'
 * defined specifically for use in your Omeka theme. Ideally, you should
 * namespace these with your theme name to avoid conflicts with functions
 * in Omeka and any plugins.
 */

function bootstrap_utf8_htmlspecialchars($value)
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function bootstrap_show_untitled_items($title)
{
    // Remove all whitespace and formatting before checking to see if the title 
    // is empty.
    $prepTitle = trim(strip_formatting($title));
    if (empty($prepTitle)) {
        return __('[Untitled]');
    }
    return $title;
}

/**
* This function checks the Logo theme option, then returns either an
* image tag with the logo as the src, or returns null.
*
*/
function bootstrap_custom_display_logo()
{
    if(function_exists('get_theme_option')) {
    
        $logo = get_theme_option('Logo');

        if ($logo) {
            $storage = Zend_Registry::get('storage');
            $uri = $storage->getUri($storage->getPathByType($logo, 'theme_uploads'));
            return '<img src="'.$uri.'" title="'.settings('site_title').'" />';
        }
    }
    return null;
}

function bootstrap_get_metadata($item, $field = null, $alternate = null)
{
  $field = trim($field);
  if (element_exists('Dublin Core', $field)) {
    if ($fieldValues = metadata('item', array('Dublin Core', $field), array('all' => true))) {
      $html = '<b>'.__($field).'</b><br />';
      if ($alternate) { $html = '<b>' . $alternate . '</b><br />'; }
      $htmlfield = '';
      foreach ($fieldValues as $key => $fieldValue) {
          // $fieldValue = nls2p($fieldValue);
          if ($htmlfield != '') {  $htmlfield .= '<br />'; }
          $htmlfield .= $fieldValue;
      }
      $html .= $htmlfield ;
      return $html;
    }
  }
  return '';
}


function bootstrap_custom_show_item_metadata(array $options = array(), $item = null)
{
    /**
    if (!$item) {
        $item = get_current_item();
    }
    **/
    $html  = '<div class="row">';
    $html .= '  <div class="col-md-2">' . bootstrap_get_metadata($item,'Date') . '</div>';
    $html .= '  <div class="col-md-2">' . bootstrap_get_metadata($item,'Identifier') . '</div>';
    $html .= '  <div class="col-md-8">' . bootstrap_get_metadata($item,'Relation','Location') . '</div>';
    $html .= '</div>';
    $html .= '<br />';
    $html .= '<div class="row">';
    $html .= '  <div class="col-md-3">' . bootstrap_get_metadata($item,'Creator','Author/Creator') . '</div>';
    $html .= '  <div class="col-md-3">' . bootstrap_get_metadata($item,'Contributor','Recipient') . '</div>';
    $html .= '  <div class="col-md-6">' . bootstrap_get_metadata($item,'Subject','Subjects') . '</div>';
    $html .= '</div>';
    $html .= '<div class="row">';
    $html .= '  <div class="col-md-10">' . bootstrap_get_metadata($item,'Description') . '</div>';
    $html .= '</div>';
    $html .= '<div class="row">';
    $html .= '  <div class="col-md-10">' . bootstrap_get_metadata($item,'Source','Archivist\'s Notes') . '</div>';
    $html .= '</div>';
    return $html;
}

function table_bootstrap_custom_show_item_metadata(array $options = array(), $item = null)
{
    if (!$item) {
        $item = get_current_item();
    }
    if ($dcFieldsList = get_theme_option('display_dublin_core_fields')) {

        $otherElementSets = array();

        $elementSets = get_db()->getTable('ElementSet')->findForItems();
        foreach ($elementSets as $set) {
            if ($set->name == 'Dublin Core') continue;
            $otherElementSets[] = $set->name;
        }

        $html = '<table class="table table-condensed"><tbody>';
        $dcFields = explode(',', $dcFieldsList);
        foreach ($dcFields as $field) {
            $field = trim($field);
            if (element_exists('Dublin Core', $field)) {
                if ($fieldValues = item('Dublin Core', $field, 'all')) {
                    $html .= '<tr><td>'.__($field).'</td>';
                    $htmlfield = '';
                    foreach ($fieldValues as $key => $fieldValue) {
                        if (!item_field_uses_html('Dublin Core', $field, $key)) {
                            $fieldValue = nls2p($fieldValue);
                            $htmlfield .= $fieldValue;
                        }
                    }
                    $html .= '<td>' . $htmlfield . '</td></tr>';
                }
            }
        }
        $html .= '</tbody></table>';
        $html .= show_item_metadata(array('show_element_sets' => $otherElementSets));
        return $html;
    } else {
        return show_item_metadata($options, $item); 
    }
}



/**
 * Retrieve HTML for the set of pagination links.
 *
 * @since 0.10
 * @param array $options Optional Configurable parameters for the pagination
 * links.  The following options are available:
 *      'scrolling_style' (string) See Zend_View_Helper_PaginationControl
  * for more details.  Default 'Sliding'.
 *      'partial_file' (string) View script to use to render the pagination HTML.
 * Default is 'common/pagination_control.php'.
 *      'page_range' (integer) See Zend_Paginator::setPageRange() for details.
 * Default is 5.
 *      'total_results' (integer) Total results to paginate through.  Default is
 * provided by the 'total_results' key of the 'pagination' array that is typically
 * registered by the controller.
 *      'page' (integer) Current page of the result set.  Default is the 'page'
 * key of the 'pagination' array.
 *      'per_page' (integer) Number of results to display per page.  Default is
 * the 'per_page' key of the 'pagination' array.
 * @return string HTML for the pagination links.
 */
function JUNK3_bootstrap_pagination_links($options = array())
{
    if (Zend_Registry::isRegistered('pagination')) {
        // If the pagination variables are registered, set them for local use.
        $p = Zend_Registry::get('pagination');
    } else {
        // If the pagination variables are not registered, set required defaults
        // arbitrarily to avoid errors.
        $p = array('total_results'   => 1,
                   'page'            => 1,
                   'per_page'        => 1);
    }

    // Set preferred settings.
    $scrollingStyle   = isset($options['scrolling_style']) ? $options['scrolling_style']     : 'Sliding';
    $partial          = isset($options['partial_file'])    ? $options['partial_file']        : 'common/pagination_control.php';
    $pageRange        = isset($options['page_range'])      ? (int) $options['page_range']    : 5;
    $totalCount       = isset($options['total_results'])   ? (int) $options['total_results'] : (int) $p['total_results'];
    $pageNumber       = isset($options['page'])            ? (int) $options['page']          : (int) $p['page'];
    $itemCountPerPage = isset($options['per_page'])        ? (int) $options['per_page']      : (int) $p['per_page'];

    // Create an instance of Zend_Paginator.
    $paginator = Zend_Paginator::factory($totalCount);

    // Configure the instance.
    $paginator->setCurrentPageNumber($pageNumber)
              ->setItemCountPerPage($itemCountPerPage)
              ->setPageRange($pageRange);

    return __v()->paginationControl($paginator,
                                    $scrollingStyle,
                                    $partial);
}

/**
 * Helper function to be used in public themes to allow plugins to modify the navigation of those themes.
 *
 * Plugins can modify navigation by adding filters to specific subsets of the
 *  navigation. For instance, most themes will have what might be called a 'main'
 *  navigation set on the header of the site. This main navigation header would
 *  be attached to a filter called 'public_navigation_main', which would always
 *  act on that particular navigation. You would signal to the plugins to
 *  differentiate between the different navigation elements by passing the 2nd
 *  argument as 'main', so that it knew that this was the main navigation.
 *
 * @since 0.10
 * @see apply_filters()
 * @param array $navArray
 * @param string|null $navType
 * @param integer|null $maxDepth
 * @return string HTML
 */
function bootstrap_public_nav(array $navArray, $navType=null, $maxDepth = 0)
{
    if ($navType) {
        $filterName = 'public_navigation_' . $navType;
        $navArray = apply_filters($filterName, $navArray);
    }
    return bootstrap_nav($navArray, $maxDepth);
}

/**
 * Alias for public_nav($array, 'main'). This is to avoid potential typos so
 *  that all plugins can count on having at least a 'main' navigation filter in
 *  the public themes.
 *
 * @since 0.10
 * @param array $navArray
 * @param integer|null $maxDepth
 * @uses public_nav()
 * @return string
 */
function bootstrap_public_nav_main(array $navArray, $maxDepth = 0)
{
    return bootstrap_public_nav($navArray, 'main', $maxDepth);
}

/**
 * Alias for public_nav($array, 'items'). Provides a navigation and filter for
 * the items/browse page.
 *
 * @since 1.3
 * @param array $navArray
 * @param integer|null $maxDepth
 * @uses public_nav()
 * @return string
 */
function bootstrap_public_nav_items(array $navArray, $maxDepth = 0)
{
    return bootstrap_public_nav($navArray, 'items', $maxDepth);
}

/**
 * Creates a link to the Items Atom view.
 *
 * @deprecated since 1.5
 * @param string $text The text of the link.
 * @param array $params A set of query string parameters to merge in to the href
 * of the link.  E.g., if this link was clicked on the items/browse?collection=1
 * page, and array('foo'=>'bar') was passed as this argument, the new URI would be
 * items/browse?collection=1&foo=bar.
 * @param array $tagAttributes An array of tag attributes for the link.
 */
function bootstrap_link_to_items_atom($text = null, $params=array(), $tagAttributes=array('class' => 'atom'))
{
    if (!$text) {
        $text = __('Atom');
    }
    $tagAttributes['href'] = html_escape(items_output_uri('atom', $params));
    return '<a ' . _tag_attributes($tagAttributes) . '>' . $text . '</a>';
}

add_filter(array('Display', 'Item', 'Dublin Core', 'Creator'), 'filter_creator_search');
function filter_creator_search($creator)
{
    if (empty($creator)) {
        return $creator;
    }
    $creatorId = get_db()->getTable('Element')
                         ->findByElementSetNameAndElementName('Dublin Core', 'Creator')
                         ->id;
    $url = url('items/browse',
               array('advanced[0][element_id]' => $creatorId,
                     'advanced[0][type]' => 'contains',
                     'advanced[0][terms]' => $creator));
    $url = url('items/browse/tag/' . html_escape($creator));
    return '<a href="'.$url.'">'.$creator.'</a>';
}


add_filter(array('Display', 'Item', 'Dublin Core', 'Subject'), 'filter_subject_search');
function filter_subject_search($creator)
{
    if (empty($creator)) {
        return $creator;
    }
    $creatorId = get_db()->getTable('Element')
                         ->findByElementSetNameAndElementName('Dublin Core', 'Subject')
                         ->id;
    $url = url('items/browse',
               array('advanced[0][element_id]' => $creatorId,
                     'advanced[0][type]' => 'contains',
                     'advanced[0][terms]' => $creator));
    $url = url('items/browse/tag/' . html_escape($creator));
    return '<a href="'.$url.'">'.$creator.'</a>';
}

add_filter(array('Display', 'Item', 'Dublin Core', 'Contributor'), 'filter_contributor_search');
function filter_contributor_search($creator)
{
    if (empty($creator)) {
        return $creator;
    }
    $creatorId = get_db()->getTable('Element')
                         ->findByElementSetNameAndElementName('Dublin Core', 'Contributor')
                         ->id;
    $url = url('items/browse',
               array('advanced[0][element_id]' => $creatorId,
                     'advanced[0][type]' => 'contains',
                     'advanced[0][terms]' => $creator));
    $url = url('items/browse/tag/' . html_escape($creator));
    return '<a href="'.$url.'">'.$creator.'</a>';
}

add_filter(array('Display', 'Item', 'Dublin Core', 'Relation'), 'filter_relation_search');
function filter_relation_search($creator)
{
    if (empty($creator)) {
        return $creator;
    }
    $creatorId = get_db()->getTable('Element')
                         ->findByElementSetNameAndElementName('Dublin Core', 'Relation')
                         ->id;
    $url = url('items/browse',
               array('advanced[0][element_id]' => $creatorId,
                     'advanced[0][type]' => 'contains',
                     'advanced[0][terms]' => $creator));
    return '<a href="'.$url.'">'.$creator.'</a>';
}


/**
 * Output a tag string given an Item, Exhibit, or a set of tags.
 *
 * @internal Any record that has the Taggable module can be passed to this function
 * @param Omeka_Record|array $recordOrTags The record to retrieve tags from, or the actual array of tags
 * @param string|null $link The URL to use for links to the tags (if null, tags aren't linked)
 * @param string $delimiter ', ' (comma and whitespace) by default
 * @return string HTML
 */
function bootstrap_tag_string($recordOrTags = null, $link=null, $delimiter=null)
{
    // Set the tag_delimiter option if no delimiter was passed.
    if (is_null($delimiter)) {
        $delimiter = get_option('tag_delimiter') . ' ';
    }
    $delimiter = "\n    ";

    if (!$recordOrTags) {
        $recordOrTags = array();
    }

    if ($recordOrTags instanceof Omeka_Record) {
        $tags = $recordOrTags->Tags;
    } else {
        $tags = $recordOrTags;
    }

    $previousletter = '';
    $tagString = '';
    $mystyle = ' style="-moz-column-width: 14em; -moz-column-gap: 1em; -moz-column-rule: thin solid gray; " ';

    if (!empty($tags)) {
        $tagStrings = array();
        foreach ($tags as $key=>$tag) {
            $firstletter = strtolower($tag['name'][0]);
            $sectionstart = '';
            if ($previousletter == '') {
               $sectionstart = "\n" . '<div class="tab-pane active tag-fluid-column" id="tag-' . $firstletter . '"><ul>' . "\n    ";
               $previousletter = $firstletter;
               }
            if ($previousletter != $firstletter) {
               $sectionstart = "\n" . '</ul></div> <div class="tab-pane tag-fluid-column" id="tag-' . $firstletter . '"><ul>' . "\n    ";
               $previousletter = $firstletter;
               }
            if (!$link) {
                $tagStrings[$key] = $sectionstart . html_escape($tag['name']);
            } else {
                $tagStrings[$key] = $sectionstart . '<li><a href="' . html_escape($link.urlencode($tag['name'])) . '" rel="tag">'.html_escape($tag['name']).'</a></li>';
            }
        }
        $tagString = join(html_escape($delimiter),$tagStrings) . '</ul></div>';
        $tagString = join($delimiter,$tagStrings) . '</ul></div>';
    }
    return $tagString;
}


/**
* Return Tags associated with Items in a given Collection.
*
* @param Collection
* @return array Tags.
*/
function bootstrap_get_tags_for_items_in_collection($collection = null) {

    // If collection is null, get the current collection.
    if (!$collection) {
        $collection = get_current_record('collection');
    }

    // Get the database.
    $db = get_db();

    // Get the Tag table.
    $table = $db->getTable('Tag');

    // Get list of collections and their parents which the tag is a member of
    // $childCollections = $db->getTable('CollectionTree')->getDescendantTree($collectionId); 

    // Build the select query.
    $select = $table->getSelectForFindBy();

    // Join to the Item table where the collection_id is equal to the ID of our Collection.
    if ($collection) {
        $table->filterByTagType($select, 'Item');
        /* $table->sortBy($select, 'alpha'); */
        $table->applySorting($select, 'name', 'ASC');
        $alias = $table->getTableAlias();
        $select->where('items.collection_id = ?', $collection->id);
    }

    // Fetch some tags with our select.
    $tags = $table->fetchObjects($select);

    return $tags;
}

function bootstrap_display_featured_collections()
{
    $collectionTable = get_db()->getTable('Collection');
    #$select = $collectionTable->getSelect()->where("c.featured = 1")->order("RAND()")->limit(3);
    #$select = $collectionTable->getSelect()->where("c.featured = 1")->order("RAND()");
    #$featuredCollections = $collectionTable->fetchObjects($select);
    $featuredCollections = bootstrap_get_random_featured_collections();

    $html = '<h2>The Collections</h2>';
 
 
    if(count($featuredCollections) != 0) {
      foreach($featuredCollections as $featuredCollection) {
        $collectionTitle = metadata($featuredCollection, array('Dublin Core', 'Title'), array());
        $html .= '<h3>' . link_to_collection($collectionTitle, array(), 'show', $featuredCollection) . '</h3>';
	if ($collectionDescription = metadata($featuredCollection, array('Dublin Core', 'Description'), array('snippet'=>150))) {
	  $html .= '<p class="collection-description">' . $collectionDescription . '</p>';
	  }
 
      }
    } else {
	  $html .= '<p>No featured collections are available.</p>';
    }
 
    return $html;
}

/**
* Custom function to retrieve any number of random featured items.
* via Jeremy Boggs
* This functionality will likely be incorporated into future versions of Omeka (1.4?)
* @param int $num The number of random featured items to return
* @param boolean $withImage Whether to return items with derivative images. True by default.
*/
function bootstrap_get_random_featured_items($num = '10', $withImage = true)
{
    // Get the database.
    $db = get_db();

    // Get the Item table.
    $table = $db->getTable('Item');

    // Build the select query.
    $select = $table->getSelect();
    $select->from(array(), 'RAND() as rand');
    $select->where('i.featured = 1');
    $select->order('rand DESC');
    $select->limit($num);

    // If we only want items with derivative image files, join the File table.
    if ($withImage) {
        $select->joinLeft(array('f'=>"$db->File"), 'f.item_id = i.id', array());
        $select->where('f.has_derivative_image = 1');
    }

    // Fetch some items with our select.
    $items = $table->fetchObjects($select);

    return $items;
}

/**
 * Returns multiple random featured item
 *
 * @since 1.4
 * @param integer $num The maximum number of recent items to return
 * @param boolean|null $hasImage
 * @return array $items
 */

function XXXbootstrap_display_random_featured_items($num = 5, $hasImage = null)
{
    return random_featured_items($num, $hasImage);
    $html = '';

    $randomFeaturedItems = get_records('Item', array('featured' => 1, 'sort_field' => 'random'), $num);

    /** if ($randomFeaturedItems = random_featured_items($num, $hasImage)) { **/
    if ($randomFeaturedItems ) {

        foreach ($randomFeaturedItems as $randomItem) {
            $itemTitle = metadata($randomItem, array('Dublin Core', 'Title'), array());

            $html .= '<div class="col-md-3"><h3>' . link_to_item($itemTitle, array(), 'show', $randomItem) . '</h3>';

            if (metadata($randomItem,'has thumbnail')) {
                $html .= link_to_item(item_image('square_thumbnail', 0, $randomItem), array('class'=>'image'), 'show', $randomItem);
            }

            if ($itemDescription = metadata('item', array('Dublin Core', 'Description'), array('snippet'=>150), $randomItem)) {
                $html .= '<p class="item-description">' . $itemDescription . '</p>';
            }
            $html .= '</div>';
        }
    } else {
        $html .= '<p>'.__('No featured items are available.').'</p>';
    }

    return $html;
}



/**
 * Retrieve a valid citation for the current item.
 *
 * Generally follows Chicago Manual of Style note format for webpages.  Does not
 * account for multiple creators or titles.
 *
 * @since  0.10
 * @param Item|null Check for this specific item record (current item if null).
 * @return string
 */
function bootstrap_item_citation($item = null)
{
    if(!$item) {
        $item = get_current_item();
    }

    $creator    = strip_formatting(item('Dublin Core', 'Creator', array(), $item));
    $title      = strip_formatting(item('Dublin Core', 'Title', array(), $item));
    $identifier = strip_formatting(item('Dublin Core', 'Identifier', array(), $item));
    $siteTitle  = strip_formatting(settings('site_title'));
    $itemId     = item('id', null, array(), $item);
    $accessDate = date('F j, Y');
    $uri        = html_escape(abs_item_uri($item));

    $cite = '';
    if ($creator) {
        $cite .= "$creator, ";
    }
    if ($title) {
        $cite .= "&#8220;$title,&#8221; ";
    }
    if ($siteTitle) {
        $cite .= "<em>$siteTitle</em>, ";
    }
    if ($identifier) {
        $cite .= "Reference $identifier, ";
    }
    $cite .= "accessed $accessDate, ";
    $cite .= "$uri.";

    return apply_filters('item_citation', $cite, $item);
}


/**
 * Determine whether the given URI matches the current request URI.
 *
 * Instantiates view helpers directly because a view may not be registered.
 *
 * @package Omeka\Function\View\Navigation
 * @param string $url
 * @return boolean
 */
function bootstrap_is_current_url($url)
{
    $request = Zend_Controller_Front::getInstance()->getRequest();
    $currentUrl = $request->getRequestUri();
    $baseUrl = $request->getBaseUrl();

    // Strip out the protocol, host, base URL, and rightmost slash before
    // comparing the URL to the current one
    $stripOut = array(WEB_DIR, @$_SERVER['HTTP_HOST'], $baseUrl);
    $currentUrl = rtrim(str_replace($stripOut, '', $currentUrl), '/');
    $url = rtrim(str_replace($stripOut, '', $url), '/');
    $currentUrl = rtrim(str_replace('items/tags', 'tags', $currentUrl), '/');
    $url        = rtrim(str_replace('items/tags', 'tags', $url), '/');
    
    // print 'CurrentURL: ' . $currentUrl . '   passed: ' . $url;

    if (strlen($url) == 0) {
        return (strlen($currentUrl) == 0);
    }
    return ($url == $currentUrl) or (strpos($currentUrl, $url) === 0);
}

function bootstrap_nav_item($label,$url)
{
  $html = bootstrap_is_current_url($url) ? '<li class="active">' : '<li>';
  $html .= '<a href="' . url($url) . '">' . $label . "</a></li>\n";
  return $html;
}

/**
 * Get random featured collections.
 *
 * @uses get_records()
 * @param integer $num The maximum number of recent items to return
 * @return array|Item
 */
function bootstrap_get_random_featured_collections($num = 5)
{
    return get_records('Collection', array('featured' => 1,
                                     'sort_field' => 'random'), $num);
}


