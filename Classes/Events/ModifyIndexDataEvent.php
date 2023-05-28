<?php

declare(strict_types=1);

/*
 * This file is part of the Extension "sf_event_mgt_indexer" for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Derhansen\SfEventMgtIndexer\Events;

/**
 * This event is triggered before sf_event_mgt event data is inserted to the index. It allows to modify:
 *
 * - additionalFields
 * - title
 * - fullcontent
 * - teaser
 */
final class ModifyIndexDataEvent
{
    protected string $title = '';
    protected string $teaser = '';
    protected string $fullContent = '';
    protected array $additionalFields = [];
    protected array $event = [];

    public function __construct(
        string $title,
        string $teaser,
        string $fullContent,
        array $additionalFields,
        array $event
    ) {
        $this->title = $title;
        $this->teaser = $teaser;
        $this->fullContent = $fullContent;
        $this->additionalFields = $additionalFields;
        $this->event = $event;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getTeaser(): string
    {
        return $this->teaser;
    }

    public function setTeaser(string $teaser): void
    {
        $this->teaser = $teaser;
    }

    public function getFullContent(): string
    {
        return $this->fullContent;
    }

    public function setFullContent(string $fullContent): void
    {
        $this->fullContent = $fullContent;
    }

    public function getAdditionalFields(): array
    {
        return $this->additionalFields;
    }

    public function setAdditionalFields(array $additionalFields): void
    {
        $this->additionalFields = $additionalFields;
    }

    public function getEvent(): array
    {
        return $this->event;
    }
}
