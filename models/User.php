<?php
class User
{
    private $id;
    private $username;
    private $avatar;
    private $roles;

    public function __construct($id, $username, $avatar, $roles)
    {
        $this->username = $username;
        $this->id = $id;
        $this->avatar = $avatar;
        $this->roles = $roles;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }
    public function getRoles()
    {
        return $this->roles;
    }
    public function __toString()
    {
        return $this->username;
    }
}
