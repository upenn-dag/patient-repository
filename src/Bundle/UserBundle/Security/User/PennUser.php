<?php

namespace Accard\Bundle\UserBundle\Security\User;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;

/**
 * Basic Penn-based user implementation
 *
 * @author Michael Woods <micwoods@mail.med.upenn.edu>
 */
class PennUser implements UserInterface
{
    /**
     * User ID
     *
     * @var string
     */
    protected $userId;

    /**
     * UserName
     *
     * @var string
     */
    protected $userName;

    /**
     * LDAP given name (givenName)
     *
     * @var string
     */
    protected $givenName;

    /**
     * LDAP surname (sn)
     *
     * @var string
     */
    protected $surName;

    /**
     * LDAP job title (title)
     *
     * @var string
     */
    protected $title;

    /**
     * LDAP mail (sn)
     *
     * @var string
     */
    protected $mail;

    /**
     * LDAP telephone number (telephoneNumber)
     *
     * @var string
     */
    protected $telephoneNumber;

    /**
     * Roles assigned to the user
     *
     * @var string[]
     */
    protected $roles;

    /**
     * Constructs a new User instance
     *
     * @param string $userid The user ID of the user
     * @param string $userName The user name of the user
     * @param string $givenName The given name of the user
     * @param string $surName The surname of the user
     * @param string|null $mail The job title of the user
     * @param string|null $mail The email address of the user
     * @param string|null $telephoneNumber The telephone number of the user
     * @param string[] roles
     */
    public function __construct($userId,
                                $userName,
                                $givenName,
                                $surName,
                                $title,
                                $mail,
                                $telephoneNumber,
                                $roles)
    {
        $this->userId          = $userId;
        $this->userName        = $userName;
        $this->givenName       = $givenName;
        $this->surName         = $surName;
        $this->title           = $title;
        $this->mail            = $mail;
        $this->telephoneNumber = $telephoneNumber;
        $this->roles           = $roles;
    }

    /**
     * Returns the user ID used to authenticate the user
     *
     * @return string
     */
    public function getUserID()
    {
        return $this->userId;
    }

    /**
     * Returns the user name used to authenticate the user
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Returns the LDAP given name of the user
     *
     * @return string
     */
    public function getGivenName()
    {
        return $this->givenName;
    }

    /**
     * Returns the LDAP surname of the user
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surName;
    }

    /**
     * Returns the LDAP job title of the user
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Returns the LDAP email address of the user
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Returns the LDAP telephone number of the user
     *
     * @return string
     */
    public function getTelephoneNumber()
    {
        return $this->telephoneNumber;
    }

    /**
     * Returns the roles granted to the user.
     *
     * @return string[]
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * Note: This implementation always returns null, as authentication is
     * handled by CoSign/Kerberos
     *
     * @return string
     */
    public function getPassword()
    {
        return null;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * Note: This implementation always returns null, as authentication is
     * handled by CoSign/Kerberos
     *
     * @return string|null
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
        // nothing for now
    }

    public function isEqualTo(UserInterface $user)
    {
        if ($user === null || !$user instanceof User) {
            return false;
        }

        return $user->getUserName() === $this->getUserName();
    }

    public function __toString()
    {
        return sprintf(
            "%s (%s)",
            ucwords(strtolower($this->getGivenName() . ' ' . $this->getSurname())),
            $this->getUserName()
        );
    }
}
