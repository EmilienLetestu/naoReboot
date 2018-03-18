<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 07/11/2017
 * Time: 17:26
 */

namespace App\Services;

class HomeImg
{

    /**
     * @return array
     */
    public function getHomeImage()
    {
        $dir = '../public/naoPictures';
        $dirContent = scandir($dir);

        //remove '.' and '..' from array and return file name
        return  array_splice($dirContent,2);
    }

    /**
     * find image inside directory based on picture position from 1 to 3 (inside html)
     * return an array with up to 2 keys
     * => picture array key = picture position - 1
     * @param $pictNum
     * @return bool
     */
    public function deletePreviousHomeImage($pictNum)
    {
        //get pictures from directory
        $pictureContent = $this->getHomeImage();

        return unlink("../public/naoPictures/{$pictureContent[$pictNum-1]}");
    }

}

