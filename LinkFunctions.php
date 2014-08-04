<?php
/**
 * @copyright Roy Rosenzweig Center for History and New Media, 2007-2010
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @package Omeka_ThemeHelpers
 * @subpackage LinkHelpers
 */


/**
 * Generate an unordered list of navigation links (and subnavigation links),
 * with class "current" for any links corresponding to the current page
 *
 * For example:
 * <code>nav(array('Themes' => uri('themes/browse')));</code>
 * generates
 * <code><li class="nav-themes"><a href="themes/browse">Themes</a></li></code>
 *
 * @uses is_current_uri()
 * @param array A keyed array, where key = text of the link, and value = uri of the link,
 * or value = another ordered array $a with the following recursive structure:
 * $a['uri'] = URI of the link
 * $a['subnav_links'] = array of $sublinks for the sub navigation (this can be recursively structured like $links)
 * $a['subnav_attributes'] = associative array of attributes for the sub navigation
 *
 * For example:
 * $links = array('Browse' => 'http://yoursite.com/browse',
 *                'Categories' => array('uri' => 'http://yoursite.com/categories',
 *                                      'subnav_links' => array('Dogs' => 'http://yoursite.com/dogs',
 *                                                              'Cats' => 'http://yoursite.com/cats'),
 *                                      'subnav_attributes' => array('class' => 'subnav')),
 *                'Contact Us' => 'http://yoursite.com/contact-us');
 * echo nav($links);
 *
 * This would produce:
 * <li><a href="http://yoursite.com/browse">Browse</a></li>
 * <li><a href="http://yoursite.com/categories">Categories</a>
 *     <ul class="subnav">
 *        <li><a href="http://yoursite.com/dogs">Dogs</a></li>
 *        <li><a href="http://yoursite.com/cats">Cats</a></li>
 *    </ul>
 * </li>
 * <li><a href="http://yoursite.com/contact-us">Contact Us</a><li>
 *
 * @param integer|null $maxDepth The maximum number of sub navigation levels to display.
 * By default it is 0, which means it will only display the top level of links.
 * If null, it will display all the levels.
 *
 * @return string HTML for the unordered list
 */
function bootstrap_nav(array $links, $maxDepth = 0)
{
    // Get the current uri from the request
    $current = Zend_Controller_Front::getInstance()->getRequest()->getRequestUri();

    $nav = "<div class='btn-group'>\n";
    foreach( $links as $text => $uri ) {

        // Get the subnavigation attributes and links
        $subNavLinks = null;
        if (is_array($uri)) {
            $subNavLinks = $uri['subnav_links'];
            if (!is_array($subNavLinks)) {
                $subNavLinks = array();
            }
            $subNavAttributes = $uri['subnav_attributes'];
            if (!is_array($subNavAttributes)) {
                $subNavAttributes = array();
            }
            $uri = (string) $uri['uri'];
        }

        // Build a link if the uri is available, otherwise simply list the text without a hyperlink
        $nav .= '<li class="' . text_to_id($text, 'nav');
        if ($uri == '') {
            $nav .= '">' . html_escape($text);
        } else {
            // If the uri is the current uri, then give it the 'current' class
            $nav .= (is_current_uri($uri) ? ' current':'') . '">' . '<a href="' . html_escape($uri) . '">' . html_escape($text) . '</a>';
        }

        // Display the subnavigation links if they exist and if the max depth has not been reached
        if ($subNavLinks !== null && ($maxDepth === null || $maxDepth > 0)) {
            $subNavAttributes = !empty($subNavAttributes) ? ' ' . _tag_attributes($subNavAttributes) : '';
            $nav .= "\n" . '<ul' . $subNavAttributes . '>' . "\n";
            if ($maxDepth === null) {
                $nav .= bootstrap_nav($subNavLinks, null);
            } else {
                $nav .= bootstrap_nav($subNavLinks, $maxDepth - 1);
            }
            $nav .= '</ul>' . "\n";
        }

        $nav .= '</li>' . "\n";
    }
    $nav .= "</div>";
    return $nav;
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
function JUNK_pagination_links($options = array())
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
