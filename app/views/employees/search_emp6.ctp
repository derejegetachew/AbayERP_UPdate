<?php 
header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + (60 * 60 * 24 * 3))); // 1 hour
//print_r($people);?>
{
	success:true,
	rows: [
<?php $st = false; foreach($people as $person){ if($st) echo ","; $pre = ""; $post = ''; ?>	
        {
            "id":"<?php echo $person['viewemployee']['Record Id']; ?>",
            "full_name":"<?php echo $pre . $person['viewemployee']['First Name'].' '.$person['viewemployee']['Middle Name'].' '.$person['viewemployee']['Last Name'].' ('.$person['viewemployee']['Card'] . ')'.$post; ?>",			
            "position":"<?Php echo $person['viewemployement']['Position'].' / '.$person['viewemployement']['Branch']; ?>",
            "user_id":"<?Php echo $person['viewemployee']['user_id']; ?>"
        }
<?php $st = true; } ?>		
        ]
}