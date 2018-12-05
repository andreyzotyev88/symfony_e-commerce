<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\Product;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $first_name = array("Розовый","Королевский","Черный","Большой","Великолепный","Странный","Веселый","Удачный","Чертов"  );
        $second_name = array("чайник","пылесос","автомобиль","лось","лосось","мистер шляп","креветко");
        $description = array(
            "Простой ключ. Если поле содержит уникальные значения, такие как коды или инвентарные номера, то это поле можно определить как первичный ключ. В качестве ключа можно определить любое поле, содержащее данные, если это поле не содержит повторяющиеся значения или значения Null.",
            "Составной ключ. В случаях, когда невозможно гарантировать уникальность значений каждого поля, существует возможность создать ключ, состоящий из нескольких полей. Чаще всего такая ситуация возникает для таблицы, используемой для связывания двух таблиц многие - ко - многим.",
            "Программы, которые предназначены для структурирования информации, размещения ее в таблицах и манипулирования данными называются системами управления базами данных (СУБД): MS SQL Server, Oracle, Informix, Sybase, DB2, MS Access и т. д.");
        for ($i = 0 ; $i<20 ; $i++){
            $product[$i] = new Product();
            $product[$i]->setName($first_name[array_rand($first_name)]." ".$second_name[array_rand($second_name)]);
            $product[$i]->setDescription($description[array_rand($description)]);
            $product[$i]->setPrice(rand(10,100)*1000);
            $manager->persist($product[$i]);
        }
        $manager->flush();
    }
}
