<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Coupon;
use App\Models\Product;

class CouponComponent extends Component
{
    use WithPagination;

    public $coupon_id, $code, $discount_type = 'fixed', $max_uses, $start_date, $expiration_date, $active = 1, $discount_value, $searchCoupons = '', $searchProducts = '';
    public $selectedProducts = [], $editing = false;

    protected $paginationTheme = 'bootstrap';

    protected function rules()
    {
        return [
            'code' => 'required|string|max:50|unique:coupons,code,' . $this->coupon_id,
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'start_date' => 'nullable|date',
            'expiration_date' => 'nullable|date|after_or_equal:start_date',
            'active' => 'boolean',
            'selectedProducts' => 'array',
        ];
    }

    public function save()
    {
        $this->validate();

        $coupon = Coupon::updateOrCreate(
            ['id' => $this->coupon_id],
            [
                'code' => $this->code,
                'discount_type' => $this->discount_type,
                'discount_value' => $this->discount_value,
                'max_uses' => $this->max_uses,
                'start_date' => $this->start_date,
                'expiration_date' => $this->expiration_date,
                'active' => $this->active,
            ]
        );

        $coupon->products()->sync($this->selectedProducts);

        $this->resetForm();
        session()->flash('success', 'Cupón guardado con éxito.');
        $this->dispatch('closeModal');
    }

    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        $this->coupon_id = $coupon->id;
        $this->code = $coupon->code;
        $this->discount_type = $coupon->discount_type;
        $this->discount_value = $coupon->discount_value;
        $this->max_uses = $coupon->max_uses;
        $this->start_date = $coupon->start_date;
        $this->expiration_date = $coupon->expiration_date;
        $this->active = $coupon->active;
        $this->selectedProducts = $coupon->products()->pluck('products.id')->toArray(); // Especifica la tabla
        $this->editing = true;
    }


    public function delete($id)
    {
        Coupon::findOrFail($id)->delete();
        session()->flash('success', 'Cupón eliminado con éxito.');
    }

    public function toggleProduct($productId)
    {
        if (in_array($productId, $this->selectedProducts)) {
            $this->selectedProducts = array_diff($this->selectedProducts, [$productId]);
        } else {
            $this->selectedProducts[] = $productId;
        }
    }

    public function removeProduct($couponId, $productId)
    {
        $coupon = Coupon::findOrFail($couponId);
        $coupon->products()->detach($productId);
        session()->flash('success', 'Producto Eliminado.');
    }

    public function removeSelectedProduct($productId)
    {
        $this->selectedProducts = array_diff($this->selectedProducts, [$productId]);
    }

    public function resetForm()
    {
        $this->reset(['coupon_id', 'code', 'discount_type', 'discount_value', 'selectedProducts', 'editing', 'max_uses', 'start_date', 'expiration_date']);
    }

    public function updatedSearchCoupons()
    {
        $this->resetPage();
    }

    public function updatedSearchProducts()
    {
        $this->resetPage();
    }

    public function render()
    {
        $products = Product::where('name', 'like', "%{$this->searchProducts}%")->paginate(5);
        $coupons = Coupon::where('code', 'like', "%{$this->searchCoupons}%")->latest()->paginate(5);

        return view('livewire.admin.coupon-component', [
            'coupons' => $coupons,
            'products' => $products
        ])->extends('admin.layouts.app');
    }
}
