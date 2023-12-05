<?php

namespace App\Helpers\SweetAlert;

use Illuminate\Session\Store;
use Illuminate\Support\Facades\Session;

class SweetAlert
{
    public static ?self $message = null;

    private SweetAlertType $alertType;
    private string $text;
    private ?string $title = null;
    private ?string $confirmButtonText = null;
    private ?string $confirmButtonColor = null;
    private ?string $cancelButtonText = null;
    private ?string $cancelButtonColor = null;
    private bool $showCancelButton = false;
    private ?string $url = null;
    private ?int $timer = null;
    private ?int $defaultTimer = 1500;

    public function __construct(SweetAlertType $alertType, string $text)
    {
        $this->alertType = $alertType;
        $this->text = $text;

        $this->update();
    }

    private function update(): self
    {
        session()->flash('swalData', $this->toArray());

        return $this;
    }

    public static function create(SweetAlertType $type, string $text): self
    {
        return new self($type, $text);
    }

    public static function createWarning(string $text): self
    {
        return self::create(SweetAlertType::warning, $text);
    }

    public static function createInfo(string $text): self
    {
        return self::create(SweetAlertType::info, $text);
    }

    public static function createSuccess(string $text): self
    {
        return self::create(SweetAlertType::success, $text);
    }

    public static function createError(string $text): self
    {
        return self::create(SweetAlertType::error, $text);
    }

    public static function createConfirm(string $text, string $url, ?string $title = null): self
    {
        $alert = self::create(SweetAlertType::warning, $text);
        $alert->setTitle($title);
        $alert->setConfirmButtonText('Confirm');
        $alert->setCancelButtonText('Cancel');
        $alert->setUrl($url);

        return $alert;
    }

    public function getAlertType(): SweetAlertType
    {
        return $this->alertType;
    }

    public function setAlertType(SweetAlertType $alertType): self
    {
        $this->alertType = $alertType;

        return $this->update();
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this->update();
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;


        return $this->update();
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this->update();
    }

    public function getTimer(): ?int
    {
        return $this->timer;
    }

    public function setTimer(?int $timer): self
    {
        $this->timer = $timer;

        return $this->update();
    }

    public function getDefaultTimer(): ?int
    {
        return $this->defaultTimer;
    }

    public function setDefaultTimer(?int $defaultTimer): self
    {
        $this->defaultTimer = $defaultTimer;

        return $this->update();
    }

    public function dontClose(): self
    {
        $this->setDefaultTimer(null);

        return $this->update();
    }

    public function getConfirmButtonText(): ?string
    {
        return $this->confirmButtonText;
    }

    public function setConfirmButtonText(?string $confirmButtonText): self
    {
        $this->confirmButtonText = $confirmButtonText;

        return $this->update();
    }

    public function getConfirmButtonColor(): ?string
    {
        return $this->confirmButtonColor;
    }

    public function setConfirmButtonColor(?string $confirmButtonColor): self
    {
        $this->confirmButtonColor = $confirmButtonColor;

        return $this->update();
    }

    public function getCancelButtonText(): ?string
    {
        return $this->cancelButtonText;
    }

    public function setCancelButtonText(?string $cancelButtonText): self
    {
        $this->cancelButtonText = $cancelButtonText;
        $this->setShowCancelButton(!empty($cancelButtonText));

        return $this->update();
    }

    public function getCancelButtonColor(): ?string
    {
        return $this->cancelButtonColor;
    }

    public function setCancelButtonColor(?string $cancelButtonColor): self
    {
        $this->cancelButtonColor = $cancelButtonColor;

        return $this->update();
    }

    public function isShowCancelButton(): bool
    {
        return $this->showCancelButton;
    }

    public function setShowCancelButton(bool $showCancelButton): self
    {
        $this->showCancelButton = $showCancelButton;

        return $this->update();
    }

    public function toArray(): array
    {
        $data = [
            'icon' => $this->getAlertType()->name,
            'html' => nl2br(strip_tags($this->getText(), '<br>')),
            'title' => $this->getTitle(),
        ];

        if ($this->getConfirmButtonText()) {
            $data['confirmButtonText'] = $this->getConfirmButtonText();
        }

        if ($this->getConfirmButtonColor()) {
            $data['confirmButtonColor'] = $this->getConfirmButtonColor();
        }

        if ($this->getCancelButtonText()) {
            $data['cancelButtonText'] = $this->getCancelButtonText();
        }

        if ($this->getCancelButtonColor()) {
            $data['cancelButtonColor'] = $this->getCancelButtonColor();
        }

        if ($this->isShowCancelButton()) {
            $data['showCancelButton'] = $this->isShowCancelButton();
        }

        if ($this->getUrl()) {
            $data['url'] = $this->getUrl();
        }

        if ($this->getTimer()) {
            $data['timer'] = $this->getTimer();
        }

        if ($this->getAlertType() === SweetAlertType::success && !isset($data['timer']) && is_int($this->getDefaultTimer())) {
            $data['timer'] = $this->getDefaultTimer();
        }

        return $data;
    }

    public static function hasMessage(): bool
    {
        return self::$message instanceof self || session()->has('swalData');
    }
}
