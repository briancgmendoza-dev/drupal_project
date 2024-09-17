<?php

namespace Drupal\public_config\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Drupal\public_config\PublicConfigService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @RestResource(
 *   id = "public_config",
 *   label = @Translation("Public Config"),
 *   uri_paths = {
 *     "canonical" = "/api/public-config"
 *   }
 * )
 */
class PublicConfigResource extends ResourceBase {

  protected $publicConfigService;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, $serializer_formats, $logger, PublicConfigService $publicConfigService) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $serializer_formats, $logger);
    $this->publicConfigService = $publicConfigService;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->getParameter('serializer.formats'),
      $container->get('logger.factory')->get('rest'),
      $container->get('public_config.service')
    );
  }

  public function get() {
    $data = [
      'config_items' => $this->publicConfigService->getConfigItems(),
      'menu_items' => $this->publicConfigService->getMenuItems(),
    ];
    // dump($data);
    // die;
    return new ResourceResponse($data);
  }
}
