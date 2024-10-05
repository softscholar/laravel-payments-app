<?php

function flashMessage($title, $message, $type = 'success'): void
{
    session()->flash('flash', [
        'title' => $title,
        'message' => $message,
        'type' => $type
    ]);
}
