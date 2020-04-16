<?php
// {$setting_id}[$id] - Contains the setting id, this is what it will be stored in the db as.
// $class - optional class value
// $id - setting id
// $options[$id] value from the db

$option_values = array(
	'01'=>__('01-Jan','wp-piccbot'),
	'02'=>__('02-Feb','wp-piccbot'),
	'03'=>__('03-Mar','wp-piccbot'),
	'04'=>__('04-Apr','wp-piccbot'),
	'05'=>__('05-May','wp-piccbot'),
	'06'=>__('06-Jun','wp-piccbot'),
	'07'=>__('07-Jul','wp-piccbot'),
	'08'=>__('08-Aug','wp-piccbot'),
	'09'=>__('09-Sep','wp-piccbot'),
	'10'=>__('10-Oct','wp-piccbot'),
	'11'=>__('11-Nov','wp-piccbot'),
	'12'=>__('12-Dec','wp-piccbot'),
	);

_e('Start Date', 'wp-piccbot');
echo "<select id='mm' name='{$setting_id}[$id][start_month]'>";
foreach ( $option_values as $k => $v ) {
    echo "<option value='$k' " . selected( $options[ $id ]['start_month'], $k, false ) . ">$v</option>";
}
echo "</select>";

echo "<input id='jj' class='small-text' placeholder='".__('day','wp-piccbot')."' name='{$setting_id}[$id][start_day]' type='text' value='" . esc_attr( $options[ $id ]['start_day'] ) . "' />";

echo ',';
echo "<input id='aa' class='small-text' placeholder='".__('year','wp-piccbot')."' name='{$setting_id}[$id][start_year]' type='text' value='" . esc_attr( $options[ $id ]['start_year'] ) . "' />";

echo '&nbsp;&nbsp;&nbsp;&nbsp;';
_e('End Date', 'wp-piccbot');
echo "<select id='mm' name='{$setting_id}[$id][end_month]'>";
foreach ( $option_values as $k => $v ) {
    echo "<option value='$k' " . selected( $options[ $id ]['end_month'], $k, false ) . ">$v</option>";
}
echo "</select>";

echo "<input id='jj' class='small-text' placeholder='".__('day','wp-piccbot')."' name='{$setting_id}[$id][end_day]' type='text' value='" . esc_attr( $options[ $id ]['end_day'] ) . "' />";

echo ',';
echo "<input id='aa' class='small-text' placeholder='".__('year','wp-piccbot')."' name='{$setting_id}[$id][end_year]' type='text' value='" . esc_attr( $options[ $id ]['end_year'] ) . "' /><br>";

