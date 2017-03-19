<?php
namespace Engine\baseModel;

use Engine\baseModel\getConnection;
use Engine\exception\ExceptionDB;

class Model
{
    protected
        $db,
        $query,
        $table;

    public $bindings = [
        'select' => [],
        'join' => [],
        'where' => [],
        'having' => [],
        'order' => [],
        'union' => [],
        'insert' => [],
        'update' => []
    ];

    public function __construct()
    {
        $this->db = getConnection::getInstance()->Connect();
    }

    /**
     * Просмотр полей
     * @param array $columns
     * @return $this
     */
    public function select($columns = ['*'])
    {
        $this->bindings['select'] = is_array($columns) ? $columns : func_get_args();
        return $this;
    }

    /**
     * Выборка
     * @param $column
     * @param null $operator
     * @param null $value
     * @param string $boolean
     * @return $this
     */
    public function where($column, $operator = null, $value = null, $boolean = '')
    {
        $this->bindings['where'][] = compact(
            'column', 'operator', 'value', 'boolean'
        );
        return $this;
    }

    /**
     * Вернуть запрос
     * @return string
     */
    public function toSql()
    {
        return $this->processSelect();
    }

    /**
     * + Условие
     * @param $column
     * @param null $operator
     * @param null $value
     * @param string $boolean
     * @return Model
     */
    public function andWhere($column, $operator = null, $value = null, $boolean = 'and')
    {
        return $this->where($column, $operator, $value, $boolean);
    }

    /**
     * или Условие
     * @param $column
     * @param null $operator
     * @param null $value
     * @param string $boolean
     * @return Model
     */
    public function orWhere($column, $operator = null, $value = null, $boolean = 'or')
    {
        return $this->where($column, $operator, $value, $boolean);
    }

    /**
     * inner join
     * @param $table
     * @param $column
     * @param null $operator
     * @param null $value
     * @return $this
     */
    public function join($table, $column, $operator = null, $value = null)
    {
        $this->bindings['join'][] = compact(
            'table', 'column', 'operator', 'value', 'boolean'
        );
        return $this;
    }

    /**
     * Собирание запроса на просмотр
     * @return string
     */
    public function processSelect()
    {
        $sql = "SELECT ";
        $select = implode($this->bindings['select'], ',   ');
        $sql .= "{$select}";
        $sql .= " FROM {$this->table}";
        $sql .= $this->buildWhere();
        $sql .= $this->buildJoin();
        return $sql;
    }

    /**
     * Постойка условия
     * @return string
     */
    public function buildWhere()
    {
        if (count($this->bindings['where']) > 0) {
            $sql .= " WHERE ";
            foreach ($this->bindings['where'] as $item) {
                $sql .= "{$item['boolean']} {$item['column']} {$item['operator']} '{$item['value']}'";
            }
            return $sql;
        }
    }

    /**
     * Постройка джоина
     * @return string
     */
    public function buildJoin ()
    {
        if (count($this->bindings['join']) > 0) {
            foreach ($this->bindings['join'] as $item) {
                $sql .= " JOIN {$item['table']} ON {$item['table']}.{$item['column']} {$item['operator']} {$item['value']}";
            }
            return $sql;
        }
    }

    /**
     * Получение данных + с возможностью просмотра полей
     * @param array $columns
     * @return array|ExceptionDB
     */
    public function get ($columns = ['*'])
    {
        if (count($this->bindings['select']) === 0) {
            $this->select($columns);
        }
        return $this->selectPrepare($this->processSelect ());
    }

    /**
     * поиск записи по id
     * @param $id
     * @return mixed
     */
    public function find ($id)
    {
        return $this->where('id', '=', $id)->get()[0];
    }

    /**
     * Просмотр из БД
     * @param $query
     * @return array|ExceptionDB
     */
    public function selectPrepare ($query)
    {
        $array = [];
        $rs = $this->db->prepare($query);
        $rs->execute();
        if (! $rs) {
            return (new \Engine\exception\ExceptionDB($rs->errorInfo()));
        }
        while ($row = $rs->fetchObject()) {
            $array[] = $row;
        }
        return $array;
    }

    /**
     * создание запроса на ввод
     * @return string
     */
    public function processInsert ()
    {
        $keys = implode(array_keys($this->bindings['insert']['data']), ', ');
        $bind = implode(array_keys($this->bindings['insert']['data']), ', :');

        $sql = "INSERT ".
                "INTO {$this->table} ({$keys}) VALUES (:{$bind})";
        return $sql;
    }

    /**
     * Ввод данных
     * @param $data
     * @return bool|ExceptionDB
     */
    public function insert ($data)
    {
        $this->bindings['insert'] = compact(
            'data'
        );
        return $this->insertPrepare ($this->processInsert ());
    }

    /**
     * Подготовленный запрос
     * @param $query
     * @return bool|ExceptionDB
     */
    public function insertPrepare ($query)
    {
        $rs = $this->db->prepare($query);
        if (! $rs->execute($this->bindings['insert']['data'])) {
            return (new \Engine\exception\ExceptionDB($rs->errorInfo()));
        }
        return true;
    }

    public function update ($data)
    {
        $this->bindings['update'] = compact(
            'data'
        );
        return $this->updatePrepare($this->processUpdate());
    }

    /**
     * создание запроса на изменение
     * @return string
     */
    public function processUpdate ()
    {
        $sql = "UPDATE {$this->table} ".
               "SET ";
        foreach ($this->bindings['update']['data'] as $key => &$value)
        {
            $newArray[] = "{$key} = '{$value}'";
        }
        $sql .= implode($newArray, ", ");
        $sql .= $this->buildWhere();
        return $sql;
    }

    /**
     * Подготовленный запрос
     * @param $query
     * @return bool|ExceptionDB
     */
    public function updatePrepare ($query)
    {
        $rs = $this->db->prepare($query);
        if (! $rs->execute($this->bindings['update']['data'])) {
            return (new \Engine\exception\ExceptionDB($rs->errorInfo()));
        }
        return true;
    }

    /**
     * удаление данных из таблицы
     * @return bool|ExceptionDB
     */
    public function delete ()
    {
        $sql = "DELETE " .
               "FROM {$this->table}";
        $sql .= $this->buildWhere();
        $rs = $this->db->prepare($sql);
        if (! $rs->execute()) {
            return (new \Engine\exception\ExceptionDB($rs->errorInfo()));
        }
        return true;
    }
}
