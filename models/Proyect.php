<?php 

class Proyect
{
    private $id;
    private $name;
    private $description;
    private $datetime;

    public function __construct($id, $name, $description, $datetime)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->datetime = $datetime;
    }

    public function getId()
    {
        return $this->id;
    }


    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getDatetime()
    {
        return $this->datetime;
    }

    public function __toString()
    {
        return $this->name;
    }
}
