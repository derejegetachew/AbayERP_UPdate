<center>
	<img src="http://10.1.85.11/AbayERP/app/webroot/img/logo.png" />
    <!--<h2>ABAY BANK S.C</h2>-->
    <h1>GOODS RECEIVING NOTE (GRN)</h1>
</center>
<table border="0" width="100%">
    <tr>
		<td></td>
		<td></td>
		<td></td>
        <td  align="center">Date: <?php date_default_timezone_set("Africa/Addis_Ababa"); echo date('d-m-Y '); ?></td>
    </tr>
	<tr>
		<td colspan="4" align ="left"><b>Supplier: <?php echo $grn['ImsSupplier']['name'];?></b></td>
	</tr>
    <tr>		
        <td colspan="1" style="padding:0 0 0 55px;" valign="top"></br>
            Supplier's Invoice N<u>o</u>.: ......................................................&nbsp;&nbsp;&nbsp;
			GRN N<u>o</u>.: <b><?php echo $grn['ImsGrn']['name'];?> </b><br/>
            Purchase order N<u>o</u>.: <b><?php echo $grn['ImsPurchaseOrder']['name'];?> </b><br/>
			Purchase Requisition N<u>o</u>.: ...................................................................
        </td>        
    </tr>    
</table>
<hr/>

<table width="100%" border="1">
    <tr bgcolor="#ccccdd">
        <th>N<u>o</u>.</th>
		<th>Item Code</th>
        <th>Name</th>
        <th>Unit of Measure</th>
        <th>Quantity</th>
        <th>Unit Price</th>
        <th>Total Price</th>
        <th>Remarks</th>
    </tr>	
    <?php $count = 0; $color = array(0 => 'dddddd', 1 => 'eeeeee'); $total_price = 0; ?>
    <?php foreach($grn['ImsGrnItem'] as $grn_item) {
	$total_price += $grn_item['unit_price'] * $grn_item['quantity']; 
	
	$poItem = $this->requestAction(
								array(
									'controller' => 'ims_grns', 
									'action' => 'getpoitem'), 
								array('poitemid' => $grn_item['ims_purchase_order_item_id'])
							);	
							
	$result = $this->requestAction(
								array(
									'controller' => 'ims_grns', 
									'action' => 'getitem'), 
								array('itemid' => $poItem['ims_item_id'])
							);
							
				
							?>
    <tr bgcolor="#<?php echo $color[$count % 2]; ?>">
        <td><?php echo $count++ + 1; ?></td>
		<td><?php echo $result['description'];?></td>
        <td><?php echo $result['name']?></td>
        <td><?php echo $poItem['measurement']; ?></td>
        <td><?php echo $grn_item['quantity']; ?></td>
        <td align="right"><?php echo number_format( $grn_item['unit_price'] , 4 , '.' , ',' ); ?></td>
        <td align="right"><?php echo number_format( $grn_item['unit_price'] * $grn_item['quantity'] , 2 , '.' , ',' ); ?></td>
        <td><?php echo $grn_item['remark']; ?></td>
    </tr>
    <?php } ?>
    <tr bgcolor="#<?php echo $color[$count % 2]; ?>">
        <td colspan="6" align="right"><b>Total:</b></td>
        <td align="right"><?php echo number_format( $total_price , 2 , '.' , ',' ); ?></td>
        <td>&nbsp;</td>
    </tr>
</table>
<table>
	<tr>
		<td align="left" colspan ="2"></br>
			Amount in words : <u> <?php
			
				$f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
				echo $f->format(number_format( $total_price , 2 , '.' , '' ));
				
				$createdUser = $this->requestAction(
								array(
									'controller' => 'ims_grns', 
									'action' => 'getuser'), 
								array('userid' => $grn['ImsGrn']['created_by'])
							);
							
				$approvedUser = $this->requestAction(
								array(
									'controller' => 'ims_grns', 
									'action' => 'getuser'), 
								array('userid' => $grn['ImsGrn']['approved_by'])
							);
				
				?></u></br></br></br>
				
			I have received the above items in good order.
		</td>
	</tr>
	<tr>
		<td align="left" style="padding:0 0 0 55px;"></br>
			Prepared by:<?php echo ' '.$createdUser['Person']['first_name'].' '.$createdUser['Person']['middle_name']?><br/>
			Signature:.......................................
		</td>
		<td align="left" style="padding:0 0 0 105px;"></br>
			Store Keeper:.....................................<br/>
			Signature:.......................................
		</td>
	</tr>
	<tr>
		<td align="left" style="padding:0 0 0 55px;"></br>
			Inspected by:.......................................<br/>
			Signature:.......................................
		</td>
		<td align="left" style="padding:0 0 0 105px;"></br>
			Approved by:<?php echo ' '.$approvedUser['Person']['first_name'].' '.$approvedUser['Person']['middle_name']?><br/>
			Signature:.......................................
		</td>
	</tr>
</table>

<br/><br/>

<b align="left"><font color="blue">Adjustment</font></b>
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
    </tr>
    <?php $count = 0; $color = array(0 => 'dddddd', 1 => 'eeeeee'); $total_price = 0;
	
	
		$total_cost = 0;
			 foreach($grnArray as $grn_item) {					
				
						
				$poItem = $this->requestAction(
								array(
									'controller' => 'ims_grns', 
									'action' => 'getpoitem'), 
								array('poitemid' => $grn_item['ims_purchase_order_item_id'])
							);	
							
				$result = $this->requestAction(
								array(
									'controller' => 'ims_grns', 
									'action' => 'getitem'), 
								array('itemid' => $poItem['ims_item_id'])
							);
				
					
					$total_price += $grn_item['unit_price'] * $grn_item['quantity'];
				?>
					<tr bgcolor="#<?php echo $color[$count % 2]; ?>">
						<td><?php echo $count++ + 1; ?></td>
						<td><?php echo '<b><i>' . $result['description'] . '</i></b>'; ?></td>
						<td><?php echo $result['name'];  ?></td>
						<td><?php echo $poItem['measurement']; ?></td>
						<td><?php echo $grn_item['quantity']; ?></td>
						<td align="right"><?php echo number_format( $grn_item['unit_price'] , 2 , '.' , ',' ); ?></td>
						<td align="right"><?php echo number_format( $grn_item['unit_price'] * $grn_item['quantity'] , 2 , '.' , ',' ); ?></td>
						<td><?php echo $grn_item['remark']; ?></td>
					</tr>
				<?php
			
		} 
		
	?>
    <tr bgcolor="#A9E2F3">
        <td colspan="6" align="right"><b>Over All Cost:</b></td>
        <td align="right"><b><?php echo number_format( $total_price , 2 , '.' , ',' ); ?></b></td>
        <td>&nbsp;</td>
    </tr>
</table>