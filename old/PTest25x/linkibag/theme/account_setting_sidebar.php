<div class="col-md-3 col-xs-12 col-sm-12 lft">
	<div class="account_setting_sidebar">
		<div class="welcome-name">
			<h2>Hi, <?php echo $current['first_name']?></h2>
		</div>
		
		<div class="left-links">
			<?php /*
			<p><a href="index.php?p=renew"<?=((isset($_GET['p']) and $_GET['p'] == 'renew') ? ' class="active"' : '')?>>Account Management</a></p>
			*/ ?>
			<?php /*if(!($current['role'] == 1)){*/ ?>
			<p><a href="index.php?p=account_settings"<?=((isset($_GET['p']) and $_GET['p'] == 'account_settings') ? ' class="active"' : '')?>>Account Settings</a></p>
			<?php /*}*/ ?>
			<p><a href="index.php?p=edit-profile"<?=((isset($_GET['p']) and $_GET['p'] == 'edit-profile') ? ' class="active"' : '')?>>Edit Profile</a></p>
			<p><a href="index.php?p=close-account"<?=((isset($_GET['p']) and $_GET['p'] == 'close-account') ? ' class="active"' : '')?>>Close Account</a></p>
		</div>
		
		<!-- Provides extra visual weight and identifies the primary action in a set of buttons -->
		<a href="index.php?p=contact-us" class="btn advertise">Advertise with LinkiBag</a>
	</div>
</div>	