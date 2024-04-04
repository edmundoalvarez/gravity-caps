<?php 
namespace App\Auth;

use App\Models\Usuario;

class Autenticacion
{
    public function iniciarSesionAdmin(string $email , string $password): bool
    {

        $usuario = (new Usuario)->porEmail($email);


        if(!$usuario) return false;
        if($usuario->getRolFk() != 1) return false;
        if(!password_verify($password, $usuario->getPassword())) return false;

        $this->marcarComoAutenticado($usuario);
        return true;

    }

    public function iniciarSesionVisit(string $email , string $password): bool
    {

        $usuario = (new Usuario)->porEmail($email);


        if(!$usuario) return false;
        if($usuario->getRolFk() != 2) return false;
        if(!password_verify($password, $usuario->getPassword())) return false;

        $this->marcarComoAutenticado($usuario);
        return true;

    }

    public function marcarComoAutenticado(Usuario $usuario): void
    {
        $_SESSION['usuario_id'] = $usuario->getUsuarioId();
    }


    public function cerrarSesion(): void
    {
        unset($_SESSION['usuario_id']);
    }


    public function estaAutenticado(): bool
    {
        return isset($_SESSION['usuario_id']);
    }


    public function getUsuario(): ?usuario
    {
        if(!$this->estaAutenticado()) return null;

        return (new Usuario)->buscarId($_SESSION['usuario_id']);
    }


}