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
        $this->tableName = lcfirst($callClass);
        $this->database = new Database();
        $allProps = get_class_vars($callClass);
        $classProps = get_class_vars(get_class());
        $this->columns = array_keys(array_diff_key($allProps, $classProps));
    }
    
    public function savePicture($bgImage){
        $dir = '/media/images/';
        $ext = strtolower( pathinfo($bgImage['name'], PATHINFO_EXTENSION) );
        $file=uniqid().'.'.$ext;

         //**** on bouge l'image
        move_uploaded_file($bgImage['tmp_name'], $dir.$file);
    }
    /**
     * Will update or save the entity to the database
     *
     * TODO: return whether or not it succeeded
     */
    public function save()
    {
        $pdo = $this->database->getPdo();
        $data = [];
        foreach ($this->columns as $column) {
            $value = $this->$column;
            if ($value instanceof Entity) {
                $value = $value->getId();
            }
            $data[$column] = $value;
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
            //echo $sql;
            $query = $pdo->prepare($sql);
            $query->execute($data);
            $this->handlePDOError($query);
        } else {
            $sql = 'INSERT INTO ' . $this->tableName . ' (' . implode(',', $this->columns) . ')'
                . 'VALUES (:' . implode(',:', $this->columns) . ')';
            $query = $pdo->prepare($sql);
            $query->execute($data);
            $this->handlePDOError($query);
            $this->setId($pdo->lastInsertId());
        }
        return $this->getId();
    }
    /**
     * Deletes this entity from the database
     */
    public function delete()
    {
        $pdo = $this->database->getPdo();
        $sql = "DELETE FROM " . $this->tableName . " where id = :id";
        $query = $pdo->prepare($sql);
        $query->execute([
            'id' => $this->getId()
        ]);
        $callClass = get_called_class();
        if ($query->errorCode() != '00000') {
            // strategy: dev = display error and stop execution, prod = log and stop execution
            $error = 'entity ' . $callClass . ' : ' . implode(' ', $query->errorInfo());
            Logger::error('SQL Error on ' . $error);
            // an unexpected error can have dramatic impact on the rest of the code (controllers, views, ...)
            return $query->errorCode();
        }
        return true;
    }
    /**
     * @param $query PDOStatement
     */
    public function handlePDOError($query)
    {
        if ($query->errorCode() != '00000') {
            // strategy: dev = display error and stop execution, prod = log and stop execution
            $error = 'entity ' . get_called_class() . ' : ' . implode(' ', $query->errorInfo());
            Logger::log('SQL Error on ' . $error);
            // an unexpected error can have dramatic impact on the rest of the code (controllers, views, ...)
            exit;
        }
    }
    /**
     * Returns a collection of this entity
     * @param $condition
     * You can specify other types of conditions in this parameter. e.g. for an = and a LIKE :
     *  ['id' => 3, 'name' => ['operator' => 'like']]
     * Supported operators are at the moment : 'equals' (default), 'like'
     * @param $order array|null null for no ordering or e.g. ['column' => 'id', 'direction' => 'DESC']
     * @param $limit null|int number of items to get
     * @return array
     * todo: multpile order by
     */
    public function getWhere($condition = [], $order = null, $limit = null, $debug = false)
    {
        // table columns (assumes there is at least 1 column in the entity)
        $columns = $this->tableName . '.' . implode(', ' . $this->tableName . '.', $this->columns);
        $linkedEntities = [];
        $joinStatements = '';
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
				case 'greater':
					$conditionList[] = $wherePrefix . $key . " > :" . $key;
                    break;
				case 'less':
					$conditionList[] = $wherePrefix . $key . " < :" . $key;
                    break;
				case 'greater_equal':
					$conditionList[] = $wherePrefix . $key . " >= :" . $key;
                    break;
				case 'less_equal':
					$conditionList[] = $wherePrefix . $key . " <= :" . $key;
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
        if ($debug){
            var_dump($baseQueryString);
            var_dump($execArgs);
            die();
        }
        // all done!
        $query = $this->database->getPdo()->prepare($baseQueryString);
        $query->execute($execArgs);
        $callClass = get_called_class();
        // Display SQL errors
        if ($query->errorCode() != '00000') {
            // strategy: dev = display error and stop execution, prod = log and stop execution
            $error = 'entity ' . $callClass . ' : ' . implode(' ', $query->errorInfo());
            var_dump('SQL Error on ' . $error . '; The failed query was: ' . $baseQueryString);
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
    /**
     * Returns one item of this entity
     * @param $condition
     * @return mixed|null
     */
    public function getOneWhere($condition)
    {
        $result = $this->getWhere($condition);
        if (!$result) {
            return null;
        }
        return $result[0];
    }
    /**
     * Sets the linked entities data to this current Entity instance
     * e.g. populates the "author" field with a populated User Entity
     * @param $linkedEntities
     * @param $data
     */
    public function processLinkedEntities($linkedEntities, $data)
    {
        // sets this fieldName (e.g. user) to the entity data we gathered, meaning that in example
        // $this->user = a User Entity instance
        foreach ($linkedEntities as &$linkedEntity) {
            /** @var Entity $entity */
            $entity = $linkedEntity['entity'];
            $entity->fromArray($data, $linkedEntity['alias'] . '_');
            if (property_exists(get_called_class(), $linkedEntity['field'])) {
                $fieldName = $linkedEntity['field'];
                $this->$fieldName = clone $entity;
            }
        }
    }
    /**
     * Builds the entity from an array of data
     * @param $data
     * @param string $prefix column prefix
     */
    public function fromArray($data, $prefix = '')
    {
        foreach ($data as $colName => $value) {
            if ($prefix != '') {
                // if there is a prefix, we skip the columns not begining with the prefix
                if (substr($colName, 0, strlen($prefix)) != $prefix) {
                    continue;
                } else {
                    // if it does begin with the prefix, we cut it out
                    $colName = substr($colName, strlen($prefix));
                }
            }
            if (!property_exists(get_called_class(), $colName)) {
                continue;
            }
            $this->$colName = $value;
        }
    }
    /**
     * @return array column list
     */
    public function getColumns()
    {
        return $this->columns;
    }
    abstract function getId();
    abstract function setId($id);
}