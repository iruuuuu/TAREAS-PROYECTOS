<?php 


class ProyectRepositoy
{    
    public function create ($proyect) {
        $db = Connection::connect();
        $q = "INSERT INTO projects (name, description, datetime) VALUES (?,?,?)";
        $query = $db->prepare($q);
        $query->execute([$proyect->getName(), $proyect->getDescription(), $proyect->getDatetime()]);
    }


    public function delete ($id) {
        $db = Connection::connect();
        $q = "DELETE FROM projects WHERE id = ?";
        $query = $db->prepare($q);
        $query->execute([$id]);
    }

    public static function getProyectById ($id) {
        $db = Connection::connect();
        // Corregido para usar sentencias preparadas y el nombre de tabla correcto
        $q = $db->prepare("SELECT * FROM projects WHERE id = ?");
        $q->bind_param("i", $id);
        $q->execute();
        $result = $q->get_result();

        if ($row = $result->fetch_assoc()) {
            return new Proyect($row['id'], $row['name'], $row['description'], $row['datetime']);
        }
        return null;
    }
}   