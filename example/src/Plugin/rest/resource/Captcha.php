<?php

namespace Drupal\example\Plugin\rest\resource;

use Drupal\Component\Serialization\Json;
use Drupal\example\AppRepository;
use Drupal\rest\ModifiedResourceResponse;
use Drupal\rest\Plugin\ResourceBase;
use Psr\Log\LoggerInterface;
use GuzzleHttp\ClientInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Google captcha verification.
 *
 * @RestResource(
 *   id = "es_captcha",
 *   label = @Translation("Google Captcha"),
 *   serialization_class = "",
 *   uri_paths = {
 *     "create" = "/api/captcha"
 *   }
 * )
 */
class Captcha extends ResourceBase {
  /**
   * The HTTP client to do requests.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected $httpClient;

  /**
   * The ES Repository.
   *
   * @var \Drupal\example\AppRepository
   */
  protected $repository;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration,
  $plugin_id,
  $plugin_definition,
  array $serializer_formats,
  LoggerInterface $logger,
  ClientInterface $httpClient,
  AppRepository $repository
    ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $serializer_formats, $logger);
    $this->httpClient = $httpClient;
    $this->repository = $repository;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
          $configuration,
          $plugin_id,
          $plugin_definition,
          $container->getParameter('serializer.formats'),
          $container->get('logger.factory')->get('rest'),
          $container->get('http_client'),
          $container->get('example.repository'),
      );
  }

  /**
   * {@inheritdoc}
   */
  public function post($data) {
    $secretKey = $this->repository->config->get('captcha_secret_key');
    if (empty($data) || empty($data['response']) || empty($secretKey)) {
      return new ModifiedResourceResponse(
        ['code' => 400, 'message' => $this->t('Missing parameter.')],
        Response::HTTP_BAD_REQUEST
      );
    }

    // API Request.
    $request_uri = 'https://www.google.com/recaptcha/api/siteverify';
    $params = [
      'secret' => $secretKey,
      'response' => $data['response'],
      'remoteip' => $data['remoteip'],
    ];

    try {
      $request = $this->httpClient
        ->post($request_uri,
          [
            'form_params' => $params,
          ]);
      $api_response = Json::decode($request->getBody()->getContents());
      return new ModifiedResourceResponse(
        $api_response,
        Response::HTTP_OK
      );
    }
    catch (\Exception $error) {
      $responseError = $error->getResponse();
      $responseErrorAsString = $responseError->getBody()->getContents();
      $errorData = Json::decode($responseErrorAsString);
      return new ModifiedResourceResponse(
        ['code' => 400, 'message' => $errorData->message],
        Response::HTTP_BAD_REQUEST
      );
    }
  }

}
