<?php


namespace App\Services;

use App\Repositories\OrderRepository;
use App\Traits\GeneralTrait;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    use GeneralTrait;

    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository=$orderRepository;
    }

    public function index()
    {

        $orders=$this->orderRepository->orders();

        if(is_null($orders))
        {
            throw new HttpResponseException(response()->json("not found"));
        }
        return $orders;

    }

    public function store($ap_id)
    {
        $appointment=$this->orderRepository->appointmentById($ap_id);
        if(!$appointment)
        {
            throw new HttpResponseException($this->returnError("404", "appointment not found!"));
        }
        $user_id = Auth::id();
        $currentDatetime=now();
        $date=Carbon::parse($currentDatetime)->format('Y-m-d');

        $notAllow = $this->orderRepository->orderExists($user_id,$date);


        if ($notAllow) {
            throw new HttpResponseException(response()->json('You have reached the maximum number of appointments for today'));
        }

        $order=$this->orderRepository->createOrder($appointment,$user_id,$date);

        return $order;
    }


    public function show($id)
    {
        $order=$this->orderRepository->getById($id);

        if(is_null($order))
        {
            throw new HttpResponseException(response()->json("order not found"));
        }

        return $order;
    }


    public function destroy($id)
    {
        $order=$this->orderRepository->getById($id);
        if(!$order)
        {
            throw new HttpResponseException(response()->json("not found"));
        }
        $order->delete();
    }

}
