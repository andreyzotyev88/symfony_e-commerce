<?php

namespace App\Service;

class StringConvertor
{
    public function tableNameToFullPath($bundleName,$folderName,$tableName,$preffix = ""): ?string
    {
        if (isset($bundleName) && isset($tableName)) {
            return $bundleName . "\\".$folderName."\\" . $this->firstSymbolUppercase($tableName).$preffix;
        }else{
            return "";
        }
    }

    private function firstSymbolUppercase($string): ?string
    {
        return strtoupper(substr($string,0,1)).strtolower(substr($string,1));
    }
}