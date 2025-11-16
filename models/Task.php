<?php 

class Task {
    private ?int $id;
    private string $name;
    private string $description;
    private string $datetime; // O podrías usar un objeto \DateTime para más flexibilidad
    private int $project_id;
    private int $user_id;

    public function __construct(?int $id, string $name, string $description, string $datetime, int $project_id, int $user_id)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->datetime = $datetime;
        $this->project_id = $project_id;
        $this->user_id = $user_id;
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getName(): string
    {
        return $this->name;
    }
    
    public function getDescription(): string
    {
        return $this->description;
    }
    
    public function getDatetime(): string
    {
        return $this->datetime;
    }
    
    public function getProjectId(): int
    {
        return $this->project_id;
    }
    
    public function getUserId(): int
    {
        return $this->user_id;
    }
    
    public function __serialize(): array
    {
        // Serializa todas las propiedades del objeto automáticamente
        return get_object_vars($this);
    }
}
