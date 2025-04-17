<?php
/**
 * The Template for displaying all single posts.
 */
 $post = $wp_query->post;
 if (in_category('1')) {
  include(TEMPLATEPATH.'/single-berater.php');
  
 } elseif (in_category('28')) {
  include(TEMPLATEPATH.'/single-presse.php');
  
 } elseif (in_category('5')) {
  include(TEMPLATEPATH.'/single-branchen.php');

 } elseif (in_category('35')) {
    include(TEMPLATEPATH.'/single-interviews.php');
  
 } elseif (in_category('36')) {
  include(TEMPLATEPATH.'/single-publish.php');
  
 } elseif (in_category('37')) {
  include(TEMPLATEPATH.'/single-events.php');

 } elseif (in_category('57')) {
  include(TEMPLATEPATH.'/single-referenzen.php');
  
 } else {
  include(TEMPLATEPATH.'/single-default.php');
 }
?>