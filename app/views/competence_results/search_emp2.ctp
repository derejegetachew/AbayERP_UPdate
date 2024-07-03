<?php 
header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + (60 * 60 * 24 * 3))); // 1 hour
//print_r($people);?>
{
	success:true,
	rows: [
<?php $st = false; foreach($people as $person){ if( in_array($person['e']['Record Id'] , $sub_ids )){ if($st) echo ","; $pre = ""; $post = ''; ?>	
        {
            "id":"<?php echo $person['e']['Record Id']; ?>",
            "full_name":"<?php echo $pre . $person['pp']['First Name'].' '.$person['pp']['Middle Name'].' '.$person['pp']['Last Name'] ?>",			
            "position":"<?Php echo $person['p']['Position'].' / '.$person['b']['Branch']; ?>",
			"photo":"<?Php
       // if($person['e']['photo']==''){
        if(true){
			if($person['pp']['sex']=='M'){
			   echo 'http://10.1.85.11/AbayERP/img/employee_photos/male.jpg';
                 }
            else{
			   echo 'http://10.1.85.11/AbayERP/img/employee_photos/female.jpg';
                 }
			}
			else echo 'http://10.1.85.11/AbayERP/img/employee_photos/'.$person['e']['photo']; ?>",
            "user_id":"<?Php echo $person['u']['user_id']; ?>"
        }
<?php $st = true; }} ?>		
        ]
}