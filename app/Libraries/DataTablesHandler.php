<?php

namespace App\Libraries;

use CodeIgniter\HTTP\RequestInterface;

class DataTablesHandler
{
    protected $request;
    protected $allowedOrderColumns = [];
    public $defaultOrderColumn = 'created_at';

    public function __construct(?RequestInterface $request = null)
    {
        $this->request = $request ?? service('request');
    }

    public function setAllowedOrderColumns(array $columns): self
    {
        $this->allowedOrderColumns = $columns;
        return $this;
    }

    public function process()
    {
        $draw   = (int) $this->request->getVar('draw');
        $start  = (int) $this->request->getVar('start');
        $length = (int) $this->request->getVar('length');

        $searchValue = $this->request->getVar('search[value]');
        $columns     = $this->request->getVar('columns');
        $orderIndex  = $this->request->getVar('order[0][column]');
        $orderDir    = strtolower($this->request->getVar('order[0][dir]'));

        // Validasi dan sanitasi order
        $orderBy = $this->defaultOrderColumn; // default
        if (isset($columns[$orderIndex]['name']) && in_array($columns[$orderIndex]['name'], $this->allowedOrderColumns)) {
            $orderBy = $columns[$orderIndex]['name'];
        }

        $orderDir = in_array($orderDir, ['asc', 'desc']) ? $orderDir : 'asc';

        return [
            'draw'       => $draw,
            'start'      => $start,
            'length'     => $length < 0 ? false : $length,
            'search'     => $searchValue,
            'orderBy'    => $orderBy,
            'orderDir'   => $orderDir,
        ];
    }
}
