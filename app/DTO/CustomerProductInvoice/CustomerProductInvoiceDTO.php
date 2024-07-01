<?php

namespace App\DTO\CustomerProductInvoice;

use App\DTO\BaseDTO;
use Illuminate\Support\Arr;

class CustomerProductInvoiceDTO extends BaseDTO
{

    /**
     * @param string $due_date
     * @param ?int $customer_id
     * @param ?int $currency_id
     * @param ?array $invoice_items_product_id
     * @param ?array $invoice_items_count
     * @param ?array $invoice_taxes_tax_id
     */
    public function __construct(
        public string $due_date,
        public ?int    $customer_id,
        public ?int    $currency_id,
        public ?array  $invoice_items_product_id = [],
        public ?array  $invoice_items_count = [],
        public ?array  $invoice_taxes_tax_id = [],
    )
    {
    }

    public static function fromRequest($request): BaseDTO
    {
        return new self(
            due_date: $request->due_date,
            customer_id: $request->customer_id,
            currency_id: $request->currency_id,
            invoice_items_product_id: $request->invoice_items_product_id,
            invoice_items_count: $request->invoice_items_count,
            invoice_taxes_tax_id: $request->invoice_taxes_tax_id,
        );
    }


    /**
     * @param array $data
     * @return $this
     */
    public static function fromArray(array $data): BaseDTO
    {
        return new self(
            due_date: Arr::get($data, 'due_date'),
            customer_id: Arr::get($data, 'customer_id'),
            currency_id: Arr::get($data, 'currency_id'),
            invoice_items_product_id: Arr::get($data, 'invoice_items_product_id'),
            invoice_items_count: Arr::get($data, 'invoice_items_count'),
            invoice_taxes_tax_id: Arr::get($data, 'invoice_taxes_tax_id'),
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "due_date" => $this->due_date,
            "customer_id" => $this->customer_id,
            "currency_id" => $this->currency_id,
            "invoice_items_product_id" => $this->invoice_items_product_id,
            "invoice_items_count" => $this->invoice_items_count,
            "invoice_taxes_tax_id" => $this->invoice_taxes_tax_id,
        ];
    }

    public function invoiceData(): array
    {
        return [
            "due_date" => $this->due_date,
            "customer_id" => $this->customer_id,
            "currency_id" => $this->currency_id,
        ];
    }

    public function invoiceItems(): array
    {
        $data = [];
        for($i = 0; $i <count($this->invoice_items_product_id ?? []); $i++)
        {
            $data[$i]['product_id'] = $this->invoice_items_product_id[$i];
            $data[$i]['count'] = $this->invoice_items_count[$i];
        }
        return $data;
    }

    public function invoiceTaxes(): array
    {
        $data = [];
        for($i = 0; $i <count($this->invoice_taxes_tax_id ?? []); $i++)
        {
            $data[$i]['tax_id'] = $this->invoice_taxes_tax_id[$i];
        }
        return $data;
    }

}
