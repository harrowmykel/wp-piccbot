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


echo "<select id='mm' name='{$setting_id}[$id][month]'>";
foreach ( $option_values as $k => $v ) {
    echo "<option value='$k' " . selected( $options[ $id ]['month'], $k, false ) . ">$v</option>";
}
echo "</select>";

echo "<input id='jj' class='small-text' name='{$setting_id}[$id][day]' placeholder='".__('day','wp-piccbot')."' type='text' value='" . esc_attr( $options[ $id ]['day'] ) . "' />";

echo ',';
echo "<input id='aa' class='small-text' name='{$setting_id}[$id][year]' placeholder='".__('year','wp-piccbot')."'  type='text' value='" . esc_attr( $options[ $id ]['year'] ) . "' /><br>";
