<?php

namespace Controller;

use Model\UserCard;

class UserCardController
{
    private $userCardModel;

    public function __construct()
    {
        require_once __DIR__ . '/../Model/UserCard.php';
        $this->userCardModel = new UserCard();
    }

    public function list($id_user){
        
        return $this->userCardModel->getCardsByUserId($id_user);
    }

    public function add($data){

        return $this->userCardModel->addCard($data);
    }

    public function delete($id_card, $id_user){

        return $this->userCardModel->deleteCard($id_card, $id_user);
    }

    public function setDefault($id_card, $id_user){

        return $this->userCardModel->setDefaultCard($id_card, $id_user);
    }

    public function getDefault($id_user){

        return $this->userCardModel->getDefaultCard($id_user);
    }
}
