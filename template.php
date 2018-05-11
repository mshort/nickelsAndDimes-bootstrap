<?php
/**
 * @file
 * The primary PHP file for this theme.
 */

function nickels_and_dimes_preprocess_page(&$variables) {
//Removes the "Welcome" message that is caused by lack of front page content
  if (drupal_is_front_page()) {
    drupal_set_title(''); //removes welcome message (page title)
  }
}

function nickels_and_dimes_preprocess_islandora_book_book(array &$variables) {

  $object = $variables['object'];
  $rels = $object->relationships->get();
  $variables['rels'] = $rels;
  $related = array();

  foreach ($rels as $key => $rel) {
    if ($rel['predicate']['value'] == "IsCopyOf") {
      $edition = $rel['object']['value'];
    }
  }

  if (isset($edition)) {
    include_once('/var/www/drupal7/sites/all/libraries/easyrdf/lib/EasyRdf.php');

    // instantiation
    $sparql = new EasyRdf_Sparql_Client('http://backend.niu.dgicloud.com:8081/blazegraph/namespace/dimenovels/sparql');
    $work_results = $sparql->query('SELECT ?work ?title WHERE {<'.$edition.'> <http://rdaregistry.info/Elements/u/containerOf> ?work_edition . ?work_edition <https://dimenovels.org/ontology#IsRealizationOfCreativeWork> ?work. ?work <http://rdaregistry.info/Elements/u/preferredTitleForTheResource> ?title .}', 'rows');

    foreach ($work_results as $row) {
      $work = $row->work;
      $title = $row->title;
      // Start the query
      $query_string = "islandora/search/PID:";
      // Get the edition URIs
      $edition_results = $sparql->query('SELECT ?edition WHERE {<'.$work.'> <https://dimenovels.org/ontology#HasRealizationOfCreativeWork> ?work_editions .'.'?work_editions <http://rdaregistry.info/Elements/u/containedIn> ?edition .}', 'rows');
      $i = 0;
      $queryPids = array();
      foreach ($edition_results as $row) {
        $edition = $row->edition;
        // Retrieve the pid
        $query = "SELECT ?object WHERE {?object <https://dimenovels.org/ontology#IsCopyOf> <".$edition."> . FILTER(?object!=<info:fedora/".$object.">)}";
        $connection = islandora_get_tuque_connection();
        $edition_results = $connection->repository->ri->sparqlQuery($query);

        if (isset($edition_results[0])) {
          $edition_pid = '"'.$edition_results[0]['object']['value'].'"';
          $queryPids[] = $edition_pid;
        }
      }
      if (count($queryPids) > 0) {
        //$works[$work]['title']=$title;
        //$works[$work]['query']=$query_string . '(' . implode(' OR ', $queryPids) . ')';
        //$editions[] = l($works[$work]['title'], $works[$work]['query'], array('query' => array('sort'=>'mods_dateIssued_dt asc')));
        $editions[] = l($title, $query_string . '(' . implode(' OR ', $queryPids) . ')', array('query' => array('sort'=>'mods_dateIssued_dt asc')));
      }
    }

    if (!empty($editions)) {
      $list_variables = array(
        'items' => $editions,
        'title' => t(''),
        'type' => 'ul',
        'attributes' => array('class' => 'related_editions'),
        );
      $variables['editions'] = theme_item_list($list_variables);
    }
  }
}


//Implements hook_form_FORM_ID_alter to replace Islandora Simple Search button text with icon

function nickels_and_dimes_form_islandora_collection_search_form_alter(&$form, &$form_state) {
  $form['simple']['submit']['#value'] = t('<span class="glyphicon glyphicon-search"></span>');
}

