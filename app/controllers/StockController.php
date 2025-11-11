<?php
require_once BASE_PATH . '/app/models/StockTransaction.php';

class StockController
{
    public function index()
    {
        $limit = 100;
        $transactions = StockTransaction::all($limit);
        require BASE_PATH . '/app/views/stock/stock_list.php';
    }
}
