<?php

namespace App\DataFixtures;

use App\Entity\News;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class NewsFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $first_name = array("Розовый","Королевский","Черный","Большой","Великолепный","Странный","Веселый","Удачный","Чертов"  );
        $second_name = array("чайник","пылесос","автомобиль","лось","лосось","мистер шляп","креветко");
        $third_name = array("ушел","забыл","удивил","купил");
        $four_name = array("Россию","Москву","ВВ.Путина","мир");
        $symlink = array("sym","link","value","result","offset");
        $description = array(
            "Простой ключ. Если поле содержит уникальные значения, такие как коды или инвентарные номера, то это поле можно определить как первичный ключ. В качестве ключа можно определить любое поле, содержащее данные, если это поле не содержит повторяющиеся значения или значения Null.",
            "Составной ключ. В случаях, когда невозможно гарантировать уникальность значений каждого поля, существует возможность создать ключ, состоящий из нескольких полей. Чаще всего такая ситуация возникает для таблицы, используемой для связывания двух таблиц многие - ко - многим.",
            "Программы, которые предназначены для структурирования информации, размещения ее в таблицах и манипулирования данными называются системами управления базами данных (СУБД): MS SQL Server, Oracle, Informix, Sybase, DB2, MS Access и т. д.");
        for ($i = 0 ; $i<20 ; $i++){
            $product[$i] = new News();
            $product[$i]->setTitle($first_name[array_rand($first_name)]." ".$second_name[array_rand($second_name)]." ".$third_name[array_rand($third_name)]." ".$four_name[array_rand($four_name)]);
            $product[$i]->setSymlink($symlink[array_rand($symlink)]."_".$symlink[array_rand($symlink)]."_".$symlink[array_rand($symlink)]."_".$symlink[array_rand($symlink)]);
            $product[$i]->setDescription("<p>".$description[array_rand($description)]."</p>"."<p>".$description[array_rand($description)]."</p>"."<p>".$description[array_rand($description)]."</p>"."<p>".$description[array_rand($description)]."</p>");
            $product[$i]->setDateUpdate(new \DateTime("now"));
            $product[$i]->setActive(true);
            $manager->persist($product[$i]);
        }
        $manager->flush();
    }
}
