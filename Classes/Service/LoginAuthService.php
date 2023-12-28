<?php

namespace NITSAN\NsT3dev\Service;


use NITSAN\NsSocialLogin\Utility\AuthUtility;
use TYPO3\CMS\Core\Authentication\AbstractAuthenticationService;
use TYPO3\CMS\Core\Authentication\AbstractUserAuthentication;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Crypto\PasswordHashing\InvalidPasswordHashException;
use TYPO3\CMS\Core\Crypto\PasswordHashing\PasswordHashFactory;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Resource\Exception\IllegalFileExtensionException;
use TYPO3\CMS\Core\Resource\Exception\InsufficientFileWritePermissionsException;
use TYPO3\CMS\Core\Resource\Exception\InsufficientFolderAccessPermissionsException;
use TYPO3\CMS\Core\Resource\Exception\InsufficientFolderWritePermissionsException;
use TYPO3\CMS\Core\Resource\Exception\InsufficientUserPermissionsException;
use TYPO3\CMS\Core\Resource\StorageRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;
use TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException;
use TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException;

class LoginAuthService extends AbstractAuthenticationService
{

    /**
     * @var Dispatcher
     */
    protected Dispatcher $signalSlotDispatcher;
    /**
     * 100
     */
    const STATUS_AUTHENTICATION_FAILURE_CONTINUE = 100;

    /**
     * 200 - authenticated and no more checking needed - useful for IP checking without password
     */
    const STATUS_AUTHENTICATION_SUCCESS_BREAK = 200;


    /**
     * Initializes authentication for this service.
     *
     * @param string $subType : Subtype for authentication (either "getUserFE" or "getUserBE")
     * @param array $loginData : Login data submitted by user and preprocessed by AbstractUserAuthentication
     * @param array $authenticationInformation : Additional TYPO3 information for authentication services (unused here)
     * @param AbstractUserAuthentication $parentObject Calling object
     * @return void
     */
    public function initAuth($subType, $loginData, $authenticationInformation, $parentObject): void
    {
        try {
            parent::initAuth($subType, $loginData, $authenticationInformation, $parentObject);
        } catch (\Exception $e) {
        }
    }

    /**
     * Find usergroup records
     *
     * @return bool User informations
     * @throws IllegalFileExtensionException
     * @throws InsufficientFileWritePermissionsException
     * @throws InsufficientFolderAccessPermissionsException
     * @throws InsufficientFolderWritePermissionsException
     * @throws InsufficientUserPermissionsException
     * @throws InvalidSlotException
     * @throws InvalidSlotReturnException
     */
    public function getUser()
    {
        $user = false;

        if (!empty($loginData)) {
            $user = $this->getUserInfos($loginData['uname']);
            if (isset($user['username'])) {
                $this->login['uname'] = $user['username'];
            }
            $this->signalSlotDispatcher->dispatch(__CLASS__, 'getUser', [&$user, $this]);
        }
        return $user;
    }

    protected function getUserInfos(int $uid): array
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('fe_users');
        $queryBuilder->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(DeletedRestriction::class));
        $res = $queryBuilder->select('*')
            ->from('fe_users')
            ->where(
                $queryBuilder->expr()->eq(
                    'username',
                    $queryBuilder->createNamedParameter((int)$uid, Connection::PARAM_INT)
                ),
            )
            ->execute()
            ->fetch();
        return $res;
    }

    /**
     * Authenticate user
     * @param array $user
     * @return int One of these values: 100 = Pass, 0 = Failed, 200 = Success
     */
    public function authUser(array $user): int
    {
        if (!$user) {
            return self::STATUS_AUTHENTICATION_FAILURE_CONTINUE;
        }
        $result = self::STATUS_AUTHENTICATION_FAILURE_CONTINUE;
        if ($user) {
            $result = self::STATUS_AUTHENTICATION_SUCCESS_BREAK;
        }
        //signal slot authUser
//        $this->signalSlotDispatcher->dispatch(__CLASS__, 'authUser', [$user, &$result, $this]);

        return $result;
    }
}
