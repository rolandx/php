 <?php
    $displayTermID =array(1978, 1979, 2002, 2003, 2004);
    // This will show on the index page for that term
    if ((arg(0) == 'taxonomy') &&  (arg(1) == $displayTermID)) {
            return TRUE;
    }
    
     $desired_terms = array(1978, 1979, 2002, 2003, 2004);
    if ( arg(0) == 'node' && is_numeric(arg(1)) && arg(2) == FALSE ) {
      $node = node_load(arg(1)); // cached
      if (is_array($node->taxonomy)) {
        foreach ($node->taxonomy as $term) {
          if ( in_array($term->tid, $desired_terms) ) {
            return TRUE;
          } //if
        } //foreach term
      } //if
    } //if node
    return FALSE;




    
    
    
?>



<?php
$desired_terms = array(1978, 1979, 2002, 2003, 2004);	

if(arg(0) == 'quiz' ){
          $term_id =  node_load(arg(1));
          if ( in_array($term_tid, $desired_terms) ) {
            return TRUE;
          } //if
}

if ( arg(0) == 'node' && is_numeric(arg(1)) && arg(2) == FALSE ) {
      $node = node_load(arg(1)); // cached
      if (is_array($node->taxonomy)) {
        foreach ($node->taxonomy as $term) {
          if ( in_array($term->tid, $desired_terms) ) {
            return TRUE;
          } //if
        } //foreach term
      } //if
    } //if node
    return FALSE;

?>


<?php
$desired_terms = array(1978, 1979, 2002, 2003, 2004);
$term_url = array('quiz/1978', 'quiz/1979', 'quiz/2002', 'quiz/2003', 'quiz/2004');

$node_url=drupal_get_path_alias($_GET['q']);
$pos=strpos($node_url,'quiz/');

if($pos!== false && in_array($node_url, $term_url ) ){
      
            return TRUE;
}

if ( arg(0) == 'node' && is_numeric(arg(1)) && arg(2) == FALSE ) {
      $node = node_load(arg(1)); // cached
      if (is_array($node->taxonomy)) {
        foreach ($node->taxonomy as $term) {
          if ( in_array($term->tid, $desired_terms) ) {
            return TRUE;
          } //if
        } //foreach term
      } //if
    } //if node
    return FALSE;

?>



