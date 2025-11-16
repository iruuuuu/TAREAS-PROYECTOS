<?php 

class UserRepository
{
    public static function setAvatar($avatar, $user)
    {
        $db = Connection::connect();
        $q = "UPDATE users SET avatar = '" . $avatar . "' WHERE id = " . $user->getId();
        $db->query($q);
        return $db->affected_rows;
    }

    public static function register($user, $pw)
    {
        $db = Connection::connect();
        $q = "INSERT INTO users (username, password, roles) VALUES ('" . $user->getUsername() . "', md5('" . $pw . "'), 'user')";
        $db->query($q);
        return $db->insert_id;
    }

    public static function getUserById($id)
    {
        $db = Connection::connect();
        $q = "SELECT * FROM users WHERE id=" . $id;
        $result = $db->query($q);

        if ($row = $result->fetch_assoc()) {
            return new User($row['id'], $row['username'], $row['avatar'], $row['roles']);
        }
        return false;
    }

    public static function login($username, $password)
    {
        $db = Connection::connect();
        $password_md5 = md5($password);

        $q = "SELECT * FROM users WHERE username = '" . $username . "' AND password = '" . $password_md5 . "'";
        $result = $db->query($q);
        
        if ($userRow = $result->fetch_assoc()) {
            return $userRow;
        }
        return null;
    }
}