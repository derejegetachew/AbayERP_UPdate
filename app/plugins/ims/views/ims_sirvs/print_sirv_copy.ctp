<center>
    <img src="http://10.1.85.11/AbayERP/app/webroot/img/logo.png" />
    <!--<h2>ABAY BANK S.C</h2>-->
    <h1><U>Stock Issue & Receiving Voucher (SIRV)</U></h1>
</center>
<table border="0" width="100%">
    <tr>
	    <td> </td>
		<td> </td>
        <td  align="center">Date: <?php 
        echo date('d-M-Y', strtotime($sirv[0]['s']['created']));
       // echo var_dump($sirv);
         ?></td>
    </tr>
    <tr>
        <td align="left" valign="top" >Management / Branch: <u><?php		
						echo '&nbsp' . $sirv[0]['b']['branch'];?></u><br/>
            Requisition N<u>o</u>: <u><?php echo '&nbsp' . $sirv[0]['r']['req_name']; ?></u><br/>
        </td>
        <td align="left" valign="top">
            SIRV N<u>o</u>: <b><?php echo $sirv[0]['s']['name'];?> </b><br/>       
		
            Issued To: <b><?php echo $sirv[0][0]['full_name'];?> </b><br/>
        </td>  
    </tr>
</table>
<hr/>

<table width="100%" border="1">
    <tr bgcolor="#ccccdd">
        <th>N<u>o</u>.</th>
		<th>Code N<u>o</u>.</th>
        <th>Description</th>
        <th>Unit of Meas.</th>
        <th>Quantity</th>
        <th>Unit Price</th>
        <th>Total Price</th>
        <th>Remarks</th>
		<th>Serial</th>
    </tr>
    <?php $count = 0; $color = array(0 => 'dddddd', 1 => 'eeeeee'); $total_price = 0;
	
	$categories = $this->requestAction(
		array(
			'controller' => 'ims_sirvs', 
			'action' => 'getcategories')
	);
	for($i =0; $i< count($categories); $i++)
	{	
		$total_cost = 0;
		foreach ($categories [$i]['child'] as $child)
		{
  
			 foreach($sirv as $sirv_item) {		
			/*	
				$result = $this->requestAction(
								array(
									'controller' => 'ims_sirvs', 
									'action' => 'getitem'), 
								array('itemid' => $sirv_item['ims_item_id'])
							);
       */
				if($child['ImsItemCategory']['id'] == $sirv_item['ic']['cat_id']){
        $cat_name=$child['ImsItemCategory']['name'];
				$total_price += $sirv_item['si']['unit_price'] * $sirv_item['si']['quantity'];
				$total_cost += $sirv_item['si']['unit_price'] * $sirv_item['si']['quantity'];
			?>
			<tr bgcolor="#<?php echo $color[$count % 2]; ?>">
				<td><?php echo $count++ + 1; ?></td>
				<td><?php echo '<b><i>' . $sirv_item['i']['description'] . '</i></b>'; ?></td>
				<td><?php echo $sirv_item['i']['item_name'];  ?></td>
				<td><?php echo $sirv_item['si']['measurement']; ?></td>
				<td><?php echo $sirv_item['si']['quantity']; ?></td>
				<td align="right"><?php echo number_format( $sirv_item['si']['unit_price'] , 4 , '.' , ',' ); ?></td>
				<td align="right"><?php echo number_format( $sirv_item['si']['unit_price'] * $sirv_item['si']['quantity'] , 2 , '.' , ',' ); ?></td>
				<td><?php echo $sirv_item['si']['remark']; ?></td>
				<td><?php echo $sirv_item['si']['serial']; ?></td>
			</tr>
			<?php
				}
			} 
		}
		if($total_cost >0){
		?>
		<tr >
			<td colspan="6" align="right"><b><?php echo $cat_name .' ';?>Total Cost:</b></td>
			<td align="right" bgcolor="#A9F5E1"><?php echo number_format( $total_cost , 2 , '.' , ',' ); ?></td>
			<td>&nbsp;</td>
		</tr>
	<?php
	}
	}
	?>
    <tr bgcolor="#A9E2F3">
        <td colspan="6" align="right"><b>Over All Cost:</b></td>
        <td align="right"><b><?php echo number_format( $total_price , 2 , '.' , ',' ); ?></b></td>
        <td>&nbsp;</td>
    </tr>	
</table></br>
			Amount in words : <u> <?php
				$f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
				echo $f->format(number_format( $total_price , 2 , '.' , '' ));?></u>
<table width="100%">
	<tr></br>
		<td align="center">
		
		</td>
	</tr>	
</table>
<table width="90%">

<br/><br/>
	<tr>
		<td align="left"  ></br>
			Approved by:&nbsp;____________________</br>
      
			Signature:&nbsp;______________________
		</td>
		<td align="left" ></br>
			Delivered by:&nbsp;__________________</br>
      
			Signature:&nbsp;______________________
		</td>
		<td align="left" ></br>
			Received:&nbsp;___________________</br>
      
			Signature:&nbsp;____________________
		</td>
	