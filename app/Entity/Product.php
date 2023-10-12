<?php

namespace Entity;

class Product
{
    private int $id;
    private string $name;
    private string $description;
    private int $price;
    private string $image_url;
    public function __construct(string $name, string $description, int $price, string $image_url)
    {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->image_url = $image_url;
    }


    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getImageUrl(): string
    {
        return $this->image_url;
    }

    public function getId(): int
    {
        return $this->id;
    }
}