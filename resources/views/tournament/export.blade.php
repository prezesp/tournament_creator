<?php
$filename = str_replace(' ', '_', $tournament->name).'.txt';
header('Content-type: text/plain; charset=utf-8');
header('Content-Disposition: attachment; filename="'.$filename.'"');

function mb_str_pad($input, $pad_length, $pad_string = ' ', $pad_type = STR_PAD_RIGHT, $encoding = 'UTF-8')
{
    $input_length = mb_strlen($input, $encoding);
    $pad_string_length = mb_strlen($pad_string, $encoding);

    if ($pad_length <= 0 || ($pad_length - $input_length) <= 0) {
        return $input;
    }

    $num_pad_chars = $pad_length - $input_length;

    switch ($pad_type) {
        case STR_PAD_RIGHT:
            $left_pad = 0;
            $right_pad = $num_pad_chars;
            break;

        case STR_PAD_LEFT:
            $left_pad = $num_pad_chars;
            $right_pad = 0;
            break;

        case STR_PAD_BOTH:
            $left_pad = floor($num_pad_chars / 2);
            $right_pad = $num_pad_chars - $left_pad;
            break;
    }

    $result = '';
    for ($i = 0; $i < $left_pad; ++$i) {
        $result .= mb_substr($pad_string, $i % $pad_string_length, 1, $encoding);
    }
    $result .= $input;
    for ($i = 0; $i < $right_pad; ++$i) {
        $result .= mb_substr($pad_string, $i % $pad_string_length, 1, $encoding);
    }

    return $result;
}

?>

{{ $tournament->name."\r\n" }}
{{ $tournament->description."\r\n" }}
{{ $tournament->date."\r\n" }}

@foreach ($tournament->groups as $group)
{{ trans('tournament.group')." ".$group->name."\r\n" }}
<?php $pos = 0; ?>
@foreach ($group->ranking() as $rank)
<?php
    $v = [];
    $v[] = (++$pos).". ";
    $v[] = mb_str_pad($rank->team->name, 26 - count($rank->team->name));
    $v[] = $rank->game_count;
    $v[] = $rank->points;
    $v[] = $rank->balance_plus." - ".$rank->balance_minus;
    echo vsprintf("%-3s %s %-3d\t %-3d\t %-10s", $v)."\r\n";
?>
@endforeach

@foreach ($group->games as $game)
<?php
    $v = [];
    $home = empty($game->home) ? "no selected" : $game->home->name;
    $v[] = mb_str_pad($home, 30 - count($home));
    $res = $game->home_score." : ".$game->away_score;
    $v[] = mb_str_pad($res, 10 - count($res), " ", STR_PAD_BOTH);
    $away = empty($game->away) ? "no selected" : $game->away->name;
    $v[] = mb_str_pad($away, 30 - count($away));
    echo vsprintf("%s %s %s", $v)."\r\n";
?>
@endforeach



@endforeach

[ exported from {{ Config::get('app.url') }} ({{ date('Y-m-d H:i:s') }}) ]
