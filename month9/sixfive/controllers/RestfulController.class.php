<?php
namespace controllers;



class RestfulController
{
    public function Index()
    {
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        switch ($method){
            case 'get':
                $this->lists();
                break;
            case 'post':
                $this->store();
                break;
            case 'put':
                $this->save();
                break;
            case 'delete':
                $this->delete();
                break;
            default:
                $this->defaults();
        }
    }

    protected function defaults(){

    }
}