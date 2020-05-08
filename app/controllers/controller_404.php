<?php
Class Controller_404 extends Controller{
    public function action_index()
    {
        $this->view->gen('404_view','main_view');
    }
}
