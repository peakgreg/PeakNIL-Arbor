<?php
namespace API\V1\DTO\Profile;

class ProfileResponse {
    public string $firstName;
    public ?string $middleName;
    public string $lastName;
    public int $roleId;
    public ?string $gender;
    public ?string $profileDescription;
    public ?string $tags;
    public ?string $cardId;
    public ?string $schoolAssociation;
    public ?string $profileImagePath;
    public ?string $profileThumbnailPath;
    public ?string $profileImageStatus;
    public ?string $coverImagePath;
    public ?string $coverImageStatus;
    public ?string $position;
    public ?string $positionAbbreviation;
    public ?string $sportName;
    public ?string $sportAbbreviation;
    public ?string $sportIcon;
    public ?string $schoolNanoid;
    public ?string $schoolName;
    public ?string $schoolMascot;
    public ?string $schoolCoverImagePath;
    public ?string $schoolMarketplaceLogoPath;
    public array $flags;
    public array $socialMedia;
    public ?array $instagramStats;
    public ?array $tiktokStats;
    public ?array $xStats;
    public array $services;

    public function __construct(array $data) {
        $this->firstName = $data["first_name"] ?? "";
        $this->middleName = $data["middle_name"] ?? null;
        $this->lastName = $data["last_name"] ?? "";
        $this->roleId = (int)($data["role_id"] ?? 0);
        $this->gender = $data["gender"] ?? null;
        $this->profileDescription = $data["profile_description"] ?? null;
        $this->tags = $data["tags"] ?? null;
        $this->cardId = $data["card_id"] ?? null;
        $this->schoolAssociation = $data["school_association"] ?? null;
        $this->profileImagePath = $data["profile_image_path"] ?? null;
        $this->profileThumbnailPath = $data["profile_thumbnail_path"] ?? null;
        $this->profileImageStatus = $data["profile_image_status"] ?? null;
        $this->coverImagePath = $data["cover_image_path"] ?? null;
        $this->coverImageStatus = $data["cover_image_status"] ?? null;
        $this->position = $data["position"] ?? null;
        $this->positionAbbreviation = $data["position_abbreviation"] ?? null;
        $this->sportName = $data["sport_name"] ?? null;
        $this->sportAbbreviation = $data["sport_abbreviation"] ?? null;
        $this->sportIcon = $data["sport_icon"] ?? null;
        $this->schoolNanoid = $data["school_nanoid"] ?? null;
        $this->schoolName = $data["school_name"] ?? null;
        $this->schoolMascot = $data["school_mascot"] ?? null;
        $this->schoolCoverImagePath = $data["school_cover_image_path"] ?? null;
        $this->schoolMarketplaceLogoPath = $data["school_marketplace_logo_path"] ?? null;
        $this->flags = $data["flags"] ?? [];
        $this->socialMedia = $data["social_media"] ?? [];
        $this->instagramStats = $data["instagram_stats"] ?? null;
        $this->tiktokStats = $data["tiktok_stats"] ?? null;
        $this->xStats = $data["x_stats"] ?? null;
        $this->services = $data["services"] ?? [];
    }

    public function toArray(): array {
        return [
            "first_name" => $this->firstName,
            "middle_name" => $this->middleName,
            "last_name" => $this->lastName,
            "role_id" => $this->roleId,
            "gender" => $this->gender,
            "profile_description" => $this->profileDescription,
            "tags" => $this->tags,
            "card_id" => $this->cardId,
            "school_association" => $this->schoolAssociation,
            "profile_image_path" => $this->profileImagePath,
            "profile_thumbnail_path" => $this->profileThumbnailPath,
            "profile_image_status" => $this->profileImageStatus,
            "cover_image_path" => $this->coverImagePath,
            "cover_image_status" => $this->coverImageStatus,
            "position" => $this->position,
            "position_abbreviation" => $this->positionAbbreviation,
            "sport_name" => $this->sportName,
            "sport_abbreviation" => $this->sportAbbreviation,
            "sport_icon" => $this->sportIcon,
            "school_nanoid" => $this->schoolNanoid,
            "school_name" => $this->schoolName,
            "school_mascot" => $this->schoolMascot,
            "school_cover_image_path" => $this->schoolCoverImagePath,
            "school_marketplace_logo_path" => $this->schoolMarketplaceLogoPath,
            "flags" => $this->flags,
            "social_media" => $this->socialMedia,
            "instagram_stats" => $this->instagramStats,
            "tiktok_stats" => $this->tiktokStats,
            "x_stats" => $this->xStats,
            "services" => $this->services
        ];
    }
}
