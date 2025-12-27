<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $query = Order::query()->orderByDesc('created_at');
        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }
        if ($search = $request->get('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('phone', 'like', "%$search%")
                    ->orWhere('number', 'like', "%$search%")
                    ->orWhere('customer_name', 'like', "%$search%");
            });
        }
        $orders = $query->paginate(20)->withQueryString();
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load(['items.product', 'payments']);
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string',
            'note' => 'nullable|string'
        ]);
        $order->update(['status' => $request->status]);
        AuditLog::create([
            'order_id' => $order->id,
            'status' => $request->status,
            'note' => $request->note,
        ]);
        return redirect()->back()->with('status', 'Статус обновлён');
    }
}
