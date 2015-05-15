<?php

namespace app\core;

use yii\base\Exception;
use yii\db\ActiveQuery;

class GridProviderEx extends GridProvider {

    /**
     * @var string|array class name of active record
     *  class for current grid component
     */
    public $model = null;

    /**
     * @var array|false with configuration for Pagination
     *  object, see parent's definition for more information
     *
     * @see Pagination
     */
    public $pagination = false;

    /**
     * @var array|false with configuration for Sort
     *  object, see parent's definition for more information
     */
    public $sort = false;

    /**
     * @var bool should widget renders table header with
     * 	information columns names and order directions
     */
    public $hasHeader = false;

    /**
     * @var bool should widget renders table footer with
     * 	extra table control elements and count information
     */
    public $hasFooter = false;

    /**
     * Override that method to return instance
     * of ActiveQuery class
     *
     * @return ActiveQuery class instance
     *
     * @throws Exception
     */
    public function getQuery() {
        if ($this->query) {
            return $this->query;
        }
        if (empty($this->model)) {
            throw new Exception("Grid provider model mustn't be empty field");
        }
        /** @var $ar \app\core\ActiveRecord */
        $ar = ObjectHelper::ensure($this->model, '\app\core\ActiveRecord');
        return $ar->find();
    }
}