<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use App\Traits\GeneralTrait;

class OrderController extends Controller
{
    use GeneralTrait;

    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService=$orderService;
    }

    public function index()
    {
        $orders=$this->orderService->index();
        return response()->json($orders);

    }

    public function store($ap_id)
    {
        $order=$this->orderService->store($ap_id);
        return response()->json($order);
    }


    public function show($id)
    {
        $order=$this->orderService->show($id);

        return response()->json($order);
    }


    public function destroy($id)
    {
        $this->orderService->destroy($id);
        return response()->json("deleted");
    }


}

