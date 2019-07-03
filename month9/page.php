<?php

class Page
{
    protected $pagenums;
    protected $now_page;
    public function GetPage($total,$pagesize)
    {
        $this->pagenums = ceil($total/$pagesize);
        $this->setPage();
    }
    private function setPage($p = 1)
    {
        $p = isset($_GET['p']) ? intval($_GET['p']) : 1 ;
        $p = $p < 1 ? 1 : $p ;
        if($p > $this->pagenums){
            $p = $this->pagenums;
        }
        $this->now_page = $p;
    }

}