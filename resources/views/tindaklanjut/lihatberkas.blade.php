<?php
			$decoded = base64_decode($berkas->data);
			$d = bin2hex($decoded);
			


?>
<object data=<?php echo $d; ?> type='application/pdf' class='col-xs-12' style='height:667px' >
</object>
        