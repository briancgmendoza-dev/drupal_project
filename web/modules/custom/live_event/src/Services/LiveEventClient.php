<?php
namespace Drupal\live_event\Services;

use Drupal\Core\Database\Connection;

class LiveEventClient {
    protected $database;

    public function __construct(Connection $database) {
        $this->database = $database;
    }

    public function getLiveEventLinkById($user_id = null) {
        $link = $this->database
          ->select('live_event_table', 'u')
          ->fields('u', ['link'])
          ->condition('user_id', $user_id)
          ->execute()->fetchField();

        if ($link) {
            return ['link' => $link];
        }

        return null;
    }
}
