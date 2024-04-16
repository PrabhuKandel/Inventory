<?php
namespace App\Repositories;
use App\Models\Contact;
use App\Repositories\CommonRepository;
class ContactRepository extends CommonRepository{

  public function __construct(Contact $contact)
  {
    parent::__construct($contact);
  }

}