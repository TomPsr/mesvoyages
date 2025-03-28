<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Validations;

use App\Entity\Visite;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Description of VisiteValidationsTest
 *
 * @author tompa
 */
class VisiteValidationsTest extends KernelTestCase {
    public function getVisite(): Visite{
        return (new Visite())
                ->setVille("New York")
                ->setPays("USA");
    }
    
    public function testValidNoteVisite() {
        $this->assertErrors($this->getVisite()->setNote(10), 0,"10 devrait réussir");
        $this->assertErrors($this->getVisite()->setNote(0), 0,"0 devrait réussir");
        $this->assertErrors($this->getVisite()->setNote(20), 0,"20 devrait réussir");
    }
    
    public function testNonValidNoteVisite(){
        $this->assertErrors($this->getVisite()->setNote(25), 1,"25 devrait échouer");
        $this->assertErrors($this->getVisite()->setNote(-1), 1,"-1 devrait échouer");
        $this->assertErrors($this->getVisite()->setNote(21), 1,"21 devrait échouer");
        $this->assertErrors($this->getVisite()->setNote(-5), 1,"-5 devrait échouer");
    }

    public function testNonValidTempmaxVisite(){
        $this->assertErrors($this->getVisite()->setTempmin(12)->setTempmax(7), 1, "min=12, max=7 devrait échouer");
        $this->assertErrors($this->getVisite()->setTempmin(27)->setTempmax(7), 1, "min=27, max=7 devrait échouer");
        $this->assertErrors($this->getVisite()->setTempmin(7)->setTempmax(7), 1, "min=7, max=7 devrait échouer");
    }

    public function testValidTempmaxVisite(){
        $this->assertErrors($this->getVisite()->setTempmin(4)->setTempmax(20), 0, "min=4, max=20 devrait réussir");
        $this->assertErrors($this->getVisite()->setTempmin(12)->setTempmax(13), 0, "min=12, max=13 devrait réussir");
    }
    
    public function testValidDatecreationVisite(){ 
        $aujourdhui = new \DateTime();
        $this->assertErrors($this->getVisite()->setDatecreation($aujourdhui), 0, "aujourd'hui devrait réussir");
        $plustot = (new \DateTime())->sub(new \DateInterval("P5D"));
        $this->assertErrors($this->getVisite()->setDatecreation($plustot), 0, "plus tôt devrait réussir");
    }

    public function testNonValidDatecreationVisite(){ 
        $demain = (new \DateTime())->add(new \DateInterval("P1D"));
        $this->assertErrors($this->getVisite()->setDatecreation($demain), 1, "demain devrait échouer");
        $plustard = (new \DateTime())->add(new \DateInterval("P5D"));
        $this->assertErrors($this->getVisite()->setDatecreation($plustard), 1, "plus tard devrait échouer");
    }    
    public function assertErrors(Visite $visite, int $nbErreursAttendues, string $message="") {
        self::bootKernel();
        $validator = self::getContainer()->get(ValidatorInterface::class);
        $error = $validator->validate($visite);
        $this->assertCount($nbErreursAttendues, $error, $message);
    }
}
