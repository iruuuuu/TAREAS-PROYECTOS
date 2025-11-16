<?php

use Proyect as GlobalProyect;

class ProyectRepository
{
    public static function create ($proyect) {
        $db = Connection::connect();
        $q = "INSERT INTO projects (name, description, datetime) VALUES ('" . $proyect->getName() . "', '" . $proyect->getDescription() . "', '" . $proyect->getDatetime() . "')";
        $db->query($q);
    }

    public static function delete ($id) {
        $db = Connection::connect();
        $q = "DELETE FROM projects WHERE id = " . $id;
        $db->query($q);
    }

    public static function getProyectById($id)
    {
        $db = Connection::connect();
        $q = "SELECT * FROM projects WHERE id=" . $id;
        $result = $db->query($q);

        if ($row = $result->fetch_assoc()) {
            return new Proyect($row['id'], $row['name'], $row['description'], $row['datetime']);
        }
        return null; // Devolver null si no se encuentra
    }

    public static function getProyects()
    {
        $db = Connection::connect();
        $q = "SELECT * FROM projects ORDER BY datetime DESC";
        $result = $db->query($q);
        
        $proyects = [];
        while ($row = $result->fetch_assoc()) {
            $proyects[] = new Proyect($row['id'], $row['name'], $row['description'], $row['datetime']);
        }
        
        return $proyects;
    }
}