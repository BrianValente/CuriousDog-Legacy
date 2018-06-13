<?php
/**
 * Created by IntelliJ IDEA.
 * User: brianvalente
 * Date: 6/1/17
 * Time: 17:07
 */

namespace Ask\Database;

use mysqli_result;

class Query {
    /**
     * @var array
     */
    private $select;

    /**
     * @var string
     */
    private $from;

    /**
     * @var array
     */
    private $where;

    /**
     * @var array
     */
    public const ALL = ['*'];

    /**
     * @var string
     */
    public const NOT_NULL = "NOT NULL";

    public function select(array $columns): Query {
        $this->select = $columns;
        return $this;
    }

    public function from(string $table): Query {
        $this->from = $table;
        return $this;
    }

    public function where(array $conditions): Query {
        $this->where = $conditions;
        return $this;
    }

    public function execute(): ?mysqli_result {
        $sql = "";
        $select = "";

        if ($this->select != null) {
            if ($this->select === Query::ALL) {
                $select = '*';
            } else {
                for ($i = 0; $i < count($this->select); $i++) {
                    $select .= $this->select[$i];
                    if ($i - 1 != count($this->select))
                        $select .= ',';
                }
            }
            
            $sql .= 'SELECT ' . $select . ' FROM ' . $this->from . ' ';
            
            if ($this->where != null) {
                
            }
        }

        echo $sql;
        return null;
    }
}