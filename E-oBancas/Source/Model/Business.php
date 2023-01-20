<?php

namespace Source\Model;

class Business {
    private $id;
    private $name;
    private $slogan;
    private $worth;
    private $founder;
    private $color;
    private $db;


    public function __construct(
        int $id = NULL,
        string $name = NULL, 
        string $slogan = NULL,
        int $worth = NULL,
        string $founder = NULL,
        string $color = NULL,
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->slogan = $slogan;
        $this->worth = $worth;
        $this->founder = $founder;
        $this->color = $color;

        $this->db = new \Source\Core\Database();
    }

    public function getById() {
        $query = "SELECT * FROM business WHERE id = :id";
        $stmt = $this->db->execute($query, [ "id" => $this->id ]);
        if($stmt->rowCount() == 0) return false;
        

        $business = $stmt->fetch();
        $this->id = $business->id;
        $this->name = $business->name;
        $this->slogan = $business->slogan;
        $this->worth = $business->worth;
        $this->founder = $business->founder;
        $this->color = $business->color;

        return $this;
    }

    public static function getAll() {
        $query = "SELECT * FROM business";
        $stmt = (new \Source\Core\Database())->execute($query, []);
        if($stmt->rowCount() == 0) return false; 

        $businesss = [];
        while($business = $stmt->fetch()) {
            $businesss[] = new Business(
                $business->id,
                $business->name, 
                $business->slogan, 
                $business->worth,
                $business->founder,
                $business->color,
            );
        }
        return $businesss;
    }

    public function getInfo() {
        return [
            "id" => $this->id,
            "username" => $this->name,
            "email" => $this->slogan,
            "worth" => $this->worth,
            "founder" => $this->founder,
            "color" => $this->color,

        ];
    }

    public function create() {
        $query = "SELECT * FROM business WHERE name = :name";
        $stmt = $this->db->execute($query, ["user" => $this->name]);
        if(!$stmt->rowCount() == 0) return [
            "result" => false,
            "result" => "used",
        ];
        $query = "INSERT INTO business(name) VALUES (:name)";
        $stmt = $this->db->execute($query, ["name" => $this->name]);

        $this->id = $this->db->getLastId();
        return ["user" => $stmt->fetch(), "result" => true];
    }
}
