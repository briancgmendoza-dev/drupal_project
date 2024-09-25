<?php

namespace Drupal\live_event\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * @RestResource(
 *   id = "live_event",
 *   label = @Translation("Live "),
 *   uri_paths = {
 *     "canonical" = "/api/live_event/link"
 *   }
 * )
 */
class LiveEventResource extends ResourceBase {

  public function __construct(array $configuration, $plugin_id, $plugin_definition, $serializer_formats, $logger) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $serializer_formats, $logger);
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->getParameter('serializer.formats'),
      $container->get('logger.factory')->get('rest')
    );
  }

  public function get() {
    // $current_user = \Drupal::currentUser();
    // $user_id = $current_user->id();
    $request = \Drupal::request();
    $user_id = $request->query->get('user_id');
    $client = \Drupal::service('live_event.client');
    $link = $client->getLiveEventLinkById($user_id);
    // dump($user_id);

    if (!$link) {
      // Use generic error response
      throw new HttpException(404, t("User ID:$user_id doesn't exists."));
    }

    $response = new ResourceResponse($link);
    $disable_cache = new \Drupal\Core\Cache\CacheableMetadata();
    $disable_cache->setCacheMaxAge(0);
    $response->addCacheableDependency($disable_cache);

    return $response;
  }
}
