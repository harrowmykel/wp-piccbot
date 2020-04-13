<?php
// {$setting_id}[$id] - Contains the setting id, this is what it will be stored in the db as.
// $class - optional class value
// $id - setting id
// $options[$id] value from the db

$option_values = array(
	'01'=>__('01-Jan','picc-bot'),
	'02'=>__('02-Feb','picc-bot'),
	'03'=>__('03-Mar','picc-bot'),
	'04'=>__('04-Apr','picc-bot'),
	'05'=>__('05-May','picc-bot'),
	'06'=>__('06-Jun','picc-bot'),
	'07'=>__('07-Jul','picc-bot'),
	'08'=>__('08-Aug','picc-bot'),
	'09'=>__('09-Sep','picc-bot'),
	'10'=>__('10-Oct','picc-bot'),
	'11'=>__('11-Nov','picc-bot'),
	'12'=>__('12-Dec','picc-bot'),
	);


echo "<select id='mm' name='{$setting_id}[$id][month]'>";
foreach ( $option_values as $k => $v ) {
    echo "<option value='$k' " . selected( $options[ $id ]['month'], $k, false ) . ">$v</option>";
}
echo "</select>";

echo "<input id='jj' class='small-text' name='{$setting_id}[$id][day]' placeholder='".__('day','picc-bot')."' type='text' value='" . esc_attr( $options[ $id ]['day'] ) . "' />";

echo ',';
echo "<input id='aa' class='small-text' name='{$setting_id}[$id][year]' placeholder='".__('year','picc-bot')."'  type='text' value='" . esc_attr( $options[ $id ]['year'] ) . "' /><br>";
