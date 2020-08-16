<?php
namespace App\Service;

class BaseService{
    /**
     * @param $typeEvenement
     * @return array
     * Cle valeur pour formulaire
     * @throws \ReflectionException
     */
    public function cleValeurTypeEvenement($typeEvenement,$method){
        $instanceof = new \ReflectionClass(get_class($typeEvenement[0]));
        $method = $instanceof->getMethod($method)->name;
       /* dd($method);*/
        $res = [];

        foreach ($typeEvenement as $key=>$value){
            $res[$value->{$method}()] = $value->getid();
        }
        //dd($res);
        return $res;
    }
}