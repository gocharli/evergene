<div class="upgrade_to_premium">
	<?php if($this->membership_data->expire==true) { ?>
		<a href="<?=base_url('memberships')?>" class="tran3s custom-btn small-btn pull-right">Upgrade to Premium</a>
	<?php }else{
		$month_number=date('m');
		$year=date('Y');
		$available_orders=$this->db->query('select sum(detailQty) as total from order_details
        WHERE userId='.$this->session_data->userId.' AND regularType="One Time" 
        AND paymentType="Membership" AND YEAR(membershipDate)='.$year.'  AND MONTH(membershipDate)='.$month_number)->row();
		if($this->membership_data->orders>0)
		{

			if($available_orders)
			{
				$available_orders=$this->membership_data->orders-$available_orders->total;
			}
			else
			{
				$available_orders=$this->membership_data->orders;
			}
			if($available_orders<1)
			{
				$available_orders=0;
			}
		}
		else
		{
			$available_orders=0;
		}
		?>
		<a href="<?=base_url('orders')?>" class="tran3s custom-btn small-btn pull-right" style="line-height: 31px;">
			<span style="display: block;width: 100%;height: 20px;"><?=$available_orders?>/<?=$this->membership_data->orders?> orders this month </span>
			<span>Renewal Date : <?=date('Y-m-d',$this->membership_data->period_end)?></span>
		</a>
	<?php } ?>

</div>
