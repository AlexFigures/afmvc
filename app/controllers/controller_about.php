<?php

class Controller_about extends Controller
{
    function action_index() {
        $this->view->gen('about_view', 'main_view');
    }
}