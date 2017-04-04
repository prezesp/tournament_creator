<?php
$current_lang = App::getLocale() == null ? 'en' : App::getLocale();

$languages = array('en', 'es', 'pl');
$languages = array_diff($languages, array($current_lang));

?>

<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
        {{ Html::image('img/flags/'.$current_lang.'.png') }} {{ strtoupper($current_lang) }}<span class="caret"></span>
    </a>

    <ul class="dropdown-menu" role="menu">
      @foreach($languages as $lang)
        <li>
            <a href="{{ url('locale/'.$lang) }}">
                {{ Html::image('img/flags/'.$lang.'.png') }} {{ strtoupper($lang) }}
            </a>
        </li>
      @endforeach
    </ul>
</li>
