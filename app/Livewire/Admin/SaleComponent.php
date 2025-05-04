<?php

namespace App\Livewire\Admin;

use App\Models\Brand;
use App\Models\Cashback;
use App\Models\Category;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Livewire\Component;
use Livewire\WithPagination;

class SaleComponent extends Component
{
    use WithPagination;

    public $cart = [];
    public $total = 0, $cashback = 0, $use_cashback = 0;
    public $paymentmethods = [];
    public $categorias = [];
    public $marcas = [];
    public $isOpenProcesar = 0;
    public $isOpenCliente = 0;
    public $name_client, $client_id, $payment_method_id;
    public $paid_with = 0;
    public $returned = 0;
    public $search = '';
    public $searchCustomer = '';
    public $categoriaSeleccionada = null;
    public $marcaSeleccionada = null;
    protected $queryString = ['search', 'searchCustomer'];
    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->paymentmethods = PaymentMethod::where('status', 'Activo')->get();
        $this->categorias = Category::all();
        $this->marcas = Brand::all();
    }

    public function agregarAlCarrito()
    {
        // Validar que el campo no esté vacío
        if (!$this->search) {
            return;
        }

        $producto = Product::where('barcode', $this->search)->first();

        if ($producto) {
            $this->addToCart($producto->id);
            $this->search = '';
        } else {
            session()->flash('error', 'Producto no encontrado.');
        }
    }

    public function addToCart($productId)
    {
        $product = Product::find($productId);

        if (!$product || $product->stock < 1) {
            session()->flash('error', 'El producto no está disponible o no tiene suficiente stock.');
            return;
        }

        $exists = collect($this->cart)->firstWhere('id', $productId);

        if ($exists) {
            $this->incrementQuantity($productId);
        } else {
            $this->cart[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->discount_price,
                'quantity' => 1,
                'subtotal' => $product->discount_price
            ];
        }

        $this->updateTotal();

        session()->flash('success', 'Producto Agregado.');
    }

    public function openModalProcesar()
    {
        $this->isOpenProcesar = true;
    }

    public function closeModalProcesar()
    {
        $this->isOpenProcesar = false;
    }

    public function openModalCliente()
    {
        $this->isOpenCliente = true;
    }

    public function closeModalCliente()
    {
        $this->isOpenCliente = false;
    }

    public function setClient(int $client_id)
    {
        $contact = User::with('cashbacks')->findOrFail($client_id);

        $this->client_id = $client_id;
        $this->name_client = $contact->name;

        $this->cashback = $contact->cashbacks()
            ->where('status', 'available')
            ->sum('amount');

        $this->closeModalCliente();
    }

    public function updatedPaidWith($value)
    {
        $this->returned = $value - ($this->total - $this->use_cashback);
    }

    public function updatedUseCashback($value)
    {
        $this->returned = $this->paid_with - ($this->total - $value);
    }

    public function incrementQuantity($productId)
    {
        foreach ($this->cart as &$item) {
            if ($item['id'] === $productId) {
                $product = Product::find($productId);

                if ($product->stock > $item['quantity']) {
                    $item['quantity']++;
                    $item['subtotal'] = $item['quantity'] * $item['price'];
                } else {
                    session()->flash('error', 'No hay suficiente stock para aumentar la cantidad.');
                }
                break;
            }
        }

        $this->updateTotal();
    }

    public function decrementQuantity($productId)
    {
        foreach ($this->cart as &$item) {
            if ($item['id'] === $productId) {
                if ($item['quantity'] > 1) {
                    $item['quantity']--;
                    $item['subtotal'] = $item['quantity'] * $item['price'];
                } else {
                    $this->removeFromCart($productId);
                }
                break;
            }
        }

        $this->updateTotal();
    }

    public function updatePrice($productId, $newPrice)
    {
        foreach ($this->cart as &$item) {
            if ($item['id'] === $productId) {
                if ($newPrice > 0) {
                    $item['price'] = $newPrice;
                    $item['subtotal'] = $item['quantity'] * $newPrice;
                } else {
                    session()->flash('error', 'El precio debe ser mayor a 0.');
                }
                break;
            }
        }

        $this->updateTotal();
    }

    public function removeFromCart($productId)
    {
        $this->cart = array_filter($this->cart, fn($item) => $item['id'] !== $productId);
        $this->updateTotal();
    }

    public function updateTotal()
    {
        $this->total = array_sum(array_column($this->cart, 'subtotal'));
    }

    public function saveSale()
    {
        if (empty($this->cart)) return $this->flashError('El carrito está vacío.');
        if (empty($this->client_id)) return $this->flashError('El Cliente es Requerido');
        if (empty($this->payment_method_id)) return $this->flashError('Forma de pago es Requerida');

        if ($this->cashback < $this->use_cashback) {
            return $this->flashError('El cliente no tiene suficiente cashback disponible.');
        }

        // ✅ Validar que el pago total (efectivo + cashback) cubre el total
        $totalPagado = ($this->paid_with ?: 0) + ($this->use_cashback ?: 0);
        if ($totalPagado < $this->total) {
            return $this->flashError('El pago + cashback no cubre el total de la venta.');
        }

        $sale = Sale::create([
            'total' => $this->total,
            'date' => date('Y-m-d'),
            'paid_with' => $this->paid_with ?: 0,
            'use_cashback' => $this->use_cashback ?: 0,
            'payment_method_id' => $this->payment_method_id ?: null,
            'user_id' => Auth::user()->id,
            'client_id' => $this->client_id ?: null,
        ]);

        foreach ($this->cart as $item) {
            $product = Product::find($item['id']);
            if ($product->stock < $item['quantity']) {
                return $this->flashError("El producto {$product->name} no tiene suficiente stock.");
            }

            SaleDetail::create([
                'sale_id' => $sale->id,
                'product_id' => $item['id'],
                'name_product' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
            $product->decrement('stock', $item['quantity']);
        }

        if ($this->use_cashback > 0) {
            $cashbacks = Cashback::where('user_id', Auth::user()->id)
                ->where('status', 'available')
                ->orderBy('created_at')
                ->get();

            $montoRestante = $this->use_cashback;
            foreach ($cashbacks as $cashback) {
                if ($montoRestante <= 0) break;

                if ($cashback->amount <= $montoRestante) {
                    $montoRestante -= $cashback->amount;
                    $cashback->update(['status' => 'used']);
                } else {
                    $cashback->update(['amount' => $cashback->amount - $montoRestante]);
                    $montoRestante = 0;
                }
            }
        }

        // Obtener el ID encriptado
        $sale_id_encrypted = Crypt::encrypt($sale->id);

        $this->reset('cart', 'total', 'paid_with', 'returned', 'payment_method_id');
        $this->closeModalProcesar();

        // Retornar la URL del ticket para la vista
        $this->dispatch('ticket-generated', ['url' => route('sale.generate.ticket', $sale_id_encrypted)]);
        session()->flash('success', 'Venta realizada con éxito.');
    }


    private function flashError($message)
    {
        session()->flash('error', $message);
        return;
    }

    public function filterByCategory($categoryId)
    {
        $this->categoriaSeleccionada = $categoryId;
        $this->render();  // Re-renderizar para aplicar el filtro
    }

    public function filterByBrand($brandId)
    {
        $this->marcaSeleccionada = $brandId;
        $this->render();  // Re-renderizar para aplicar el filtro
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->marcaSeleccionada = null;
        $this->categoriaSeleccionada = null;

        $this->resetPage(); // Por si estás usando paginación
    }


    public function render()
    {
        $searchTerm = '%' . $this->search . '%';
        $searchTermCustomer = '%' . $this->searchCustomer . '%';

        // Construcción de la consulta para los productos
        $products = Product::with('brand', 'category')
            ->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', $searchTerm)
                    ->orWhere('sku', 'like', $searchTerm);
            })
            // Filtro por categoría
            ->when($this->categoriaSeleccionada, function ($query) {
                $this->resetPage('productsPage');
                return $query->where('category_id', $this->categoriaSeleccionada);
            })
            // Filtro por marca
            ->when($this->marcaSeleccionada, function ($query) {
                $this->resetPage('productsPage');
                return $query->where('brand_id', $this->marcaSeleccionada);
            })
            ->orderBy('id', 'desc')
            ->paginate(9, ['*'], 'productsPage');

        // Consulta para los contactos
        $clients = User::whereDoesntHave('roles')
            ->where('name', 'like', $searchTermCustomer)
            ->orderBy('id', 'desc')
            ->paginate(9, ['*'], 'contactsPage');

        return view('livewire.admin.sale-component', compact('products', 'clients'))
            ->extends('admin.layouts.app');
    }
}
