<?php

namespace App\Entity;


class Auth{

  private $email;

  private $pwd;

  public function getEmail( ) : ?string{
    return $this->email;
  }

  public function getPwd() : ?string {
    return $this->pwd;
  }

  public function setEmail(string $email): self
  {
      $this->email = $email;

      return $this;
  }

  public function setPwd(string $pwd): self
  {
      $this->pwd = $pwd;

      return $this;
  }
}
