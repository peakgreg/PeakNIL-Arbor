<?php
namespace API\V1\DTO\School;

class SchoolResponse {
    public string $nanoid;
    public string $name;
    public ?string $mascot;
    public ?string $coverPhotoUrl1;
    public ?string $marketplaceLogo;
    public ?string $description;
    public ?string $address;
    public ?string $city;
    public ?string $state;
    public ?string $zip;
    public ?string $phone;
    public ?string $website;
    public ?string $email;
    public ?array $socialMedia;
    public ?array $sports;
    public ?array $colors;

    public function __construct(array $data) {
        $this->nanoid = $data['nanoid'];
        $this->name = $data['name'];
        $this->mascot = $data['mascot'] ?? null;
        $this->coverPhotoUrl1 = $data['cover_photo_url_1'] ?? null;
        $this->marketplaceLogo = $data['marketplace_logo'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->address = $data['address'] ?? null;
        $this->city = $data['city'] ?? null;
        $this->state = $data['state'] ?? null;
        $this->zip = $data['zip'] ?? null;
        $this->phone = $data['phone'] ?? null;
        $this->website = $data['website'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->socialMedia = $data['social_media'] ?? null;
        $this->sports = $data['sports'] ?? null;
        $this->colors = $data['colors'] ?? null;
    }

    public function toArray(): array {
        return [
            'nanoid' => $this->nanoid,
            'name' => $this->name,
            'mascot' => $this->mascot,
            'cover_photo_url_1' => $this->coverPhotoUrl1,
            'marketplace_logo' => $this->marketplaceLogo,
            'description' => $this->description,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'zip' => $this->zip,
            'phone' => $this->phone,
            'website' => $this->website,
            'email' => $this->email,
            'social_media' => $this->socialMedia,
            'sports' => $this->sports,
            'colors' => $this->colors
        ];
    }
}
