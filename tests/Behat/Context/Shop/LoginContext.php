<?php


namespace Tests\BitBag\SyliusGraphqlPlugin\Behat\Context\Shop;

use Behat\Behat\Context\Context;
use Sylius\Behat\Service\SharedStorageInterface;
use Tests\BitBag\SyliusGraphqlPlugin\Behat\Client\GraphqlClient;
use Tests\BitBag\SyliusGraphqlPlugin\Behat\Client\GraphqlClientInterface;

final class LoginContext implements Context
{
    private GraphqlClientInterface $client;

    private SharedStorageInterface $sharedStorage;

    public function __construct(
        GraphqlClientInterface $client,
        SharedStorageInterface $sharedStorage
    )
    {
        $this->client = $client;
        $this->sharedStorage = $sharedStorage;
    }

    /**
     * @Given I prepare login operation with username :email and password :password
     */
    public function iPrepareLoginOperation(string $email, string $password): void
    {
        $expectedData = '
        shopUserToken{
            user {
                username
            }
            token
            refreshToken
        }';

        $operation = $this->client->prepareOperation('shop_loginShopUserToken', $expectedData);
        $operation->setVariables([
            'username' => $email,
            'password' => $password,
        ]);
        $this->sharedStorage->set(GraphqlClient::GRAPHQL_OPERATION, $operation);
    }

}
