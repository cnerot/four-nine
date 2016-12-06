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
    public function getOneWhere($condition)
    {
        $result = $this->getWhere($condition);
        if (!$result) {
            return null;
        }
        return $result[0];
    }
    public function getWhere($condition = [], $order = null, $limit = null)
    {
        $columns = $this->tableName . '.' . implode(', ' . $this->tableName . '.', $this->columns);
        $linkedEntities = [];
        $joinStatements = '';
        // joined columns (we add them to the select)
        foreach ($this->joins as $join) {
            // init other models
            if (!isset($linkedEntities[$join['class']])) {
                $linkedEntities[$join['class']] = [
                    'entity' => new $join['class'](),
                    'alias' => $join['alias'],
                    'field' => $join['source'], // field to set later
                    'columns' => [] // column list using their aliases in the SELECT
                ];
            }
            // ex. output : user0.id AS user0_id, user0.name AS user0_name, ...
            foreach ($linkedEntities[$join['class']]['entity']->getColumns() as $colName) {
                $columns .= ', ' . $join['alias'] . '.' . $colName . ' AS ' . $join['alias'] . '_' . $colName . ' ';
                $linkedEntities[$join['class']]['columns'][] = $join['alias'] . '_' . $colName;
            }
            // e.g. for LEFT JOIN User ON Comment.userId = User.id
            $joinStatements .= ' LEFT JOIN ' . $join['table'] . ' ' . $join['alias'] . ' ON ' .
                $this->tableName . '.' . $join['source'] . ' = ' .
                $join['alias'] . '.' . $join['target'] . ' ';
        }
        // build select statement
        $baseQueryString = "SELECT " . $columns . " FROM " . $this->tableName;
        $execArgs = [];
        $baseQueryString .= $joinStatements;
        // where statement
        if (count($condition) > 0) {
            $baseQueryString .= ' WHERE ';
        }
        /* We now need to parse our condition list.
         * Conditions can be simple equals (A = 'a') or more complex conditions like a LIKE, <, >, ...
         * So, our condition array can look like this:
         * ['id' => 5], or like this: ['name' => ['operator' => 'like', 'value' => 'test']], or both at a time !
         */
        $conditionList = [];
        $wherePrefix = $this->tableName . '.';
        foreach ($condition as $key => &$value) {
            // if the value is an array, we have a "complex" operation, otherwise it's just a simple equals
            // to prevent code duplication, we transform our quick "equals" syntax to a full array
            if (!is_array($value)) {
                $value = [
                    'operator' => 'equals',
                    'value' => $value
                ];
            }
            switch ($value['operator']) {
                case 'equals':
                    $conditionList[] = $wherePrefix . $key . " = :" . $key;
                    break;
                case 'like':
                    $conditionList[] = $wherePrefix . $key . " LIKE CONCAT('%', :" . $key . ",'%') ";
                    break;
                case 'not like':
                    $conditionList[] = $wherePrefix . $key . " NOT LIKE CONCAT('%', :" . $key . ",'%') ";
                    break;
                case 'or':
                    $first = 0;
                    $or_query = '';
                    foreach ($value['value'] as $val) {
                        if ($first == 0) {
                            $or_query  .= $wherePrefix . $key . " = :" . $key . $first . " ";
                        } else {
                            $or_query .= ' OR ' . $wherePrefix . $key . " = :" . $key . $first . " ";
                        }
                        $first++;
                    }
                    $conditionList[] =$or_query;
                    break;
                default:
                    $errorMessage = get_called_class() . ' getWhere: ' . $value['operator'] . 'is not a valid operator';
                    Logger::error($errorMessage);
                    if (Config::ENV_DEBUG) {
                        echo '<h1>' . $errorMessage . '</h1>';
                        exit;
                    }
                    break;
            }
            // add the value to the "prepared" argument list
            if ($value['operator'] == 'or') {
                $first = 0;
                foreach ($value['value'] as $val) {
                    $execArgs[$key . $first] = $val;
                    $first++;
                }
            } else {
                $execArgs[$key] = $value['value'];
            }
        }
        // implode our condition list to a string, separated with AND to chain conditions
        // this behaviour could be changed in a way that accepts OR statements in the future
        // but we don't need them for now
        $baseQueryString .= implode(' AND ', $conditionList);
        // order by statement
        if ($order != null) {
            $baseQueryString .= ' ORDER BY ' . $order['column'] . ' ' . $order['direction'];
        }
        // limit statement
        if ($limit != null) {
            if (is_array($limit)) {
                $baseQueryString .= ' LIMIT ' . $limit[0] . "," . $limit[1];
            } else {
                $baseQueryString .= ' LIMIT ' . $limit;
            }
        }
        // all done!
        $query = $this->database->getPdo()->prepare($baseQueryString);
        $query->execute($execArgs);
        $callClass = get_called_class();
        // Display SQL errors
        if ($query->errorCode() != '00000') {
            // strategy: dev = display error and stop execution, prod = log and stop execution
            $error = 'entity ' . $callClass . ' : ' . implode(' ', $query->errorInfo());
            Logger::error('SQL Error on ' . $error . '; The failed query was: ' . $baseQueryString);
            if (Config::ENV_DEBUG) {
                echo '<h1>SQL Error</h1>' . ucfirst($error) . '<hr>';
            }
            // an unexpected error can have dramatic impact on the rest of the code (controllers, views, ...)
            exit;
        }
        $data = [];
        foreach ($query->fetchAll() as $row) {
            /** @var Entity $entity */
            $entity = new $callClass();
            $entity->fromArray($row);
            $entity->processLinkedEntities($linkedEntities, $row);
            $data[] = $entity;
        }
        return $data;
    }
}