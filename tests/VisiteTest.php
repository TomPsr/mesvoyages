<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests;

use App\Entity\Visite;
use DateTime;
use PHPUnit\Framework\TestCase;

/**
 * Description of VisiteTest
 *
 * @author tompa
 */
class VisiteTest extends TestCase{
    public function testGetDatecreationString() {
        $visite = new Visite();
        $visite->setDateCreation(new DateTime("2025-03-06"));
        $this->assertEquals("06/03/2025", $visite->getDatecreationString());
    }
}
