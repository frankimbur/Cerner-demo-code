<?php
	include 'FHIRApi.php';
	$res = array();
	if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'Search') {
		$FHIRApi = new FHIRApi();
		$params = array();
		$params['lastname'] = $_REQUEST['lastname'];
		$params['firstname'] = $_REQUEST['firstname'];

		$res = $FHIRApi->FHIRFindPatientsUsingName($params);		
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Cerner Demo</title>
</head>
<body>
	<div style="width:100%; float: left;">
		<div style="width:21%;float: left;border: 1px solid;padding: 10px;">
			<form action='' method="GET">
				<div style="margin:8px;">
					<label>Patient FirstName : </label>
					<input type="input" name="firstname">
				</div>
				<div style="margin:8px;">
					<label>Patient LastName : </label>
					<input type="input" name="lastname">
				</div>

				<div style="margin:8px;">
					<input type="submit" name="submit" value="Search">
				</div>
			</form>		
		</div>
	</div>
	<?php if (!empty($res)) { ?>
		<div>
			<?php foreach ($res['entry'] as $r) { ?>
					<div style="float: left;border: 1px solid #000;padding: 5px;width: auto;margin:5px;height: 210px;">
						<?php 
							echo "<pre>";
							print_r($r['resource']['text']['div']); 
						?>
					</div>	
			<?php } ?>
		</div>
	<?php } ?>
</body>
</html>