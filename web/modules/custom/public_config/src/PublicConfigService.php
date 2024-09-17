<?php

namespace Drupal\public_config;

use Drupal\Core\Config\ConfigFactoryInterface;

class PublicConfigService {
  protected $configFactory;

  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory;
  }

  public function getConfigItems() {
    $config = $this->configFactory->get('public_config.settings');
    $rawItems = $config->get('config_items');
    // dump($rawItems);
    return $this->parseItems($rawItems);
  }

  public function getMenuItems() {
    $config = $this->configFactory->get('public_config.settings');
    $rawItems = $config->get('menu_items');
    // dump($rawItems);
    return $this->parseItems($rawItems);
  }

  private function parseItems($rawItems) {
    $items = [];
    $lines = explode("\n", $rawItems);
    foreach ($lines as $line) {
      $parts = explode('|', $line, 2);
      if (count($parts) == 2) {
        $items[trim($parts[0])] = trim($parts[1]);
      }
    }
    return $items;
  }
}
