<?php
 session_start();

include_once( 'config.php' );
include_once( 'saetv2.ex.class.php' );

$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $_SESSION['token']['access_token'] );

function get_user_info($c){
	$uid_get = $c->get_uid();
	$uid = $uid_get['uid'];
	return $user_info = $c->show_user_by_id( $uid);
}

function get_mentions_messages($c, $count = 50){
	$msg = $c->mentions(1,$count);
	$messages = array();
	foreach($msg['statuses'] as $data)
	{
		array_push($messages, $data['user']['screen_name']."   :   ".$data['text']);
	}
	return $messages;
}

function refresh_mentions_messages($c, $count){
		$messages = get_mentions_messages($c,$count);
		foreach($messages as $message)
		{
			echo "<div style='padding:10px;margin:5px;border:1px solid #ccc'>$message</div>";
		}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mini Away Day in Xi'an</title>
<script src="jquery-1.7.1.min.js"></script>
<script>
	$(document).ready(function() {
		setInterval(function() {
			$.ajax({
				url: '/liveshow/weibolist.php',
				success: function(data) {
					console.log('get data');
					$('body').html(data);
				}
			})
		}, 30000);
	});
</script>
</head>

<body>
	
	<?php 
		refresh_mentions_messages($c, 10);
	?>
</body>
</html>
