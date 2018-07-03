<?php

namespace Drupal\silverpop;

use Drupal\Core\Utility\Token;
use Drupal\Core\Session\AccountInterface;

/**
 * A utility service providing functionality related to the silverpop module.
 */
class SilverpopService {

  /**
   * The token replacement utility class.
   *
   * @var \Drupal\Core\Utility\Token
   */
  protected $token;

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $account;

  /**
   * Constructs a new SilverpopService object.
   *
   * @param \Drupal\Core\Utility\Token $token
   *   The token replacement utility class.
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The current user account.
   */
  public function __construct(Token $token, AccountInterface $account) {
    $this->token = $token;
    $this->account = $account;
  }

  /**
   * Replaces tokens in the given event type data array.
   *
   * @param array $data
   *   An array containing key-value pairs for an event type.
   *
   * @return array
   *   The array with its tokens replaced.
   */
  public function replaceDataTokens(array $data) {
    if (empty($data)) {
      return [];
    }

    return array_reduce(
      $data,
      function ($carry, $item) {
        $item_parts = explode('|', $item);
        $carry[$item_parts[0]] = $this->token->replace(
          $item_parts[1],
          ['user' => $this->account]
        );
        return $carry;
      },
      []
    );
  }

}
