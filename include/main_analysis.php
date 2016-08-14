<?php
	
	if(isset($_POST['analysis'])){
		
		if(isset($_POST['age_s'])){
			$birth_s = date('Y-m-d', strtotime('-' . $_POST['age_s'] . ' year'));
			$birth_e = date('Y-m-d', strtotime('-' . $_POST['age_e'] . ' year'));
			$tmp = $birth_e; //BETWEEN need a low to high value 
			if($birth_s > $birth_e){
				$birth_e = $birth_s;
				$birth_s = $tmp;
			}
		}
		

		
		
		$sql = "SELECT t1.name, t1.user, t2.date, t2.product, t2.sum, t3.sum as area_sum
				FROM t_account as t1
				RIGHT JOIN
				(
					SELECT t1.user_id, t1.id as order_id, t1.date, SUM(t2.quantity * t2.price) as sum, GROUP_CONCAT(t3.product SEPARATOR '<br>') as product
					FROM t_order as t1
					RIGHT JOIN t_cart as t2
					ON t1.id = t2.order_id
					LEFT JOIN t_product as t3
					ON t2.product_id = t3.id
					WHERE t2.order_id > 0
					GROUP BY t1.id
					
				) as t2
				ON t1.id = t2.user_id
				
				
				LEFT JOIN
				(
					SELECT t1.user_id, SUM(t2.quantity * t2.price) as sum
					FROM t_order as t1
					RIGHT JOIN t_cart as t2
					ON t1.id = t2.order_id
					GROUP BY t1.user_id
				) as t3
				ON t1.id = t3.user_id
				
				WHERE TRUE"
				.(isset($_POST['g_'])? " AND gender_id IN (" . implode(',', $_POST['g_']) . ")": "")
				.(isset($_POST['j_'])? " AND job_id    IN (" . implode(',', $_POST['j_']) . ")": "")
				.(isset($_POST['t_'])? " AND title_id  IN (" . implode(',', $_POST['t_']) . ")": "")
				.(isset($_POST['i_'])? " AND income_id IN (" . implode(',', $_POST['i_']) . ")": "")
				.(isset($_POST['age_s'])? " AND birth BETWEEN '" . $birth_s . "' AND '" . $birth_e . "'": "")
				.(isset($_POST['sum'])? " AND t3.sum > '" . $_POST['sum'] . "'": "")
				." ORDER BY t1.id";
				
				
		$arr_list = $database->query($sql)->fetchAll();
		$result = "<table class='table'><tr>";
		$result .= "<th>姓名</th>";
		$result .= "<th>日期</th>";
		$result .= "<th>商品</th>";
		$result .= "<th>訂單金額</th>";
		$result .= "<th>個人總計</th>";
		$result .= "</tr>";
		if(!count($arr_list)) $result .= "<tr><td colspan='5'>找到0筆資料</td></tr>";
		foreach($arr_list as $item){
			$result .= "<tr>";
			$result .= "<td>" . $item['name'] . "(" . $item['user'] . ")</td>";
			$result .= "<td>" . $item['date'] . "</td>";
			$result .= "<td>" . $item['product'] . "</td>";
			$result .= "<td>" . $item['sum'] . "</td>";
			$result .= "<td>" . $item['area_sum'] . "</td>";
			$result .= "</tr>";
		}
		$result .= "</table>";
		
		echo $result;
		exit;
	}

	
	$arr_gender = $database->select('t_gender', '*');
	$arr_job = $database->select('t_job', '*');
	$arr_title = $database->select('t_title', '*');
	$arr_income = $database->select('t_income', '*');
?>
	
<div class='container-fluid'>
	<div class='row' style='height: 500px;overflow-y: scroll'>
		<div class='col-md-12 col-sm-12'>
			<h3>行為分析 <span class='label label-default'>Analysis</span></h3>
			<div class='panel panel-default'>
				<div class='panel-body'>
					說明: 請勾選或輸入要篩選的項目，系統將列出符合的資料。<strong>預設全選</strong><br/>
					<hr/>
					<form class='analysis' method='POST' action='./?m=main_analysis'>
						<table>
							<tr>
								<th class='col-md-2'>項目</th>
								<th class='col-md-10'>選項</th>
							</tr>
							<tr>
								<td>性別</td>
								<td>
									<?php foreach($arr_gender as $key=>$item): ?>
										<label class='col-xs-6 col-sm-3 col-md-3'><input name='g_[]' value='<?=$item['id']?>' type='checkbox'/><?=$item['alias']?></label>
									<?php endforeach;?>
								</td>
							</tr>
							<tr>
								<td>職業別</td>
								<td>
									<?php foreach($arr_job as $key=>$item): ?>
										<label class='col-xs-6 col-sm-3 col-md-3'><input name='j_[]' value='<?=$item['id']?>' type='checkbox'/><?=$item['alias']?></label>
									<?php endforeach;?>
								</td>
							</tr>
							<tr>
								<td>職稱</td>
								<td>
									<?php foreach($arr_title as $key=>$item): ?>
										<label class='col-xs-6 col-sm-3 col-md-3'><input name='t_[]' value='<?=$item['id']?>' type='checkbox'/><?=$item['alias']?></label>
									<?php endforeach;?>
								</td>
								</td>
							</tr>
							<tr>
								<td>年收入</td>
								<td>
									<?php foreach($arr_income as $key=>$item): ?>
										<label class='col-xs-6 col-sm-3 col-md-3'><input name='i_[]' value='<?=$item['id']?>' type='checkbox'/><?=$item['alias']?></label>
									<?php endforeach;?>
								</td>
							</tr>
							<tr>
								<td>年齡區間</td>
								<td>
									<select class='form-control input-sm' name='age_s'>
										<?php for($i = 1; $i <= 100; $i++): ?>
											<option value='<?=$i?>'><?=$i?></option>
										<?php endfor; ?>
									</select>
									<select class='form-control input-sm' name='age_e'>
										<?php for($i = 1; $i <= 100; $i++): ?>
											<option value='<?=$i?>' <?=($i==100)? 'selected="selected"': ''?>><?=$i?></option>
										<?php endfor; ?>
									</select>
								</td>
							</tr>
							<tr>
								<td>消費金額大於</td>
								<td>
									<input class='form-control input-sm' name='sum' placeholder='消費金額大於'/>
								</td>
							</tr>
							<tr>
								<td></td>
								<td>
									<input name='analysis' type='hidden'/>
									<button class='btn btn-default analysis' type='submit' data-loading-text='處理中...'>送出</button>
								</td>
							</tr>
						</table>
					</form>
				</div>
			</div>
		</div>
		
		<div class='col-md-12 col-sm-12 result'>
		</div>
	</div>
</div>


<script>
$(function(){
	

	$('form.analysis').submit(function(){
		
		$('button.analysis').button('loading');
		$.ajax({
			type: $(this).attr('method'),
			url: $(this).attr('action'),
			data: $(this).serialize(),
			success: function (re) {
				$('button.analysis').button('reset');
				//alert(re);
				$('div.result').empty().append(re);
			}
		});
		return false;
	});
	
});
</script>