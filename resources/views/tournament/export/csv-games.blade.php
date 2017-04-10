<?php
$filename = str_replace(' ', '_', $tournament->name).'-games.csv';
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="'.$filename.'"');

// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// output the column headings
fputcsv($output, array('home', 'home_score', 'away_score', 'away'));


// loop over the rows, outputting them
//while ($row = mysql_fetch_assoc($rows)) fputcsv($output, $row);

?>
@foreach ($tournament->groups as $group)

@foreach ($group->games as $game)
<?php
    $v = [];
    $v[] = empty($game->home) ? 'no selected' : $game->home->name;
    $v[] = $game->home_score;
    $v[] = $game->away_score;
    $v[] = empty($game->away) ? 'no selected'  : $game->away->name;
    fputcsv($output, $v);
?>
@endforeach
@endforeach

@foreach ($tournament->playoff() as $stage => $games)

@foreach ($games as $game)
<?php
    $v = [];
    $v[] = empty($game->home) ? 'no selected' : $game->home->name;
    $v[] = $game->home_score;
    $v[] = $game->away_score;
    $v[] = empty($game->away) ? 'no selected' : $game->away->name;
    fputcsv($output, $v);
?>
@endforeach
@endforeach

<?php
fputcsv($output, array("[ exported from ".Config::get('app.url')." (".date('Y-m-d H:i:s').") ]", "", "", ""));
?>