function nickels_and_dimes_menu_link(array $variables) {
  $element = $variables['element'];
  $sub_menu = '';

  if ($element['#below']) {
    // Prevent dropdown functions from being added to management menu so it
    // does not affect the navbar module.
    if (($element['#original_link']['menu_name'] == 'management') && (module_exists('navbar'))) {
      $sub_menu = drupal_render($element['#below']);
    }
    elseif ((!empty($element['#original_link']['depth'])) && ($element['#original_link']['depth'] >= 1)) {
      // Add our own wrapper.
      unset($element['#below']['#theme_wrappers']);
      $sub_menu = '<ul>' . drupal_render($element['#below']) . '</ul>';
      // Generate as standard dropdown.
      $element['#attributes']['class'][] = 'dropdown';
      $element['#localized_options']['html'] = TRUE;

      // Set dropdown trigger element to # to prevent inadvertant page loading
      // when a submenu link is clicked.
      $element['#localized_options']['attributes']['data-target'] = '#';
      $element['#localized_options']['attributes']['class'][] = 'dropdown-toggle disabled';
      $element['#localized_options']['attributes']['data-toggle'] = 'dropdown';
    }
  }
  // On primary navigation menu, class 'active' is not set on active menu item.
  // @see https://drupal.org/node/1896674
  if (($element['#href'] == $_GET['q'] || ($element['#href'] == '<front>' && drupal_is_front_page())) && (empty($element['#localized_options']['language']))) {
    $element['#attributes']['class'][] = 'active';
  }
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}
// Adds machine name to class of ul for styling

function nickels_and_dimes_menu_tree($variables) {
  $menu_type = str_replace('menu_tree__menu_', '', $variables['theme_hook_original']);
  return '<ul class="menu ' . str_replace(array('_', ' '), '-', strtolower($menu_type)) . '-menu">' . $variables['tree'] . '</ul>';
}

function human_filesize($bytes, $decimals = 2) {
  $sz = 'BKMGTP';
  $factor = floor((strlen($bytes) - 1) / 3);
  return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
}
// Removed issue pager controls from newspaper page viewer, as well as JP2 download link
function nickels_and_dimes_preprocess_islandora_newspaper_page_controls(array &$variables) {
  module_load_include('inc', 'islandora', 'includes/datastream');
  module_load_include('inc', 'islandora', 'includes/utilities');
  global $base_url;
  $view_prefix = '<strong>' . t('View:') . ' </strong>';
  $download_prefix = '<strong>' . t('Download:') . ' </strong>';
  $object = $variables['object'];
  $issue = islandora_newspaper_get_issue($object);
  $issue = $issue ? islandora_object_load($issue) : FALSE;
  $controls = array(
    'page_select' => theme('islandora_newspaper_page_select', array('object' => $object)),
    'page_pager' => theme('islandora_paged_content_page_navigator', array('object' => $object)),
  );
  // Text view.
  if (isset($object['OCR']) && islandora_datastream_access(ISLANDORA_VIEW_OBJECTS, $object['OCR'])) {
    $url = islandora_datastream_get_url($object['OCR'], 'view');
    $attributes = array('attributes' => array('title' => t('View text')));
    $controls['text_view'] = $view_prefix . l(t('Text'), $url, $attributes);
  }
  // PDF download.
  if (isset($object['PDF']) && islandora_datastream_access(ISLANDORA_VIEW_OBJECTS, $object['PDF'])) {
    $size = islandora_datastream_get_human_readable_size($object['PDF']);
    $text = t('PDF (@size)', array('@size' => $size));
    $url = islandora_datastream_get_url($object['PDF'], 'download');
    $attributes = array('attributes' => array('title' => t('Download PDF')));
    $controls['pdf_download'] = $download_prefix . l($text, $url, $attributes);
  }
  // TIFF download.
  if (isset($object['OBJ']) && islandora_datastream_access(ISLANDORA_VIEW_OBJECTS, $object['OBJ'])) {
    $size = islandora_datastream_get_human_readable_size($object['OBJ']);
    $text = t('TIFF (@size)', array('@size' => $size));
    $url = islandora_datastream_get_url($object['OBJ'], 'download');
    $attributes = array('attributes' => array('title' => t('Download TIFF')));
    $controls['tiff_download'] = $download_prefix . l($text, $url, $attributes);
  }
  $variables['controls'] = $controls;
}

?>
