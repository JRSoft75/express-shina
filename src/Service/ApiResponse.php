<?php


namespace App\Service;


use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\HttpFoundation\Response;

class ApiResponse
{
    private array|object|null $data = null;

    private ?int $total = null;

    private ?bool $hasNext = null;

    private ?bool $success = true;

    private int $status = 200;


    public function setTotal(?int $count): ApiResponse
    {
        if ($count === null) {
            return $this;
        }
        $this->total = $count;

        return $this;
    }


    public function setData(array|object $data): ApiResponse
    {
        if (empty($data)) {
            return $this;
        }

        $this->data = $data;

        return $this;
    }

    /**
     * Return array of response data
     *
     * @return array
     */
    #[Pure]
    #[ArrayShape(['response' => "null|object", 'total' => "int|null", 'hasNext' => "bool|null", 'success' => "bool"])]
    public function getContent(): array
    {
        $result = ['success' => $this->success];

        if ($this->total !== null) {
            $result['total'] = $this->total;
        }

        if ($this->data !== null) {
            $result['response'] = $this->data;
        }

        if ($this->hasNext !== null) {
            $result['hasNext'] = $this->hasNext;
        }


        return $result;
    }

    public function getTotal(): ?int
    {
        return $this->total ?? null;
    }

    public function getStatus(): ?int
    {
        return $this->status ?? null;
    }

    public function setStatus(int $status): ApiResponse
    {
        $this->status = $status;

        return $this;
    }

    public function getHasNext(): ?bool
    {
        return $this->hasNext ?? null;
    }

    public function setHasNext(?bool $hasNext): self
    {
        $this->hasNext = $hasNext;

        return $this;
    }

    public function getSuccess(): ?bool
    {
        return $this->success ?? null;
    }

    public function setSuccess(?bool $success): self
    {
        $this->success = $success;

        return $this;
    }


}