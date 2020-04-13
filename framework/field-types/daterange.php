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

_e('Start Date', 'picc-bot');
echo "<select id='mm' name='{$setting_id}[$id][start_month]'>";
foreach ( $option_values as $k => $v ) {
    echo "<option value='$k' " . selected( $options[ $id ]['start_month'], $k, false ) . ">$v</option>";
}
echo "</select>";

echo "<input id='jj' class='small-text' placeholder='".__('day','picc-bot')."' name='{$setting_id}[$id][start_day]' type='text' value='" . esc_attr( $options[ $id ]['start_day'] ) . "' />";

echo ',';
echo "<input id='aa' class='small-text' placeholder='".__('year','picc-bot')."' name='{$setting_id}[$id][start_year]' type='text' value='" . esc_attr( $options[ $id ]['start_year'] ) . "' />";

echo '&nbsp;&nbsp;&nbsp;&nbsp;';
_e('End Date', 'picc-bot');
echo "<select id='mm' name='{$setting_id}[$id][end_month]'>";
foreach ( $option_values as $k => $v ) {
    echo "<option value='$k' " . selected( $options[ $id ]['end_month'], $k, false ) . ">$v</option>";
}
echo "</select>";

echo "<input id='jj' class='small-text' placeholder='".__('day','picc-bot')."' name='{$setting_id}[$id][end_day]' type='text' value='" . esc_attr( $options[ $id ]['end_day'] ) . "' />";

echo ',';
echo "<input id='aa' class='small-text' placeholder='".__('year','picc-bot')."' name='{$setting_id}[$id][end_year]' type='text' value='" . esc_attr( $options[ $id ]['end_year'] ) . "' /><br>";

