<?php

/**
 * Represents a database table with basic CRUD functionality
 */
abstract class Entity
{
    /**
     * @var string Table name
     */
    protected $tableName;

    /**
     * @var string columns
     */
    protected $columns;

    /**
     * @var Database
     */
    protected $database;

    /**
     * DatabaseTable constructor.
     */
    public function __construct()
    {
        $callClass = get_called_class();
        // fixme: camel case to snake case
        $this->tableName = strtolower($callClass);
        $this->database = new Database();

        /*foreach (array_keys(get_class_vars($callClass)) as $property) {
            if (property_exists(DatabaseTable::class, $property)) {
                continue;
            }
            $this->columns[] = $property;
        }*/

        $allProps = get_class_vars($callClass);
        $classProps = get_class_vars(get_class());
        $this->columns = array_keys(array_diff_key($allProps, $classProps));
    }

    /**
     * Will update or save the entity to the database
     */
    public function save()
    {
        $pdo = $this->database->getPdo();
        $data = [];
        foreach ($this->columns as $column) {
            $data[$column] = $this->$column;
        }

        if (is_numeric($this->getId())) {
            $sets = [];
            foreach ($this->columns as $column) {
                if ($column == 'id') {
                    continue;
                }
                $sets[] = $column . ' = :' . $column;
            }
            $sql = 'UPDATE ' . $this->tableName . ' SET ' . implode(', ', $sets) . ' WHERE id = :id';

            echo $sql;
            $query = $pdo->prepare($sql);
            $query->execute($data);
        } else {
            $sql = 'INSERT INTO ' . $this->tableName . ' (' . implode(',', $this->columns) . ')'
                . 'VALUES (:' . implode(',:', $this->columns) . ')';

            $query = $pdo->prepare($sql);
            $query->execute($data);
            $this->setId($pdo->lastInsertId());
        }
    }

    public function load() {
        $pdo = $this->database->getPdo();
        $data = [];
        $sql = 'SELECT ';

        implode(', ', array_keys($data));
        $sql .= ' FROM ' . $this->tableName . ' WHERE id = ?';

        $query = $pdo->prepare($sql);
        $result = $query->execute(['id' => $this->getId()]);


        var_dump($result);

    }

    abstract function getId();

    abstract function setId($id);
}