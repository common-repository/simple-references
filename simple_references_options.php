<?php

//start settings page
function fnp_options() {

if ( ! isset( $_REQUEST['updated'] ) )
$_REQUEST['updated'] = false;
?>

<div>

<div id="icon-options-general"></div>
<h2><?php _e( 'References Settings' ) //your admin panel title ?></h2>

<?php
//show saved options message
if ( false !== $_REQUEST['updated'] ) : ?>
<div><p><strong><?php _e( 'Options saved' ); ?></strong></p></div>
<?php endif; ?>

<form method="post" action="options.php">

<?php settings_fields( 'fnp_options' ); ?>
<?php 
	$options = get_option( 'fnp_options' ); 
	$use_tags = (isset($options['use_tags']) ? $options['use_tags'] : false);
	$use_cats = (isset($options['use_cats']) ? $options['use_cats'] : false);
?>

<table>

<!-- Option 1: Use Tags of your references -->
<tr valign="top">
<th scope="row"><?php _e( 'Use Tags' ); ?></th>
<td>
<?php echo $use_tags ?>
	<input id="fnp_options[use_tags]" name="fnp_options[use_tags]" type="checkbox" <?php if(!empty($use_tags)) echo "checked";?>/>
</td>
</tr>

<!-- Option 1: Use Cats of your references -->
<tr valign="top">
<th scope="row"><?php _e( 'Use Categories' ); ?></th>

	<td><?php echo $use_cats ?><input id="fnp_options[use_cats]" name="fnp_options[use_cats]" type="checkbox"  <?php if(!empty($use_cats)) echo "checked";?>/></td>
</tr>

</table>

<p><input name="submit" id="submit" value="Save Changes" type="submit"></p>
</form>

</div><!-- END wrap -->

<?php
}
//sanitize and validate
function options_validate( $input ) {
    return $input;
}
?>