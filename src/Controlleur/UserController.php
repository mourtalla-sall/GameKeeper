<?php
namespace Gamekeeper\Controlleur;

use Gamekeeper\Model\User;

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function register() {
        $error = '';
        if (isset($_POST['submit'])) {
            $firstName = trim($_POST['firstName']); 
            $lastName = trim($_POST['lastName']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];

            if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
                $error = "Tous les champs sont requis";
            } elseif ($password !== $confirmPassword) {
                $error = "Les mots de passe ne correspondent pas";
            } elseif (strlen($password) < 6) {
                $error = "Le mot de passe doit contenir au moins 6 caractères";
            } elseif ($this->userModel->emailexists($email)) {
                $error = "Cet email existe déjà";
            } else {
                if ($this->userModel->register($firstName, $lastName, $email, $password)) {
                    header("Location: index.php?page=login&success=1");
                    exit();
                } else {
                    $error = "Erreur lors de l'inscription";
                }
            }
        }
        return $error;
    }

    public function login() {
        $error = '';
        if (isset($_POST['submit'])) {
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            if (empty($email) || empty($password)) {
                $error = "Tous les champs sont requis";
            } else {
                $user = $this->userModel->login($email, $password);
                if ($user) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['firstName'] = $user['firstName'];
                    $_SESSION['role'] = $user['role'];
                    if ($user['role'] === 'admin') {
                        header("Location: index.php?page=admin/dashboard");
                        exit();
                    }
                    else{
                      header("Location: index.php?page=profil");
                        exit();  
                    } 
                } else {
                    $error = "Email ou mot de passe incorrect";
                }
            }
        }
        return $error;
    }

    public function profil() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit();
        }

        $error = '';
        $success = '';
        $user = $this->userModel->getuserbyid($_SESSION['user_id']);

        if (isset($_POST['update_profile'])) {
            $firstName = trim($_POST['firstName']);
            $lastName = trim($_POST['lastName']);
            $email = trim($_POST['email']);
            if (empty($firstName) || empty($lastName) || empty($email)) {
                $error = "Tous les champs sont requis";
            } elseif ($this->userModel->emailotheruser($email, $_SESSION['user_id'])) {
                $error = "Cet email est déjà utilisé";
            } else {
                if ($this->userModel->updateprofile($_SESSION['user_id'], $firstName, $lastName, $email)) {
                    $_SESSION['firstName'] = $firstName;
                    $success = "Profil mis à jour avec succès";
                    $user = $this->userModel->getuserbyid($_SESSION['user_id']);
                } else {
                    $error = "Erreur lors de la mise à jour";
                }
            }
        }

        if (isset($_POST['update_password'])) {
            $currentPassword = $_POST['current_password'];
            $newPassword = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];

            if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
                $error = "Tous les champs sont requis";
            } elseif ($newPassword !== $confirmPassword) {
                $error = "Les mots de passe ne correspondent pas";
            } elseif (strlen($newPassword) < 6) {
                $error = "Le mot de passe doit contenir au moins 6 caractères";
            } else {
                if ($this->userModel->updatepassword($_SESSION['user_id'], $currentPassword, $newPassword)) {
                    $success = "Mot de passe mis à jour avec succès";
                } else {
                    $error = "Mot de passe actuel incorrect";
                }
            }
        }

        return ['user' => $user, 'error' => $error, 'success' => $success];
    }
}