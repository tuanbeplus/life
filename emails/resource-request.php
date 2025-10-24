A new printed resource request has been received. Please see below for details.

Full Name: <?php echo $data['full_name']; ?> 
Name of Organisation: <?php echo $data['org_name']; ?> 
Email: <?php echo $data['email']; ?> 
Phone: <?php echo $data['phone']; ?> 

Address: <?php echo $data['address']; ?> 
Suburb: <?php echo $data['suburb']; ?> 
State: <?php echo $data['state']; ?> 
Postcode: <?php echo $data['postcode']; ?> 

Are these resources for a specific event: <?php echo $data['event']; ?> 
What type of event is it: <?php echo $data['event_type']; ?> 

-- Requested Resources --
<?php
$resources = life_resource_entries();

foreach ( $data['qty'] as $resource_id => $qty ) {
	if ( ($qty > 0) && isSet($resources[$resource_id]) ) {
		echo "{$resources[$resource_id]['title']}: x{$qty}\n";
	}
}
?>


-- Other Comments --
<?php echo $data['comments'] ? $data['comments'] : '(No comments)'; ?>
