<?php
	// Using below code you can able to display table with sortable headers & pagination.
	// Define table headers.
	$header = array(
	  array('data' => 'ID', 'field' => 'id', 'sort' => 'ASC'),
	  array('data' => 'Name', 'field' => 'name'),
	  array('data' => 'Date of birth', 'field' => 'dob'),
	  array('data' => 'Email', 'field' => 'email'),
	);
	// Here 'field' values are database field values. (Ex: 'field' => 'name')
  // If you want to assign sort option to table field like ID, use 'sort' attribute (ex: 'sort' => 'ASC').
  // DB query.
  $select = db_select('my_table', 't')
   // This line is to enable pagination
   ->extend('PagerDefault')
   // This is for table sort
   ->extend('TableSort');
   // Example for LIKE condition
   if (condition) {
     $select->condition('email', '%' . db_like($qry['email']) . '%', 'LIKE');
   }
	$select->fields('t', array('id', 'name', 'dob', 'email'))
   // Pagination limit
   ->limit(10)
   // Sort table header
   ->orderByHeader($header)
   // Example for group by
   ->groupBy('t.email')
   // example for order by
   ->orderBy('updated_time', 'DESC')
   // Example for COUNT().
   ->addExpression('COUNT(*)', 'total');
 	$results = $select->execute();
 	// Collect table row values
 	foreach ($results as $row) {
   $rows[] = array(
      // ID with hyperlink.
      l($row->id, 'url', array('query' => array('qry' => $row->email), 'attributes' => array('target' => '_blank'))),
      $row->name,
      $row->dob,
      $row->email, // $row->total can also be used here.
    );
  }
  // Putting all together to form a table.
  $output .= theme('table', array('header' => $header, 'rows' => $rows, "empty" => t("Table has no row!"), "sticky" => true));
	$output .= theme('pager');
	return $output;
?>