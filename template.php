<?php
/**
 * @file
 * The primary PHP file for this theme.
 */

function nickels_and_dimes_preprocess_page(&$variables) {
        //Removes the "Welcome" message that is caused by lack of content
  if (drupal_is_front_page()) { $variables['title']=""; }
}

//Implements hook_form_FORM_ID_alter to replace Islandora Simple Search button text with icon

function nickels_and_dimes_form_islandora_collection_search_form_alter(&$form, &$form_state) {
  $form['simple']['submit']['#value'] = t('<span class="glyphicon glyphicon-search"></span>');
}

function nickels_and_dimes_preprocess_islandora_book_book(array &$variables) {
  module_load_include('inc', 'islandora_paged_content', 'includes/utilities');
  module_load_include('inc', 'islandora', 'includes/solution_packs');
  module_load_include('inc', 'islandora', 'includes/metadata');
  module_load_include('inc', 'islandora', 'includes/datastream');
  drupal_add_js('misc/form.js');
  drupal_add_js('misc/collapse.js');
  $object = $variables['object'];
  $variables['viewer_id'] = islandora_get_viewer_id('islandora_book_viewers');
  $variables['viewer_params'] = array(
    'object' => $object,
    'pages' => islandora_paged_content_get_pages($object),
    'page_progression' => islandora_paged_content_get_page_progression($object),
  );
  $variables['display_metadata'] = variable_get('islandora_book_metadata_display', FALSE);
  $variables['parent_collections'] = islandora_get_parents_from_rels_ext($object);
  $variables['metadata'] = islandora_retrieve_metadata_markup($object);
  $variables['description'] = islandora_retrieve_description_markup($object);
  $rels = $object->relationships->get();
  $variables['rels'] = $rels;
  $related = array();
  foreach ($rels as $key => $rel) {
    if ($rel['predicate']['value'] == "IsCopyOf") {
      $edition = $rel['object']['value'];
    }
  }
  if (isset($edition)) {
    include_once('/var/www/drupal/htdocs/sites/all/libraries/easyrdf/EasyRdf.php');

    /* instantiation */
    $sparql = new EasyRdf_Sparql_Client('http://backend.niu.dgicloud.com:8081/blazegraph/namespace/dimenovels/sparql');
    $work_results = $sparql->query('SELECT ?work ?title WHERE {<'.$edition.'> <http://rdaregistry.info/Elements/u/containerOf> ?work_edition . ?work_edition <https://dimenovels.org/ontology#IsRealizationOfCreativeWork> ?work. ?work <http://rdaregistry.info/Elements/u/preferredTitleForTheResource> ?title .}', 'rows');
    foreach ($work_results as $row) {
      $work = $row['work'];
      $title = $row['title'];
      // Start the query
      $query_string = "islandora/search/PID:";
      // Get the edition URIs
      $edition_results = $sparql->query('SELECT ?edition WHERE {<'.$work.'> <https://dimenovels.org/ontology#HasRealizationOfCreativeWork> ?work_editions .'.'?work_editions <http://rdaregistry.info/Elements/u/containedIn> ?edition .}', 'rows');
      $i = 0;
      $queryPids = array();
      foreach ($edition_results as $row) {
        $edition = $row['edition'];
        // Retrieve the pid
        $query = "SELECT ?object FROM <#ri> WHERE {?object <https://dimenovels.org/ontology#IsCopyOf> <".$edition."> . FILTER(?object!=<info:fedora/".$object.">)}";
        $connection = islandora_get_tuque_connection();
        $edition_results = $connection->repository->ri->sparqlQuery($query);
        if (isset($edition_results[0])) {
          $edition_pid = '"'.$edition_results[0]['object']['value'].'"';
          $queryPids[] = $edition_pid;
        }
      }
      if (count($queryPids) > 0) {
        $works[$work]['title']=$title;
        $works[$work]['query']=$query_string . '(' . implode(' OR ', $queryPids) . ')';
        $editions[] = l($works[$work]['title'], $works[$work]['query'], array('query' =>array('sort'=>'mods_dateIssued_dt asc')));
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

// Removes several items from the newspaper page controls

function nickels_and_dimes_preprocess_islandora_newspaper_page_controls (array &$variables) {
  unset($variables['controls']['text_view'], $variables['controls']['pdf_download'], $variables['controls']['jp2_download'], $variables['controls']['clip'], $variables['controls']['tiff_download']);
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
    elseif ((!empty($element['#original_link']['depth'])) && ($element['#original_link']['depth'] == 1)) {
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

?>
