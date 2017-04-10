<?php
$filename = str_replace(' ', '_', $tournament->name).'-groups.csv';
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="'.$filename.'"');

// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// output the column headings
fputcsv($output, array('pos', 'team', 'g', 'pts', '+', '-'));


// loop over the rows, outputting them
//while ($row = mysql_fetch_assoc($rows)) fputcsv($output, $row);

?>
@foreach ($tournament->groups as $group)

<?php $pos = 0; ?>
@foreach ($group->ranking() as $rank)
<?php
    $v = [];
    $v[] = (++$pos);
    $v[] = $rank->team->name;
    $v[] = $rank->game_count;
    $v[] = $rank->points;
    $v[] = $rank->balance_plus;
    $v[] = $rank->balance_minus;
    fputcsv($output, $v);
?>
@endforeach
@endforeach

<?php
fputcsv($output, array("[ exported from ".Config::get('app.url')." (".date('Y-m-d H:i:s').") ]", "", "", ""));
?>
