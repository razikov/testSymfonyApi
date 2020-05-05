<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="heroes")
 */
class Hero
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string")
     */
    private $name;
    
    public function __construct(string $name)
    {
        Assert::notEmpty($name);
        Assert::greaterThan(strlen($name), 3);
        Assert::lessThan(strlen($name), 25);
        $this->name = $name;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setName($value)
    {
        Assert::notEmpty($value);
        Assert::greaterThan(strlen($value), 3);
        Assert::lessThan(strlen($value), 25);
        $this->name = $value;
        return $this;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
